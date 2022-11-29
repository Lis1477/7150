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
        // $data['search_string'] = htmlentities($search_str, ENT_HTML5);
        $data['search_string'] = $search_str;

        // переводим строку в нижний регистр
        $search_string = mb_strtolower($search_str);

        // применяем англо-русский switch
        $en_to_ru = $this->switcher_ru($search_string);

        // применяем русско-английский switch
        $ru_to_en = $this->switcher_en($search_string);

        // объединяем строки
        $ru_en_str = $en_to_ru." ".$ru_to_en;

        // делим строку на слова, очищаем от пробелов, пустых значений, повторений
        $words_arr = array_unique(array_filter(explode(" ", trim($ru_en_str))));
        foreach($words_arr as $key => $value) {
            // если слово меньше 2 символов, исключаем
            if(mb_strlen($value) < 3) {
                unset($words_arr[$key]);
                continue;
            }

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

        // собираем id_1c товаров ***********************************************
        $all_items_id = [];
        // массив id_1c товаров по полной фразе
        $full_str_items_id = [];
        // берем оригинальную строку, делим на слова, очищаем от пробелов, пустых значений, считаем количество
        $words_count = count(array_filter(explode(" ", $search_str)));
        // если слов больше 2
        if($words_count > 2) {
            // собираем id_1c товаров
            $full_str_items_id = Item::where([['name', 'like', '%'.$search_string.'%'], ['count', '>', 0], ['for_sale', 1]])
                ->orderBy('name')
                ->pluck('id_1c')
                ->toArray('id_1c');
        }

        // если не пусто, дописываем
        if(count($full_str_items_id)) {
            $all_items_id = array_merge($all_items_id, $full_str_items_id);
        }

        // массив id_1c товаров по всем словам одновременно
        $all_words_items_id = [];
        $all_words_arr = array_filter(explode(" ", $search_str));
        // если слов больше 1, формируем запрос для выборки
        if(count($all_words_arr) > 1) {
            $words_request = "";
            foreach($all_words_arr as $key => $value) {
                // если в слове есть символы, кроме букв и цифр, исключаем
                // узнаем длину исходного слова
                $length_val = mb_strlen($value);
                // очищаем от ненужных символов
                $str_new = preg_replace('/[^ a-zа-яё\d]/ui', '',$value );
                // узнаем длину нового слова
                $length_new = mb_strlen($str_new);
                // если длины не равны , удаляем
                if($length_val != $length_new) {
                    continue;
                }
                $words_request .= " AND name like '%".$value."%'";
            }

            $all_words_items = DB::select("select id_1c, name from items where count > 0 AND for_sale = 1 ".$words_request." order by name");
            // если не пусто, собираем id_1c
            if(count($all_words_items)) {
                foreach($all_words_items as $item) {
                    array_push($all_words_items_id, $item->id_1c);
                }
            }
        }
        // если не пусто, дописываем, берем уникальные
        if(count($all_words_items_id)) {
            $all_items_id = array_unique(array_merge($all_items_id, $all_words_items_id));
        }

        // массив id_1c товаров по первому слову ********************************
        $first_word_items_id = Item::where([['name', 'like', $words_arr[0].'%'], ['count', '>', 0], ['for_sale', 1]])
            ->whereNotIn('id_1c', $all_items_id)
            ->orderBy('name')
            ->pluck('id_1c')
            ->toArray('id_1c');

        // если не пусто, дописываем
        if(count($first_word_items_id)) {
            $all_items_id = array_merge($all_items_id, $first_word_items_id);
        }

        // собираем массив id_1c товаров по словам **************************************
        $word_items_id = [];
        foreach($words_arr as $word) {
            if(count($all_items_id)) { // если есть товары по полной строке, исключам из выборки
                $items_id = Item::where([['name', 'like', '%'.$word.'%'], ['count', '>', 0], ['for_sale', 1]])
                    ->whereNotIn('id_1c', $all_items_id)
                    ->orderBy('name')
                    ->pluck('id_1c')->toArray();
            } else {
                $items_id = Item::where([['name', 'like', '%'.$word.'%'], ['count', '>', 0], ['for_sale', 1]])
                ->orderBy('name')
                ->pluck('id_1c')
                ->toArray();
            }
            // если не пусто, объединяем, берем уникальные
            if(count($items_id)) {
                $word_items_id = array_unique(array_merge($word_items_id, $items_id));
            }
        }

        // если не пусто, дописываем, берем уникальные
        if(count($word_items_id)) {
            $all_items_id = array_unique(array_merge($all_items_id, $word_items_id));
        }

        // если ajax запрос **********************************************************************************
        if(\Route::currentRouteName() == "ajax-search") {
            // содаем соллекцию категорий ****************************
            $categories = new Collection;
            foreach($words_arr as $word) {
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
            if($sort_parameter == "normal") {
                $items = new Collection();
                foreach($all_items_id as $id_1c) {
                    $item = Item::where('id_1c', $id_1c)->first();
                    if($item) {
                        $items->push($item);
                    }
                }
                $items = $items->paginate($paginate_num);
            } elseif($sort_parameter == "popular") {
                $items = Item::whereIn('id_1c', $all_items_id)->orderByDesc('visite_counter')->orderBy('name')->paginate($paginate_num);
            } elseif($sort_parameter == "new_items") {
                $items = Item::whereIn('id_1c', $all_items_id)->orderByDesc('is_new_item')->orderBy('name')->paginate($paginate_num);
            } elseif($sort_parameter == "low_price") {
                $items = Item::whereIn('id_1c', $all_items_id)->orderBy('price')->orderBy('name')->paginate($paginate_num);
            } elseif($sort_parameter == "high_price") {
                $items = Item::whereIn('id_1c', $all_items_id)->orderByDesc('price')->orderBy('name')->paginate($paginate_num);
            } elseif($sort_parameter == "actions") {
                $items = Item::whereIn('id_1c', $all_items_id)->orderByDesc('is_action')->orderBy('name')->paginate($paginate_num);
            } elseif($sort_parameter == "comments") {
                $items = Item::whereIn('id_1c', $all_items_id)->orderByDesc('comment_counter')->orderBy('name')->paginate($paginate_num);
            }

            $data['items'] = $items;

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
