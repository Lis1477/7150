<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Characteristic;
use App\CharacteristicItem;
use Illuminate\Support\Collection;

class CategoryController extends Controller
{
    public function index(Request $request, $id, $slug)
    {

        // берем данные категории
        $category = Category::where('id_1c', $id)->first();
        $data['current_cat'] = $category;

        // смотрим, есть ли дочерние категории
        $subs = Category::where([['parent_id_1c', $category->id_1c], ['display', 1]])->orderBy('order')->get();

        // определяем уровень вложенности категории
        if($category->parent_id_1c > 0) {
            $parent = Category::where('id_1c', $category->parent_id_1c)->first()->parent_id_1c;
            if($parent > 0) {
                $cat_level = 3;
            } else {
                $cat_level = 2;
            }
        } else {
            $cat_level = 1;
        }

        // собираем данные для Хлебных крошек ********************************
        $collect = new Collection;
        if($cat_level == 1) {
            // добавляем только 1-й уровень
            $collect->push([
                'id_1c' => $category->id_1c,
                'all_cats' => Category::where([['parent_id_1c', 0], ['display', 1]])->orderBy('order')->get(),
            ]);
        } elseif($cat_level == 2) {
            // добавляем 1-й уровень
            $collect->push([
                'id_1c' => $category->parent_id_1c,
                'all_cats' => Category::where([['parent_id_1c', 0], ['display', 1]])->orderBy('order')->get(),
            ]);
            // добавляем 2-й уровень
            $collect->push([
                'id_1c' => $category->id_1c,
                'all_cats' => Category::where([['parent_id_1c', $category->parent_id_1c], ['display', 1]])->orderBy('order')->get(),
            ]);
        } else { // если у категории 3-й уровень
            // добавляем 1-й уровень
            $collect->push([
                'id_1c' => $parent,
                'all_cats' => Category::where([['parent_id_1c', 0], ['display', 1]])->orderBy('order')->get(),
            ]);

            // добавляем 2-й уровень
            $collect->push([
                'id_1c' => $category->parent_id_1c,
                'all_cats' => Category::where([['parent_id_1c', $parent], ['display', 1]])->orderBy('order')->get(),
            ]);

            // добавляем 3-й уровень
            $collect->push([
                'id_1c' => $category->id_1c,
                'all_cats' => Category::where([['parent_id_1c', $category->parent_id_1c], ['display', 1]])->orderBy('order')->get(),
            ]);
        }
        $data['bread_crumbs'] = $collect;
        $data['bread_crumbs_type'] = "category";

        // для метатега title
        if(trim($category->title)) {
            $title = $category->title;
        } else {
            $title = $category->name;
        }
        $data['title'] = $title;

        // для метатэга keywords
        $keywords = trim($category->keywords);
        $data['keywords'] = $keywords;

        // для метатэга description
        $description = trim($category->description);
        $data['description'] = $description;

        //********************************************************************

        // если есть дочерние категории или вложенность менее 3-го уровня
        if($subs->count() && $cat_level < 3) {

            // записываем в дату
            $data['sub_cats'] = $subs;

            // выбираем популярные товары категории **********************
            // собираем id_1c подкатегорий
            $cat_id_1c = $subs->pluck('id_1c')->toArray();

            // собираем id_1c под-подкатегорий
            $child_cat_id = Category::whereIn('parent_id_1c', $cat_id_1c)->get(['id_1c'])->pluck('id_1c')->toArray();

            // если не пусто, добавляем в массив
            if($child_cat_id) {
                $cat_id_1c = array_merge($cat_id_1c, $child_cat_id);
            }

            $popular_items = Item::where('count', '>', 0)
                ->whereIn('category_id_1c', $cat_id_1c)
                ->orderBy('visite_counter', 'desc')
                ->limit(24)
                ->get();
            $data['popular_items'] = $popular_items;

            //*************************************************************

            // выводим страницу категорий
            return view('category_page')->with($data);

        // если нет дочерних категорий, выводим товары
        } else {

            // определяем количество выводимых товаров
            if(isset($request->items) && ($request->items == 40 || $request->items == 60)) {
                $paginate_num = $request->items;
            } else {
                $paginate_num = 20;
            }
            $data['paginate_num'] = $paginate_num;

            // определяем параметр сортировки
            if(isset($request->sort) && ($request->sort == "new_items" || $request->sort == "low_price" || $request->sort == "high_price" || $request->sort == "actions" || $request->sort == "comments")) {
                $sort_parameter = $request->sort;
            } else {
               $sort_parameter = "popular";
            }
            $data['sort_parameter'] = $sort_parameter;

            // смотрим, есть ли товары у категории
            $cat_items = Item::where([['category_id_1c', $category->id_1c], ['count', '>', 0], ['for_sale', 1]])->first();

            // если есть
            if($cat_items) {

                // берем товары категории
                $items_obj = Item::where([['category_id_1c', $category->id_1c], ['count', '>', 0], ['for_sale', 1]]);

            } else { // если нет

                // берем id категорий 4-го уровня
                $child_cat_id = Category::where('parent_id_1c', $category->id_1c)->pluck('id_1c')->toArray('id_1c');

                // берем товары категорий
                $items_obj = Item::whereIn('category_id_1c', $child_cat_id)
                    ->where([['count', '>', 0], ['for_sale', 1]]);
            }

            $items_obj_filters = clone $items_obj;

            // в зависимости от параметра сортировки
            if($sort_parameter == "popular") {
                $items = $items_obj->orderByDesc('visite_counter')->orderBy('name');
            } elseif($sort_parameter == "new_items") {
                $items = $items_obj->orderByDesc('is_new_item')->orderBy('name');
            } elseif($sort_parameter == "low_price") {
                $items = $items_obj->orderBy('price')->orderBy('name');
            } elseif($sort_parameter == "high_price") {
                $items = $items_obj->orderByDesc('price')->orderBy('name');
            } elseif($sort_parameter == "actions") {
                $items = $items_obj->orderByDesc('is_action')->orderBy('name');
            } elseif($sort_parameter == "comments") {
                $items = $items_obj->orderByDesc('comment_counter')->orderBy('name');
            }
            $data['items'] = $items->paginate($paginate_num);

            // данные для фильтров ***************************************************************
            // минимальная и максимальная цена
            $min_max_price = $items_obj_filters->orderBy('price')->get(['price', 'id_1c']);

            $data['min_price'] = $min_max_price->first()->price;
            $data['max_price'] = $min_max_price->last()->price;

            // берем характеристики категории
            $parameters = new Characteristic;
            $parameters = $parameters
                ->setConnection('mysql2')
                ->where('category_1c_id', $id)
                ->get();

            // берем коды товаров
            $item_codes = $min_max_price->pluck('id_1c')->toArray();

            $arr = [];
            foreach($item_codes as $code) {

                // берем значения характеристик
                $char_val = new CharacteristicItem;
                $char_val = $char_val
                    ->setConnection('mysql2')
                    ->where('item_1c_id', $code)
                    ->get();

                // формируем массив: Характеристика - массив значений
                foreach($char_val as $char) {

                    $par = $parameters->where('1c_id', $char->characteristic_1c_id)->first();
                    $name = $par->name;
                    $unit = $par->unit;
                    if($unit) {
                        $unit = ", ".$unit;
                    }

                    $index = $name.$unit;
                    $arr[$index][] = $char->value;
                    $arr[$index] = array_unique($arr[$index]);
                    sort($arr[$index]);
                }
            }

            $data['chars'] = $arr;
            //***************************************************************************************

            // выводим страницу товаров
            return view('items_page')->with($data);
        }
    }

    public function discountedItems(Request $request)
    {
        // определяем количество выводимых товаров
        if(isset($request->items) && ($request->items == 40 || $request->items == 60)) {
            $paginate_num = $request->items;
        } else {
            $paginate_num = 20;
        }
        $data['paginate_num'] = $paginate_num;

        // определяем параметр сортировки
        if(isset($request->sort) && ($request->sort == "new_items" || $request->sort == "low_price" || $request->sort == "high_price" || $request->sort == "actions" || $request->sort == "comments")) {
            $sort_parameter = $request->sort;
        } else {
           $sort_parameter = "popular";
        }
        $data['sort_parameter'] = $sort_parameter;

        // берем товары категрии
        $items = Item::where([['category_id_1c', 3149], ['count', '>', 0], ['for_sale', 1]]);

        // в зависимости от параметра сортировки
        if($sort_parameter == "popular") {
            $items = $items->orderByDesc('visite_counter')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "new_items") {
            $items = $items->orderByDesc('is_new_item')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "low_price") {
            $items = $items->orderBy('price')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "high_price") {
            $items = $items->orderByDesc('price')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "actions") {
            $items = $items->orderByDesc('is_action')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "comments") {
            $items = $items->orderByDesc('comment_counter')->orderBy('name')->paginate($paginate_num);
        }
        $data['items'] = $items;

        // выводим страницу товаров
        return view('discounted_items_page')->with($data);
    }

    public function newItems(Request $request)
    {
        // определяем количество выводимых товаров
        if(isset($request->items) && ($request->items == 40 || $request->items == 60)) {
            $paginate_num = $request->items;
        } else {
            $paginate_num = 20;
        }
        $data['paginate_num'] = $paginate_num;

        // определяем параметр сортировки
        if(isset($request->sort) && ($request->sort == "new_items" || $request->sort == "low_price" || $request->sort == "high_price" || $request->sort == "actions" || $request->sort == "comments")) {
            $sort_parameter = $request->sort;
        } else {
           $sort_parameter = "popular";
        }
        $data['sort_parameter'] = $sort_parameter;

        // берем товары категрии
        $items_obj = Item::where([['is_new_item', 1], ['count', '>', 0], ['for_sale', 1]]);

        // в зависимости от параметра сортировки
        if($sort_parameter == "popular") {
            $items = $items_obj->orderByDesc('visite_counter')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "new_items") {
            $items = $items_obj->orderByDesc('is_new_item')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "low_price") {
            $items = $items_obj->orderBy('price')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "high_price") {
            $items = $items_obj->orderByDesc('price')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "actions") {
            $items = $items_obj->orderByDesc('is_action')->orderBy('name')->paginate($paginate_num);
        } elseif($sort_parameter == "comments") {
            $items = $items_obj->orderByDesc('comment_counter')->orderBy('name')->paginate($paginate_num);
        }
        $data['items'] = $items;

        // данные для фильтров ***************************************************************
        // минимальная и максимальная цена
        $min_price = Item::where([['is_new_item', 1], ['count', '>', 0], ['for_sale', 1]])
            ->orderBy('price')
            ->first(['price'])
            ->price;
        $data['min_price'] = $min_price;
        $max_price = Item::where([['is_new_item', 1], ['count', '>', 0], ['for_sale', 1]])
            ->orderByDesc('price')
            ->first(['price'])
            ->price;
        $data['max_price'] = $max_price;

        // собираем коды категорий
        $cat_arr = array_unique($items_obj->pluck('category_id_1c')->toArray());

        // собираем категории
        $cats = Category::whereIn('id_1c', $cat_arr)->orderBy('name')->get(['id_1c', 'name']);
        $data['cats'] = $cats;
        //***********************************************************************************
// dd($min_price, $max_price);


        // выводим страницу товаров
        return view('new_items_page')->with($data);
    }

}
