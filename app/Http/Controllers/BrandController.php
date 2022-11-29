<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Brand;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Item;


class BrandController extends Controller
{
    public function index()
    {
        // берем бренды
        $brands = Brand::all();
        $data['brands'] = $brands;

        $data['title'] = "Бренды | Интернет-магазин 7150.by";

        return view('brands_page')->with($data);
    }

    public function getBrand(Request $request, $slug)
    {
        // берем бренд
        $brand = Brand::where('slug', $slug)->first();
        $data['brand'] = $brand;

        // для метатега title
        if(trim($brand->title)) {
            $title = $brand->title;
        } else {
            $title = $brand->name;
        }
        $data['title'] = $title;

        // для метатэга keywords
        $keywords = trim($brand->keywords);
        $data['keywords'] = $keywords;

        // для метатэга description
        $description = trim($brand->description);
        $data['description'] = $description;

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
        $items_obj = Item::where([['count', '>', 0], ['for_sale', 1], ['brand_id_1c', $brand->brand_1c_id]]);

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
        $data['items'] = $items;

        // данные для фильтров ***************************************************************
        // минимальная и максимальная цена
        // $min_price = clone $items_obj;
        // $min_price = $min_price->orderBy('price')->first()->price;
        // $data['min_price'] = $min_price;

        // $max_price = clone $items_obj;
        // $max_price = $max_price->orderByDesc('price')->first()->price;
        // $data['max_price'] = $max_price;

        // // собираем коды категорий
        // $cat_arr = array_unique($items_obj->pluck('category_id_1c')->toArray());

        // // собираем категории
        // $cats = Category::whereIn('id_1c', $cat_arr)->orderBy('name')->get(['id_1c', 'name']);
        // $data['cats'] = $cats;

        return view('brand_show_page')->with($data);
    }
}
