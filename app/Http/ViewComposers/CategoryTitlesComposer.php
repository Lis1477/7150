<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Category;

class CategoryTitlesComposer
{
    public function compose(View $view) {

    	// собираем категории для вывода в хэдере
    	$header_cats = Category::where([['in_header', 1], ['display', 1]])->orderBy('order')->get(['name', 'slug', 'id_1c']);

        // если ничего нет, берем главные
        if(!$header_cats->count()) {
            $header_cats = Category::where([['parent_id_1c', 0], ['display', 1]])->orderBy('order')->get(['name', 'slug', 'id_1c']);
        }

        return $view->with('header_cats', $header_cats);
    }
}