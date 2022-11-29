<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\FromAlfaLastUpdate;

class CategoryFromAlfactok extends Controller
{
    public function index()
    {

    	// берем категории с сайта Альфасток
        $alfa_category = new Category;
		$alfa_cats = $alfa_category
			->setConnection('mysql2')	// подключаемся к базе альфасток
			->where([['1c_id', '!=', 20070], ['parent_1c_id', '!=', 20070]])	// кроме услуг (20070)
			->get();

    	// собираем товары с сайта Альфасток
        $alfa_items = new Item;
		$items = $alfa_items
			->setConnection('mysql2')	// подключаемся к базе альфасток
			->where([['1c_category_id', '>', 0], ['in_archive', 0], ['count', '>', 0], ['count_type', 1]])
			->get();


		foreach($alfa_cats->where('parent_1c_id', 0) as $cat_1) {

			// записываем категории 1-го уровня
			$category = new Category;
			$category->id_1c = $cat_1->{'1c_id'};
			$category->parent_id_1c = $cat_1->parent_1c_id;
			$category->name = $cat_1->name;
			$category->slug = str_slug($cat_1->name, '-');
			$category->image = trim($cat_1->image_path);
			$category->thumb_image = trim($cat_1->thumb_image);
			$category->order = $cat_1->default_sort;
			$category->save();

			// индекс присутствия товаров в категории 1 уровня
			$i_1 = 0;

			// берем категории 2-го уровня
			$cats_2 = $alfa_cats->where('parent_1c_id', $cat_1->{'1c_id'});

			// если есть
			if($cats_2->count()) {
				// записывем
				foreach($cats_2 as $cat_2) {

					$category = new Category;
					$category->id_1c = $cat_2->{'1c_id'};
					$category->parent_id_1c = $cat_2->parent_1c_id;
					$category->name = $cat_2->name;
					$category->slug = str_slug($cat_2->name, '-');
					$category->image = trim($cat_2->image_path);
					$category->thumb_image = trim($cat_2->thumb_image);
					$category->order = $cat_2->default_sort;
					$category->save();

					// индекс присутствия товаров в категории 2 уровня
					$i_2 = 0;

					// берем категории 3-го уровня
					$cats_3 = $alfa_cats->where('parent_1c_id', $cat_2->{'1c_id'});

					// если нет
					if(!$cats_3->count()) {

						// берем товары категории 2 уровня
						$items_2 = $items->where('1c_category_id', $cat_2->{'1c_id'});

						// если есть
						if($items_2->count()) {

							// увеличиваем индекс наличия для категорий
							$i_1 ++;
							$i_2 ++;

							// записываем в 7150
							foreach($items_2 as $item) {

								// для slug убираем в названии то что в скобках
								$slug_name = trim(explode('(', $item->name)[0]);

								// преобразуем входящую нулевую дату
								if($item->date_new_item == '0000-00-00') {
									$date_new_item = null;
								} else {
									$date_new_item = $item->date_new_item;
								}

								$item_7150 = new Item;
								$item_7150->id_1c = $item->{'1c_id'};
								$item_7150->category_id_1c = $item->{'1c_category_id'};
								$item_7150->brand_id_1c = intval($item->brand);
								$item_7150->name = $item->name;
								$item_7150->slug = str_slug($slug_name, '-');
								$item_7150->synonyms = $item->synonyms;
								$item_7150->price = $item->price_mr_bel;
								$item_7150->count = $item->count;
								$item_7150->count_type = $item->count_type;
								$item_7150->count_text = trim($item->count_text);
								$item_7150->weight = $item->weight;
								$item_7150->youtube = $item->youtube;
								$item_7150->manual = $item->guide_file;
								$item_7150->is_new_item = $item->is_new_item;
								$item_7150->date_new_item = $date_new_item;
								$item_7150->save();
							}
						}
					} else {
						// записывем
						foreach($cats_3 as $cat_3) {
							$category = new Category;
							$category->id_1c = $cat_3->{'1c_id'};
							$category->parent_id_1c = $cat_3->parent_1c_id;
							$category->name = $cat_3->name;
							$category->slug = str_slug($cat_3->name, '-');
							$category->image = trim($cat_3->image_path);
							$category->thumb_image = trim($cat_3->thumb_image);
							$category->order = $cat_3->default_sort;
							$category->save();

							// индекс присутствия товаров в категории 2 уровня
							$i_3 = 0;

							// берем категории 4-го уровня
							$cats_4 = $alfa_cats->where('parent_1c_id', $cat_3->{'1c_id'});

							// если нет
							if(!$cats_4->count()) {

								// берем товары категории 3 уровня
								$items_3 = $items->where('1c_category_id', $cat_3->{'1c_id'});

								// если есть
								if($items_3->count()) {

									// увеличиваем индекс наличия для категорий
									$i_1 ++;
									$i_2 ++;
									$i_3 ++;

									// записываем в 7150
									foreach($items_3 as $item) {

										// для slug убираем в названии то что в скобках
										$slug_name = trim(explode('(', $item->name)[0]);

										// преобразуем входящую нулевую дату
										if($item->date_new_item == '0000-00-00') {
											$date_new_item = null;
										} else {
											$date_new_item = $item->date_new_item;
										}

										$item_7150 = new Item;
										$item_7150->id_1c = $item->{'1c_id'};
										$item_7150->category_id_1c = $item->{'1c_category_id'};
										$item_7150->brand_id_1c = intval($item->brand);
										$item_7150->name = $item->name;
										$item_7150->slug = str_slug($slug_name, '-');
										$item_7150->synonyms = $item->synonyms;
										$item_7150->price = $item->price_mr_bel;
										$item_7150->count = $item->count;
										$item_7150->count_type = $item->count_type;
										$item_7150->count_text = trim($item->count_text);
										$item_7150->weight = $item->weight;
										$item_7150->youtube = $item->youtube;
										$item_7150->manual = $item->guide_file;
										$item_7150->is_new_item = $item->is_new_item;
										$item_7150->date_new_item = $date_new_item;
										$item_7150->save();
									}
								}
							} else {
								// берем id категорий
								$cats_4_id = $cats_4->pluck('1c_id')->toArray('id_1c');

								// берем товары категории 4 уровня
								$items_4 = $items->whereIn('1c_category_id', $cats_4_id);

								// если есть
								if($items_4->count()) {

									// увеличиваем индекс наличия для категорий
									$i_1 ++;
									$i_2 ++;
									$i_3 ++;

									// записываем в 7150
									foreach($items_4 as $item) {

										// для slug убираем в названии то что в скобках
										$slug_name = trim(explode('(', $item->name)[0]);

										// преобразуем входящую нулевую дату
										if($item->date_new_item == '0000-00-00') {
											$date_new_item = null;
										} else {
											$date_new_item = $item->date_new_item;
										}

										$item_7150 = new Item;
										$item_7150->id_1c = $item->{'1c_id'};
										$item_7150->category_id_1c = $cat_3->{'1c_id'};
										$item_7150->brand_id_1c = intval($item->brand);
										$item_7150->name = $item->name;
										$item_7150->slug = str_slug($slug_name, '-');
										$item_7150->synonyms = $item->synonyms;
										$item_7150->price = $item->price_mr_bel;
										$item_7150->count = $item->count;
										$item_7150->count_type = $item->count_type;
										$item_7150->count_text = trim($item->count_text);
										$item_7150->weight = $item->weight;
										$item_7150->youtube = $item->youtube;
										$item_7150->manual = $item->guide_file;
										$item_7150->is_new_item = $item->is_new_item;
										$item_7150->date_new_item = $date_new_item;
										$item_7150->save();
									}
								}
							}

							// если нет товаров в категории 3-го уровня, скрываем
							if($i_3 == 0) {
								Category::where('id_1c', $cat_3->{'1c_id'})->update([
									'display' => 0,
								]);
							}
						}
					}

					// если нет товаров в категории 2-го уровня, скрываем
					if($i_2 == 0) {
						Category::where('id_1c', $cat_2->{'1c_id'})->update([
							'display' => 0,
						]);
					}
				}
			}

			// если нет товаров в категории 1-го уровня, скрываем
			if($i_1 == 0) {
				Category::where('id_1c', $cat_1->{'1c_id'})->update([
					'display' => 0,
				]);
			}
		}

    	return 'Категории и Товары созданы';
    }

    // синхронизация категорий
    public static function catSynchro()
    {

    	// берем категории с сайта Альфасток
        $alfa_category = new Category;
		$alfa_cats = $alfa_category
			->setConnection('mysql2')	// подключаемся к базе альфасток
			->where([['1c_id', '!=', 20070], ['parent_1c_id', '!=', 20070]])	// кроме услуг (20070)
			->get();

    	// собираем товары с сайта Альфасток
        $alfa_items = new Item;
		$items = $alfa_items
			->setConnection('mysql2')	// подключаемся к базе альфасток
			->where([['1c_category_id', '>', 0], ['in_archive', 0], ['count', '>', 0], ['count_type', 1]])
			->get();

		// собираем id_1c категорий из Alfactok
		$id_1c_alfa_cat = [];

		// собираем id_1c категорий из Alfactok
		$id_1c_alfa_item = [];

		// берем категории 1-го уровня
		$cats_1 = $alfa_cats->where('parent_1c_id', 0);

		// добавляем id_1c категорий в массив
		$id_1c_alfa_cat = array_merge($id_1c_alfa_cat, $cats_1->pluck('1c_id')->toArray());

		foreach($cats_1 as $cat_1) {

			// если id_1c присутствует в бд 7150
			$cat_7150 = Category::where('id_1c', $cat_1->{'1c_id'})->first(['id_1c']);
			if($cat_7150) {
				// обновляем
				Category::where('id_1c', $cat_1->{'1c_id'})->update([
					'parent_id_1c' => $cat_1->parent_1c_id,
					'name' => $cat_1->name,
					'image' => trim($cat_1->image_path),
					'thumb_image' => trim($cat_1->thumb_image),
					'order' => $cat_1->default_sort,
					'display' => 1,
				]);

			// если нет, создаем новую
			} else {
				$category = new Category;
				$category->id_1c = $cat_1->{'1c_id'};
				$category->parent_id_1c = $cat_1->parent_1c_id;
				$category->name = $cat_1->name;
				$category->slug = str_slug($cat_1->name, '-');
				$category->image = trim($cat_1->image_path);
				$category->thumb_image = trim($cat_1->thumb_image);
				$category->order = $cat_1->default_sort;
				$category->save();
			}

			// индекс присутствия товаров в категории 1 уровня
			$i_1 = 0;

			// берем категории 2-го уровня
			$cats_2 = $alfa_cats->where('parent_1c_id', $cat_1->{'1c_id'});

			// если есть
			if($cats_2->count()) {

				// добавляем id_1c категорий в массив
				$id_1c_alfa_cat = array_merge($id_1c_alfa_cat, $cats_2->pluck('1c_id')->toArray());

				// обновляем категории 2-го уровня
				foreach($cats_2 as $cat_2) {

					// если id_1c присутствует в бд 7150, обновляем
					$cat_7150 = Category::where('id_1c', $cat_2->{'1c_id'})->first(['id_1c']);
					if($cat_7150) {
						// обновляем
						Category::where('id_1c', $cat_2->{'1c_id'})->update([
							'parent_id_1c' => $cat_2->parent_1c_id,
							'name' => $cat_2->name,
							'image' => trim($cat_2->image_path),
							'thumb_image' => trim($cat_2->thumb_image),
							'order' => $cat_2->default_sort,
							'display' => 1,
						]);

					// если нет, создаем новую
					} else {
						$category = new Category;
						$category->id_1c = $cat_2->{'1c_id'};
						$category->parent_id_1c = $cat_2->parent_1c_id;
						$category->name = $cat_2->name;
						$category->slug = str_slug($cat_2->name, '-');
						$category->image = trim($cat_2->image_path);
						$category->thumb_image = trim($cat_2->thumb_image);
						$category->order = $cat_2->default_sort;
						$category->save();
					}

					// индекс присутствия товаров в категории 2 уровня
					$i_2 = 0;

					// берем категории 3-го уровня
					$cats_3 = $alfa_cats->where('parent_1c_id', $cat_2->{'1c_id'});

					// если нет
					if(!$cats_3->count()) {

						// берем товары категории 2 уровня
						$items_2 = $items->where('1c_category_id', $cat_2->{'1c_id'});

						// если есть
						if($items_2->count()) {

							// собираем id_1c товаров из Alfactok, добавляем в массив
							$id_1c_alfa_item = array_merge($id_1c_alfa_item, $items_2->pluck('1c_id')->toArray());

							// увеличиваем индекс наличия для категорий
							$i_1 ++;
							$i_2 ++;

							// записываем в 7150
							foreach($items_2 as $item) {

								// берем id_1c родительской категории
								$parent_cat_1c_id = $item->{'1c_category_id'};

								// ищем такую категорию в бд 7150
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
								$item_7150 = Item::where('id_1c', $item->{'1c_id'})->first(['id_1c']);

								// если присутствует, обновляем
								if($item_7150) {

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
						}
					} else {

						// добавляем id_1c категорий в массив
						$id_1c_alfa_cat = array_merge($id_1c_alfa_cat, $cats_3->pluck('1c_id')->toArray());

						foreach($cats_3 as $cat_3) {

							// если id_1c присутствует в бд 7150, обновляем
							$cat_7150 = Category::where('id_1c', $cat_3->{'1c_id'})->first(['id_1c']);
							if($cat_7150) {
								// обновляем
								Category::where('id_1c', $cat_3->{'1c_id'})->update([
									'parent_id_1c' => $cat_3->parent_1c_id,
									'name' => $cat_3->name,
									'image' => trim($cat_3->image_path),
									'thumb_image' => trim($cat_3->thumb_image),
									'order' => $cat_3->default_sort,
									'display' => 1,
								]);

							// если нет, создаем новую
							} else {
								$category = new Category;
								$category->id_1c = $cat_3->{'1c_id'};
								$category->parent_id_1c = $cat_3->parent_1c_id;
								$category->name = $cat_3->name;
								$category->slug = str_slug($cat_3->name, '-');
								$category->image = trim($cat_3->image_path);
								$category->thumb_image = trim($cat_3->thumb_image);
								$category->order = $cat_3->default_sort;
								$category->save();
							}

							// индекс присутствия товаров в категории 2 уровня
							$i_3 = 0;

							// берем категории 4-го уровня
							$cats_4 = $alfa_cats->where('parent_1c_id', $cat_3->{'1c_id'});

							// если нет
							if(!$cats_4->count()) {

								// берем товары категории 3 уровня
								$items_3 = $items->where('1c_category_id', $cat_3->{'1c_id'});

								// если есть
								if($items_3->count()) {

									// собираем id_1c товаров из Alfactok, добавляем в массив
									$id_1c_alfa_item = array_merge($id_1c_alfa_item, $items_3->pluck('1c_id')->toArray());

									// увеличиваем индекс наличия для категорий
									$i_1 ++;
									$i_2 ++;
									$i_3 ++;

									// записываем в 7150
									foreach($items_3 as $item) {

										// берем id_1c родительской категории
										$parent_cat_1c_id = $item->{'1c_category_id'};

										// ищем такую категорию в бд 7150
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
										$item_7150 = Item::where('id_1c', $item->{'1c_id'})->first(['id_1c']);

										// если присутствует, обновляем
										if($item_7150) {

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
								}
							} else {

								// берем id категорий
								$cats_4_id = $cats_4->pluck('1c_id')->toArray('id_1c');

								// берем товары категории 4 уровня
								$items_4 = $items->whereIn('1c_category_id', $cats_4_id);

								// если есть
								if($items_4->count()) {

									// собираем id_1c товаров из Alfactok, добавляем в массив
									$id_1c_alfa_item = array_merge($id_1c_alfa_item, $items_4->pluck('1c_id')->toArray());

									// увеличиваем индекс наличия для категорий
									$i_1 ++;
									$i_2 ++;
									$i_3 ++;

									// записываем в 7150
									foreach($items_4 as $item) {

										// преобразуем входящую нулевую дату
										if($item->date_new_item == '0000-00-00' || $item->date_new_item == null) {
											$date_new_item = null;
										} else {
											$date_new_item = $item->date_new_item;
										}

										// проверяем, присутствует ли товар в бд 2626
										$item_7150 = Item::where('id_1c', $item->{'1c_id'})->first(['id_1c']);

										// если присутствует, обновляем
										if($item_7150) {

											Item::where('id_1c', $item->{'1c_id'})->update([
												'category_id_1c' => $cat_3->{'1c_id'},
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
											$new_item->category_id_1c = $cat_3->{'1c_id'};
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
								}
							}

							// если нет товаров в категории 3-го уровня, скрываем
							if($i_3 == 0) {
								Category::where('id_1c', $cat_3->{'1c_id'})->update([
									'display' => 0,
								]);
							}
						}
					}

					// если нет товаров в категории 2-го уровня, скрываем
					if($i_2 == 0) {
						Category::where('id_1c', $cat_2->{'1c_id'})->update([
							'display' => 0,
						]);
					}
				}
			}

			// если нет товаров в категории 1-го уровня, скрываем
			if($i_1 == 0) {
				Category::where('id_1c', $cat_1->{'1c_id'})->update([
					'display' => 0,
				]);
			}
		}

		// если в 7150 есть коды не из списка, прячем
		Category::whereNotIn('id_1c', $id_1c_alfa_cat)->update([
			'display' => 0,
		]);
		Item::whereNotIn('id_1c', $id_1c_alfa_item)->update([
			'count' => 0,
			'for_sale' => 0,
		]);

		// записываем дату-время обновления
		$update = \Carbon\Carbon::now();
		FromAlfaLastUpdate::where('id', 1)->update([
			'category_update' => $update->toDateTimeString(),
		]);

    	return 'Категории и Товары обновлены';
    }

  //   // синхронизация категорий
  //   public static function catSynchro()
  //   {

  //   	// берем все категории из Альфасток
  //       $alfa_category = new Category;
		// $alfa_cats = $alfa_category
		// 	->setConnection('mysql2')	// подключаемся к базе альфасток
		// 	->where([['1c_id', '!=', 20070], ['parent_1c_id', '!=', 20070]])	// кроме услуг (20070)
		// 	->get();

		// // собираем id_1c категорий из Alfactok
		// $id_1c_alfa = [];

		// // берем категории 1-го уровня
		// $cats_1 = $alfa_cats->where('parent_1c_id', 0);

		// // добавляем id_1c категорий в массив
		// $id_1c_alfa = array_merge($id_1c_alfa, $cats_1->pluck('1c_id')->toArray());

		// foreach($cats_1 as $cat_1) {

		// 	// обновляем категории 1-го уровня

		// 	// если id_1c присутствует в бд 7150, обновляем
		// 	$cat_7150 = Category::where('id_1c', $cat_1->{'1c_id'})->first(['id_1c']);

		// 	if($cat_7150) {

		// 		Category::where('id_1c', $cat_1->{'1c_id'})->update([
		// 			'parent_id_1c' => $cat_1->parent_1c_id,
		// 			'name' => $cat_1->name,
		// 			'image' => trim($cat_1->image_path),
		// 			'thumb_image' => trim($cat_1->thumb_image),
		// 			'order' => $cat_1->default_sort,
		// 			'display' => 1,
		// 		]);

		// 	// если нет, создаем новую
		// 	} else {
		// 		$category = new Category;
		// 		$category->id_1c = $cat_1->{'1c_id'};
		// 		$category->parent_id_1c = $cat_1->parent_1c_id;
		// 		$category->name = $cat_1->name;
		// 		$category->slug = str_slug($cat_1->name, '-');
		// 		$category->image = trim($cat_1->image_path);
		// 		$category->thumb_image = trim($cat_1->thumb_image);
		// 		$category->order = $cat_1->default_sort;
		// 		$category->save();
		// 	}

		// 	// берем категории 2-го уровня
		// 	$cats_2 = $alfa_cats->where('parent_1c_id', $cat_1->{'1c_id'});

		// 	// если есть
		// 	if($cats_2->count()) {

		// 		// добавляем id_1c категорий в массив
		// 		$id_1c_alfa = array_merge($id_1c_alfa, $cats_2->pluck('1c_id')->toArray());

		// 		foreach($cats_2 as $cat_2) {

		// 			// обновляем категории 2-го уровня

		// 			// если id_1c присутствует в бд 7150, обновляем
		// 			$cat_7150 = Category::where('id_1c', $cat_2->{'1c_id'})->first(['id_1c']);

		// 			if($cat_7150) {

		// 				Category::where('id_1c', $cat_2->{'1c_id'})->update([
		// 					'parent_id_1c' => $cat_2->parent_1c_id,
		// 					'name' => $cat_2->name,
		// 					'image' => trim($cat_2->image_path),
		// 					'thumb_image' => trim($cat_2->thumb_image),
		// 					'order' => $cat_2->default_sort,
		// 					'display' => 1,
		// 				]);

		// 			// если нет, создаем новую
		// 			} else {
		// 				$category = new Category;
		// 				$category->id_1c = $cat_2->{'1c_id'};
		// 				$category->parent_id_1c = $cat_2->parent_1c_id;
		// 				$category->name = $cat_2->name;
		// 				$category->slug = str_slug($cat_2->name, '-');
		// 				$category->image = trim($cat_2->image_path);
		// 				$category->thumb_image = trim($cat_2->thumb_image);
		// 				$category->order = $cat_2->default_sort;
		// 				$category->save();
		// 			}

		// 			// берем категории 3-го уровня
		// 			$cats_3 = $alfa_cats->where('parent_1c_id', $cat_2->{'1c_id'});

		// 			// если есть
		// 			if($cats_3->count()) {

		// 				// добавляем id_1c категорий в массив
		// 				$id_1c_alfa = array_merge($id_1c_alfa, $cats_3->pluck('1c_id')->toArray());


		// 				foreach($cats_3 as $cat_3) {

		// 					// обновляем категории 3-го уровня

		// 					// если id_1c присутствует в бд 7150, обновляем
		// 					$cat_7150 = Category::where('id_1c', $cat_3->{'1c_id'})->first(['id_1c']);

		// 					if($cat_7150) {

		// 						Category::where('id_1c', $cat_3->{'1c_id'})->update([
		// 							'parent_id_1c' => $cat_3->parent_1c_id,
		// 							'name' => $cat_3->name,
		// 							'image' => trim($cat_3->image_path),
		// 							'thumb_image' => trim($cat_3->thumb_image),
		// 							'order' => $cat_3->default_sort,
		// 							'display' => 1,
		// 						]);

		// 					// если нет, создаем новую
		// 					} else {
		// 						$category = new Category;
		// 						$category->id_1c = $cat_3->{'1c_id'};
		// 						$category->parent_id_1c = $cat_3->parent_1c_id;
		// 						$category->name = $cat_3->name;
		// 						$category->slug = str_slug($cat_3->name, '-');
		// 						$category->image = trim($cat_3->image_path);
		// 						$category->thumb_image = trim($cat_3->thumb_image);
		// 						$category->order = $cat_3->default_sort;
		// 						$category->save();
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		// // если в 7150 есть коды не из списка, прячем
		// Category::whereNotIn('id_1c', $id_1c_alfa)->update([
		// 	'display' => 0,
		// ]);

		// // скрываем категории, у которых нет товаров для продажи
		// // Self::hideCategorieWithoutItems();

		// // записываем дату-время обновления
		// $update = \Carbon\Carbon::now();
		// FromAlfaLastUpdate::where('id', 1)->update([
		// 	'category_update' => $update->toDateTimeString(),
		// ]);

  //   	return 'Синхронизация с Альфа категориями произведена';
  //   }

   //  public static function hideCategorieWithoutItems()
   //  {
   //  	// берем категории 1 уровня
   //  	$cats_1 = Category::where([['parent_id_1c', 0], ['display', 1]])->get(['id_1c', 'name']);


   //  	foreach($cats_1 as $cat_1) {
			// // индекс наличия товаров в категории
			// $i_1 = 0;

   //  		// проверяем, есть ли дочерние категории 2-го уровня
   //  		$cats_2 = Category::where([['parent_id_1c', $cat_1->id_1c], ['display', 1]])->get(['id_1c', 'name']);

   //  		if(!$cats_2->count()) {
	  //   		// если нет, скрываем категорию
	  //  			Category::where('id_1c', $cat_1->id_1c)->update(['display' => 0]);
   //  		} else {
   //  			foreach($cats_2 as $cat_2) {

	  //   			// проверяем, есть ли дочерние категории 3-го уровня
		 //    		$cats_3 = Category::where([['parent_id_1c', $cat_2->id_1c], ['display', 1]])->get(['id_1c', 'name']);

		 //    		// если нет
		 //    		if(!$cats_3->count()) {
		 //    			// проверяем, есть ли у категории товар для продажи
		 //    			$item_2 = Item::where([['category_id_1c', $cat_2->id_1c], ['count', '>', 0], ['for_sale', 1]])->first(['id_1c']);
		 //    			// если нет, скрываем категорию
		 //    			if (!$item_2) {
			//     			Category::where('id_1c', $cat_2->id_1c)->update(['display' => 0]);
		 //    			} else {
			//     			// меняем индекс наличия
			//     			$i_1 ++;
		 //    			}
		 //    		} else {
		 //    			// проверяем, есть ли у категорий товар для продажи
		 //    			foreach($cats_3 as $cat_3) {
			//     			$item_3 = Item::where([['category_id_1c', $cat_3->id_1c], ['count', '>', 0], ['for_sale', 1]])->first(['id_1c']);

			//     			// если нет
			//     			if (!$item_3) {
			// 	    			// смотрим есть ли дочерние категории 4-го уровня
			// 	    			$child_cat_id = Category::where('parent_id_1c', $cat_3->id_1c)->pluck('id_1c')->toArray('id_1c');

			// 	    			// если есть
			// 	    			if(count($child_cat_id)) {
			// 	    				// смотрим, есть ли товары
			// 	    				$item_4 = Item::whereIn('category_id_1c', $child_cat_id)->where([['count', '>', 0], ['for_sale', 1]])->first(['id_1c']);

			// 		    			// если есть, пропускаем итерацию
			// 		    			if($item_4) {
			// 			    			// меняем индекс наличия
			// 			    			$i_1 ++;

			// 		    				continue;
			// 		    			}
			// 	    			}

			//     				// скрываем категорию
			// 	    			Category::where('id_1c', $cat_3->id_1c)->update(['display' => 0]);
			//     			} else {
			// 	    			// меняем индекс наличия
			// 	    			$i_1 ++;
			//     			}
		 //    			}

		 //    		}
   //  			}
   //  		}

   //  		// если индекс нулевой, скрываем категорию
   //  		if(!$i_1) {
   //  			Category::where('id_1c', $cat_1->id_1c)->update(['display' => 0]);
   //  		}
   //  	}
   //  }

}
