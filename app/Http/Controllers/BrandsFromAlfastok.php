<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandsFromAlfastok extends Controller
{

    public function index() // первая загрузка
    {

        // собираем бренды с сайта Альфасток
        $alfa_brands = new Brand;
        $brands = $alfa_brands
            ->setConnection('mysql2')   // подключаемся к базе альфасток
            ->get();

        foreach($brands as $brand) {
            // Записываем в БД 7150
            $brand_7150 = new Brand;
            $brand_7150->brand_1c_id = $brand->brand_1c_id;
            $brand_7150->name = $brand->name;
            $brand_7150->slug = str_slug($brand->name, '-');
            $brand_7150->image = $brand->image;
            $brand_7150->save();
        }

        return 'Бренды импортированы';
    }


}
