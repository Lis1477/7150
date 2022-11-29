<?php

namespace App\Http\Controllers;

use App\Slider;
use App\Item;
use App\Brand;
use App\News;
use App\MainBanner;
use Illuminate\Http\Request;


class MainPageController extends Controller
{
	public function index(Request $request)
	{

		// выбираем изображения для слайдера
		$sliders = Slider::where('display', 1)->orderBy('order')->get();
		$data['sliders'] = $sliders;

		// берем баннеры
		$banners = MainBanner::all();
		$data['banners'] = $banners;

		// выбираем популярные товары
		$popular_items = Item::where('for_sale', 1)
			->orderByDesc('visite_counter')
			->take(24)
			->get();
		$data['popular_items'] = $popular_items;

		// выбираем новые товары
		$new_items = Item::where([['is_new_item', 1], ['for_sale', 1]])
			->orderByDesc('date_new_item')
			->take(24)
			->get();
		if(!$new_items->count()) {
			$new_items = '';
		}
		$data['new_items'] = $new_items;

		// выбираем просмотренные товары
		if($request->cookie('seen')) {
			$seen_items = Item::whereIn('id_1c', $request->cookie('seen'))->get();
		} else {
			$seen_items = '';
		}
		$data['seen_items'] = $seen_items;

		// берем бренды
		$brands = Brand::all();
		$data['brands'] = $brands;

		// берем новости
		$news = News::where([['is_active', 1], ['for_retail', 1]])
			->orderByDesc('created_at')
			->take(4)
			->get(['alias', 'title', 'path_image']);
		$data['news'] = $news;

		return view('main_page')->with($data);
	}
    
}
