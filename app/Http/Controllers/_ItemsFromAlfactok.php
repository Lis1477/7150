<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use App\FromAlfaLastUpdate;

class ItemsFromAlfactok extends Controller
{
    public function index() // первая загрузка
    {

    	// собираем товары с сайта Альфасток
        $alfa_items = new Item;
		$items = $alfa_items
			->setConnection('mysql2')	// подключаемся к базе альфасток
			->where([['1c_category_id', '>', 0], ['is_component', 0], ['in_archive', 0]])
			->get();

		foreach($items as $item) {

			// id_1c родительской категории
			$parent_cat_1c_id = $item->{'1c_category_id'};

			// ищем такую категорию в бд
			$parent_cat = Category::where('id_1c', $parent_cat_1c_id)->first();

			// для slug убираем в названии то что в скобках
			$slug_name = trim(explode('(', $item->name)[0]);

			// преобразуем входящую нулевую дату
			if($item->date_new_item == '0000-00-00') {
				$date_new_item = null;
			} else {
				$date_new_item = $item->date_new_item;
			}

			// если существует, записываем товар в бд
			if($parent_cat) {
				$item_2626 = new Item;
				$item_2626->id_1c = $item->{'1c_id'};
				$item_2626->category_id_1c = $item->{'1c_category_id'};
				$new_item->brand_id_1c = intval($item->brand);
				$item_2626->name = $item->name;
				$item_2626->slug = str_slug($slug_name, '-');
				$item_2626->synonyms = $item->synonyms;
				$item_2626->price = $item->price_mr_bel;
				$item_2626->count = $item->count;
				$item_2626->count_type = $item->count_type;
				$item_2626->count_text = trim($item->count_text);
				$item_2626->weight = $item->weight;
				$item_2626->youtube = $item->youtube;
				$item_2626->manual = $item->guide_file;
				$item_2626->is_new_item = $item->is_new_item;
				$item_2626->date_new_item = $date_new_item;
				$item_2626->save();
			}
		}

    	return 'Товары импортированы';
    }

    // синхронизация товаров
    public static function itemSynchro()
    {

    	// собираем товары с сайта Альфасток
        $alfa_items = new Item;
		$items = $alfa_items
			->setConnection('mysql2')	// подключаемся к базе альфасток
			->where([['1c_category_id', '>', 0], ['is_component', 0], ['in_archive', 0]])
			->get();

		foreach($items as $item) {

			// берем id_1c родительской категории
			$parent_cat_1c_id = $item->{'1c_category_id'};

			// ищем такую категорию в бд 2626
			$parent_cat = Category::where('id_1c', $parent_cat_1c_id)->first();

			// если нет, пропускаем итерацию
			if(!$parent_cat) {
				continue;
			}

			// преобразуем входящую нулевую дату
			if($item->date_new_item == '0000-00-00' || $item->date_new_item == null) {
				$date_new_item = null;
			} else {
				$date_new_item = $item->date_new_item;
			}

			// проверяем, присутствует ли товар в бд 2626
			$item_2626 = Item::where('id_1c', $item->{'1c_id'})->get();

			// если присутствует, обновляем
			if($item_2626->count()) {

				Item::where('id_1c', $item->{'1c_id'})->update([
					'category_id_1c' => $item->{'1c_category_id'},
					'brand_id_1c' => intval($item->brand),
					'name' => $item->name,
					'synonyms' => $item->synonyms,
					'price' => $item->price_mr_bel,
					'count' => $item->count,
					'count_type' => $item->count_type,
					'count_text' => trim($item->count_text),
					'weight' => $item->weight,
					'youtube' => $item->youtube,
					'manual' => $item->guide_file,
					'is_new_item' => $item->is_new_item,
					'date_new_item' => $date_new_item,
					'for_sale' => 1,
				]);

			// если нет, добавляем
			} else {

				// для slug убираем в названии то что в скобках
				$slug_name = trim(explode('(', $item->name)[0]);

				$new_item = new Item;
				$new_item->id_1c = $item->{'1c_id'};
				$new_item->category_id_1c = $item->{'1c_category_id'};
				$new_item->brand_id_1c = intval($item->brand);
				$new_item->name = $item->name;
				$new_item->slug = str_slug($slug_name, '-');
				$new_item->synonyms = $item->synonyms;
				$new_item->price = $item->price_mr_bel;
				$new_item->count = $item->count;
				$new_item->count_type = $item->count_type;
				$new_item->count_text = trim($item->count_text);
				$new_item->weight = $item->weight;
				$new_item->youtube = $item->youtube;
				$new_item->manual = $item->guide_file;
				$new_item->is_new_item = $item->is_new_item;
				$new_item->date_new_item = $date_new_item;
				$new_item->save();
			}
		}

		// собираем id_1c товаров из Alfactok
		$id_1c_alfa = $items->pluck('1c_id')->toArray();

		// если в 2626 есть коды не из списка, отмечаем как не для продажи
		Item::whereNotIn('id_1c', $id_1c_alfa)->update([
			'for_sale' => 0,
		]);

		// записываем дату-время обновления
		$update = \Carbon\Carbon::now()->toDateTimeString();
		FromAlfaLastUpdate::where('id', 1)->update([
			'item_update' => $update,
		]);

		return 'Синхронизация с Альфа товарами произведена';
    }



}
