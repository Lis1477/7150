<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Category;
use App\Brand;
use Illuminate\Support\Collection;
use Cookie;
use DB;

class ItemController extends Controller
{
    public function index(Request $request, $id, $slug)
    {
        // берем товар
        $item = Item::where('id_1c', $id)->first();

        // если товар существует, продолжаем
        if($item) {

            $data['item'] = $item;
            
            // добавляем в куки просмотренный товар
            if($request->cookie('seen')) $s = $request->cookie('seen');
            $s[] = $id;
            $s = array_unique($s);
            Cookie::queue('seen', $s, 720); // срок действия 12 часов

            // добавляем к просмотрам 1
            Item::where('id_1c', $id)->update([
                'visite_counter' => $item->visite_counter + 1
            ]);

            // собираем характеристики товара ************************************
            $alfa_item = new Item;
            $alfa_item = $alfa_item
                ->setConnection('mysql2')
                ->where('1c_id', $id)
                ->first([
                    'more_about',
                    'content',
                    'equipment',
                    'brand',
                    'factory',
                    'apply',
                    'shelf_life',
                    'country',
                    'importer',
                    'barcode',
                    'certificate',
                    'depth',
                    'width',
                    'height',
                    'weight',
                    'guarantee_period'
                ]);

            // краткое описание
            $data['about_product']['brief_description'] = trim($alfa_item->more_about);

            // преимущества
            $advantages = $alfa_item->content;
            $advantages = array_filter(explode("\n", $advantages));
            $data['about_product']['advantages'] = $advantages;

            // характеристики
            $chars = DB::connection('mysql2')
                ->table('characteristic_item')
                ->where('item_1c_id', $id)
                ->get(['characteristic_1c_id', 'value']);
            $characteristics = array();
            foreach($chars as $char) {
                // определяем характеристику
                $char_name = DB::connection('mysql2')
                    ->table('characteristics')
                    ->where('1c_id', $char->characteristic_1c_id)
                    ->first();
                $characteristics[trim($char_name->name)] = trim($char->value." ".$char_name->unit);
            }
            $data['about_product']['characteristics'] = $characteristics;

            // комплектация
            $equipment = $alfa_item->equipment;
            $equipment = array_filter(explode("\n", $equipment));
            $data['about_product']['equipment'] = $equipment;

            // дополнительные данные
            $additional_datas  = array();

            if(trim($alfa_item->brand)) {
                // берем код бренда
                $brand_id = intval(trim($alfa_item->brand));
                // если число
                if($brand_id) {
                    $brand = Brand::where('id', $brand_id)->first(['name'])->name;
                } else { // если строка
                    $brand = trim($alfa_item->brand);
                }
                $additional_datas['Бренд'] = $brand;

            }
            if(trim($alfa_item->factory)) {
                $additional_datas['Производитель'] = trim($alfa_item->factory);
            }
            if(trim($alfa_item->apply)) {
                $additional_datas['Назначение'] = trim($alfa_item->apply);
            }
            if(trim($alfa_item->shelf_life)) {
                $additional_datas['Срок службы'] = trim($alfa_item->shelf_life);
            }
            if(trim($alfa_item->country)) {
                $additional_datas['Страна изготовления'] = trim($alfa_item->country);
            }
            if(trim($alfa_item->importer)) {
                $additional_datas['Импортер'] = trim($alfa_item->importer);
            }
            if(trim($alfa_item->barcode)) {
                $additional_datas['Штрих-код'] = trim($alfa_item->barcode);
            }
            if(trim($alfa_item->certificate)) {
                $additional_datas['Сертификат'] = trim($alfa_item->certificate);
            }
            if(trim($alfa_item->depth) && trim($alfa_item->width) && trim($alfa_item->height)) {
                $additional_datas['Габариты упаковки'] = trim($alfa_item->depth)." x ".trim($alfa_item->width)." x ".trim($alfa_item->height)." мм";
            }
            if(trim($alfa_item->weight)) {
                $additional_datas['Вес с упаковкой'] = trim($alfa_item->weight)." кг";
            }
            if(trim($alfa_item->guarantee_period)) {
                $additional_datas['Гарантийный срок'] = trim($alfa_item->guarantee_period)." мес";
            }
            $data['about_product']['additional_datas'] = $additional_datas;

            // *********************************************************************************************

            // для блока Похожие товары
            // выбираем товары категории
            $cat_items = Item::where([['category_id_1c', $item->category_id_1c], ['count', '>', 0], ['for_sale', 1], ['id_1c', '!=', $item->id_1c]])
                ->orderByDesc('visite_counter')
                ->orderBy('name')
                ->get();
            $data['cat_items'] = $cat_items;

            // выбираем просмотренные товары
            if($request->cookie('seen')) {
                $seen_items = Item::whereIn('id_1c', $request->cookie('seen'))->get();
            } else {
                $seen_items = '';
            }
            $data['seen_items'] = $seen_items;

            // собираем данные для Хлебных крошек ********************************
            // берем категории
            $categories = Category::where('display', 1)
                ->orderBy('order')
                ->get([
                    'id_1c',
                    'parent_id_1c',
                    'name',
                    'slug',
                    'order',
                    'display'
                ]);

            // определяем уровень вложенности категории
            $parent = $categories->where('id_1c', $item->category_id_1c)->first()->parent_id_1c;
            $parent_parent = $categories->where('id_1c', $parent)->first()->parent_id_1c;
            if($parent_parent > 0) {
                $parent_parent_parent = $categories->where('id_1c', $parent_parent)->first()->parent_id_1c;
            }
            if(isset($parent_parent_parent) && $parent_parent_parent > 0) {
                $cat_level = 4;
            } elseif($parent_parent > 0) {
                $cat_level = 3;
            } else {
                $cat_level = 2;
            }

            $collect = new Collection;
            if($cat_level == 2) {
                // добавляем 1-й уровень
                $collect->push([
                    'id_1c' => $parent,
                    'all_cats' => $categories->where('parent_id_1c', 0),
                ]);
                // добавляем 2-й уровень
                $collect->push([
                    'id_1c' => $item->category_id_1c,
                    'all_cats' => $categories->where('parent_id_1c', $parent),
                ]);
            } elseif($cat_level == 3) {
                // добавляем 1-й уровень
                $collect->push([
                    'id_1c' => $parent_parent,
                    'all_cats' => $categories->where('parent_id_1c', 0),
                ]);

                // добавляем 2-й уровень
                $collect->push([
                    'id_1c' => $parent,
                    'all_cats' => $categories->where('parent_id_1c', $parent_parent),
                ]);

                // добавляем 3-й уровень
                $collect->push([
                    'id_1c' => $item->category_id_1c,
                    'all_cats' => $categories->where('parent_id_1c', $parent),
                ]);
            } else {
                // добавляем 1-й уровень
                $collect->push([
                    'id_1c' => $parent_parent_parent,
                    'all_cats' => $categories->where('parent_id_1c', 0),
                ]);

                // добавляем 2-й уровень
                $collect->push([
                    'id_1c' => $parent_parent,
                    'all_cats' => $categories->where('parent_id_1c', $parent_parent_parent),
                ]);

                // добавляем 3-й уровень
                $collect->push([
                    'id_1c' => $parent,
                    'all_cats' => $categories->where('parent_id_1c', $parent_parent),
                ]);

            }

            $data['bread_crumbs'] = $collect;
            $data['bread_crumbs_type'] = "tovar";
            //********************************************************************

            return view('item_card_page')->with($data);

        } else {

            // если нет, переходим на страницу ошибки

            return "Страница не существует";

        }
    }
}
