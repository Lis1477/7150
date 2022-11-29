<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Category;
use App\Item;

class CategoryButtonComposer
{
    public function compose(View $view) {

    	// собираем категории, исключаем уценку
    	$cats = Category::where([['display', 1], ['id_1c', '!=', 193]])->orderBy('order')->orderBy('name')->get();

        $data['cats'] = $cats;

        return $view->with($data);
    }
}