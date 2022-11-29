<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Item;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        // берем строку
        $search_str = trim($request->search_string);
        $data['search_string'] = $search_str;

        // переводим строку в нижний регистр
        $search_string = mb_strtolower($search_str);

        // собираем id_1c товаров
        $all_items_id = [];

        // для строки как есть **********************************
        // делим строку слова, очищаем от пробелов, пустых значений, повторений, переиндексируем
        $words_as_is = array_values(array_unique(array_filter(explode(" ", trim($search_str)))));
        // собираем id_1c
        $words_as_is_items = Item::where([['count', '>', 0], ['for_sale', 1]]);

        $items_name = clone $words_as_is_items;
        $items_syn = clone $words_as_is_items;

        foreach($words_as_is as $value) {
            $items_name_id = $items_name->where('name', 'like', '%'.$value.'%')->orderBy('name')->pluck('id_1c')->toArray();
            $items_syn_id = $items_syn->where('synonyms', 'like', '%'.$value.'%')->orderBy('name')->pluck('id_1c')->toArray();
        }

        // если не пусто, дописываем
        if(count($items_name_id)) {
            $all_items_id = array_merge($all_items_id, $items_name_id);
        }
        if(count($items_syn_id)) {
            $all_items_id = array_merge($all_items_id, $items_syn_id);
        }

        // для строки с en_ru свитчем ****************************
        // применяем англо-русский switch
        $words_en_to_ru_str = $this->switcher_ru($search_string);
        // делим строку слова, очищаем от пробелов, пустых значений, повторений, переиндексируем
        $words_en_to_ru = array_values(array_unique(array_filter(explode(" ", trim($words_en_to_ru_str)))));
        // собираем id_1c
        $words_en_to_ru_items = Item::where([['count', '>', 0], ['for_sale', 1]]);

        $items_name = clone $words_en_to_ru_items;
        $items_syn = clone $words_en_to_ru_items;

        foreach($words_en_to_ru as $value) {
            $items_name_id = $items_name->where('name', 'like', '%'.$value.'%')->orderBy('name')->pluck('id_1c')->toArray();
            $items_syn_id = $items_syn->where('synonyms', 'like', '%'.$value.'%')->orderBy('name')->pluck('id_1c')->toArray();
        }

        // если не пусто, дописываем
        if(count($items_name_id)) {
            $all_items_id = array_merge($all_items_id, $items_name_id);
        }
        if(count($items_syn_id)) {
            $all_items_id = array_merge($all_items_id, $items_syn_id);
        }

        // для строки с ru_en свитчем ****************************
        // применяем русско-английский switch
        $words_ru_to_en_str = $this->switcher_en($search_string);
        // делим строку слова, очищаем от пробелов, пустых значений, повторений, переиндексируем
        $words_ru_to_en = array_values(array_unique(array_filter(explode(" ", trim($words_ru_to_en_str)))));
        // собираем id_1c
        $words_ru_to_en_items = Item::where([['count', '>', 0], ['for_sale', 1]]);

        foreach($words_ru_to_en as $value) {
            $items_name_id = $items_name->where('name', 'like', '%'.$value.'%')->orderBy('name')->pluck('id_1c')->toArray();
            $items_syn_id = $items_syn->where('synonyms', 'like', '%'.$value.'%')->orderBy('name')->pluck('id_1c')->toArray();
        }

        // если не пусто, дописываем
        if(count($items_name_id)) {
            $all_items_id = array_merge($all_items_id, $items_name_id);
        }
        if(count($items_syn_id)) {
            $all_items_id = array_merge($all_items_id, $items_syn_id);
        }

        $all_items_id = array_unique($all_items_id);

        // собираем словоформы
        $words_str = $search_string." ".$words_en_to_ru_str." ".$words_ru_to_en_str;
        $words_arr = array_unique(array_filter(explode(" ", $words_str)));

        foreach($words_arr as $key => $value) {

            // если в слове есть символы, кроме букв и цифр, исключаем
            // узнаем длину исходного слова
            $length_val = mb_strlen($value);
            // очищаем от ненужных символов
            $str_new = preg_replace('/[^ a-zа-яё\d]/ui', '',$value );
            // узнаем длину нового слова
            $length_new = mb_strlen($str_new);
            // если длины не равны , удаляем
            if($length_val != $length_new) {
                unset($words_arr[$key]);
                continue;
            }

            // первый символ заглавный
            $big_first = mb_strtoupper(mb_substr($value, 0, 1)).mb_substr($value, 1);
            // добавляем в массив
            array_push($words_arr, $big_first);
            // все символы заглавные
            $big_all = mb_strtoupper($value);
            // добавляем в массив
            array_push($words_arr, $big_all);
        }
        // периндексация массива
        $words_arr = array_values($words_arr);
        // добавляем к данным
        $data['words_arr'] = $words_arr;

        // если ajax запрос **********************************************************************************
        if(\Route::currentRouteName() == "ajax-search") {
            // содаем соллекцию категорий ****************************
            $categories = new Collection;
            foreach($words_arr as $word) {

                // если слово меньше 2 символов, исключаем
                if(mb_strlen($word) < 3) {
                    continue;
                }

                $cats = Category::where([['name', 'like', '%'.$word.'%'], ['display', 1]])
                    ->get(['name', 'id_1c', 'slug', 'parent_id_1c']);
                if($cats->count()) {
                    foreach($cats as $cat) {

                        // исли уровень вложенности категории 4, пропускаем
                        // определяем уровень вложенности категории
                        $cat_view = true;
                        if($cat->parent_id_1c > 0) {
                            $parent = Category::where('id_1c', $cat->parent_id_1c)->first(['parent_id_1c'])->parent_id_1c;
                            if($parent > 0) {
                                $parent_2 = Category::where('id_1c', $parent)->first(['parent_id_1c'])->parent_id_1c;
                                if($parent_2 > 0) {
                                    $cat_view = false;
                                }
                            }
                        }
                        if(!$cat_view) {
                            continue;
                        }

                        // дописываем
                        $categories->push([
                            'name' => $cat->name,
                            'id_1c' => $cat->id_1c,
                            'slug' => $cat->slug,
                        ]);
                    }
                }
            }
            // удаляем дубликаты
            $data['categories'] = $categories->unique()->sortBy('name');

            // создаем коллекцию товаров

            // общее количество найденного товара
            $items_count = count($all_items_id);
            $data['items_count'] = $items_count;

            // количество выгружаемых товаров
            $item_lines = 15;
            // обрезаем до этого количества
            $items_id = array_slice($all_items_id, 0, $item_lines);

            // собираем товары  **********************************************************
            $items = new Collection();

            foreach($items_id as $id_1c) {
                $item = Item::where('id_1c', $id_1c)->first(['name', 'id_1c', 'slug']);
                if($item) {
                    $items->push($item);
                }
            }
            $data['items'] = $items;

            return view('includes.ajax_search')->with($data);

        } elseif(\Route::currentRouteName() == "get-search") {
            // собираем товары  **********************************************************
            if(!count($all_items_id)) {
                $data['items'] = '';
            } else {
                // определяем количество выводимых товаров
                if(isset($request->items) && ($request->items == 40 || $request->items == 60)) {
                    $paginate_num = $request->items;
                } else {
                    $paginate_num = 20;
                }
                $data['paginate_num'] = $paginate_num;

                // определяем параметр сортировки
                if(isset($request->sort) && ($request->sort == "popular" || $request->sort == "new_items" || $request->sort == "low_price" || $request->sort == "high_price" || $request->sort == "actions" || $request->sort == "comments")) {
                    $sort_parameter = $request->sort;
                } else {
                   $sort_parameter = "normal";
                }
                $data['sort_parameter'] = $sort_parameter;

                // в зависимости от параметра сортировки собираем товары

                // собираем товары
                $items_obj = Item::whereIn('id_1c', $all_items_id);

                // сортируем
                $items = clone $items_obj;
                if($sort_parameter == "normal") {
                    $items = $items->orderBy('name');
                } elseif($sort_parameter == "popular") {
                    $items = $items->orderByDesc('visite_counter')->orderBy('name');
                } elseif($sort_parameter == "new_items") {
                    $items = $items->orderByDesc('is_new_item')->orderBy('name');
                } elseif($sort_parameter == "low_price") {
                    $items = $items->orderBy('price')->orderBy('name');
                } elseif($sort_parameter == "high_price") {
                    $items = $items->orderByDesc('price')->orderBy('name');
                } elseif($sort_parameter == "actions") {
                    $items = $items->orderByDesc('is_action')->orderBy('name');
                } elseif($sort_parameter == "comments") {
                    $items = $items->orderByDesc('comment_counter')->orderBy('name');
                }

                $items = $items->paginate($paginate_num);
    // dd($all_items_id);
                $data['items'] = $items;

                // данные для фильтров ***************************************************************
                // минимальная и максимальная цена
                $min_price = clone $items_obj;
                $min_price = $min_price->orderBy('price')->first()->price;
                $data['min_price'] = $min_price;

                $max_price = clone $items_obj;
                $max_price = $max_price->orderByDesc('price')->first()->price;
                $data['max_price'] = $max_price;

                // собираем коды категорий
                $cat_arr = array_unique($items_obj->pluck('category_id_1c')->toArray());

                // собираем категории
                $cats = Category::whereIn('id_1c', $cat_arr)->orderBy('name')->get(['id_1c', 'name']);
                $data['cats'] = $cats;
            }
            //***********************************************************************************

            return view('search_result_page')->with($data);

        } else {
            return "ОШИБКА!";
        }

    }

    private function switcher_ru($value)
    {
        $converter = array(
            'f' => 'а', ',' => 'б', 'd' => 'в', 'u' => 'г', 'l' => 'д', 't' => 'е', '`' => 'ё',
            ';' => 'ж', 'p' => 'з', 'b' => 'и', 'q' => 'й', 'r' => 'к', 'k' => 'л', 'v' => 'м',
            'y' => 'н', 'j' => 'о', 'g' => 'п', 'h' => 'р', 'c' => 'с', 'n' => 'т', 'e' => 'у',
            'a' => 'ф', '[' => 'х', 'w' => 'ц', 'x' => 'ч', 'i' => 'ш', 'o' => 'щ', 'm' => 'ь',
            's' => 'ы', ']' => 'ъ', "'" => "э", '.' => 'ю', 'z' => 'я',                 
     
            'F' => 'А', '<' => 'Б', 'D' => 'В', 'U' => 'Г', 'L' => 'Д', 'T' => 'Е', '~' => 'Ё',
            ':' => 'Ж', 'P' => 'З', 'B' => 'И', 'Q' => 'Й', 'R' => 'К', 'K' => 'Л', 'V' => 'М',
            'Y' => 'Н', 'J' => 'О', 'G' => 'П', 'H' => 'Р', 'C' => 'С', 'N' => 'Т', 'E' => 'У',
            'A' => 'Ф', '{' => 'Х', 'W' => 'Ц', 'X' => 'Ч', 'I' => 'Ш', 'O' => 'Щ', 'M' => 'Ь',
            'S' => 'Ы', '}' => 'Ъ', '"' => 'Э', '>' => 'Ю', 'Z' => 'Я',                 
     
            '@' => '"', '#' => '№', '$' => ';', '^' => ':', '&' => '?', '/' => '.', '?' => ',',
        );

        $value = strtr($value, $converter);
        return $value;

    }

    private function switcher_en($value)
    {
        $converter = array(
            'а' => 'f', 'б' => ',', 'в' => 'd', 'г' => 'u', 'д' => 'l', 'е' => 't', 'ё' => '`',
            'ж' => ';', 'з' => 'p', 'и' => 'b', 'й' => 'q', 'к' => 'r', 'л' => 'k', 'м' => 'v',
            'н' => 'y', 'о' => 'j', 'п' => 'g', 'р' => 'h', 'с' => 'c', 'т' => 'n', 'у' => 'e',
            'ф' => 'a', 'х' => '[', 'ц' => 'w', 'ч' => 'x', 'ш' => 'i', 'щ' => 'o', 'ь' => 'm',
            'ы' => 's', 'ъ' => ']', 'э' => "'", 'ю' => '.', 'я' => 'z',
     
            'А' => 'F', 'Б' => '<', 'В' => 'D', 'Г' => 'U', 'Д' => 'L', 'Е' => 'T', 'Ё' => '~',
            'Ж' => ':', 'З' => 'P', 'И' => 'B', 'Й' => 'Q', 'К' => 'R', 'Л' => 'K', 'М' => 'V',
            'Н' => 'Y', 'О' => 'J', 'П' => 'G', 'Р' => 'H', 'С' => 'C', 'Т' => 'N', 'У' => 'E',
            'Ф' => 'A', 'Х' => '{', 'Ц' => 'W', 'Ч' => 'X', 'Ш' => 'I', 'Щ' => 'O', 'Ь' => 'M',
            'Ы' => 'S', 'Ъ' => '}', 'Э' => '"', 'Ю' => '>', 'Я' => 'Z',
            
            '"' => '@', '№' => '#', ';' => '$', ':' => '^', '?' => '&', '.' => '/', ',' => '?',
        );
     
        $value = strtr($value, $converter);
        return $value;
    }

}
