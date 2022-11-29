				<a href="{{ asset('tovar/'.$item->id_1c.'/'.$item->slug) }}" class="item-element js-item-element">

					<div class="item-element_icon-line">

						@php
							if($item->is_new_item == 1) {
								$first_class = 'new_item';
								$first_word = 'New';
							} else {
								// $first_class = 'hit';
								// $first_word = 'Хит';
								$first_class = '';
								$first_word = '';
							}
						@endphp

						<div class="{{ $first_class }}">
							{{ $first_word }}
						</div>

						@php
							if($item->is_action == 1) $action_class = 'active';
								else $action_class = '';
						@endphp

						<div class="action {{ $action_class }}">
							Акция
						</div>

						<div
							class="discount js-want-cheaper-link"
							title="Хочу дешевле"
							data-name="{{ $item->name }}"
						>
							@include('svg.discount')
 						</div>

{{-- 						<div class="compare" title="Сравнить">
							@include('svg.compare')
						</div> --}}

						@php
							$item_in_favorite = false;

							if(count($selected_items)) { // данные из ViewComposers
								foreach($selected_items as $val) {
									if($val->item_code == $item->id_1c) {
										$item_in_favorite = true;
										break;
									}
								}
							}

							if($item_in_favorite) {
								$favorite_title = "Удалить из избранного";
								$item_in_favorite_class = "item_in_favorite";
							} else {
								$favorite_title = "В избранное";
								$item_in_favorite_class = "";
							}

						@endphp


						<div
							class="favorites js-to-selected {{ $item_in_favorite_class }}"
							title="{{ $favorite_title }}"
							data-id-1c="{{ $item->id_1c }}"
							data-route-name="{{ Route::currentRouteName() }}"
						>
							@include('svg.favorites')
						</div>

					</div>

					<div class="item-element_images-block item-{{ $item->id_1c }}">

						@php($i=1)

						@if($item->images->count())

							@foreach($item->images as $image)

								@php
									if($i==1) $img_class = 'active';
										else $img_class = '';
								@endphp

							<img
								src="https://alfastok.by/storage/{{ $image->path_image }}"
								class="js-img-{{ $i }} {{ $img_class }}"
							>

								@php($i++)

							@endforeach

						@else

							<img
								src="{{ asset('/img/no_image.jpg') }}"
								class="active"
							>

						@endif

						@php
							unset($i);
						@endphp

						<div class="item-element_image-links-block">
							
							@for($i=1; $i<=$item->images->count(); $i++)

								@php
									if($i==1) $link_class = 'active first';
										else $link_class = '';
								@endphp

							<div
								class="item-element_image-link js-img-link-{{ $item->id_1c }} {{ $link_class }}"
								data-id-1c="{{ $item->id_1c }}"
								data-i="{{ $i }}"
							>
								<div class="item-element_image-marker js-img-marker"></div>
							</div>

							@endfor

						</div>

					</div>

					<div class="item-element_item-code">
						Код: {{ $item->id_1c }}
					</div>

					@php
						if(\Route::currentRouteName() == 'discounted-items' || $item->parentCategory->id_1c == 3149) {
							$cat_name = "Уцененные товары";
							$cat_link = asset('utsenionniye-tovary');
						} else {
							$cat_name = $item->parentCategory->name;
							$cat_link = asset('category/'.$item->parentCategory->id_1c.'/'.$item->parentCategory->slug);
						}
					@endphp

					<div
						class="item-element_item-category js-parent-cat-link"
						title="{{ $cat_name  }}"
						data-link={{ $cat_link }}
					>
						{{ $cat_name }}
					</div>

					<div
						class="item-element_item-name"
						title="{{ $item->name }}"
					>
						@php
							// в наименовании удаляем все после открывающейся скобки
							$name = trim(explode('(', $item->name)[0]);
						@endphp

						{{ $name }}
					</div>

					<div class="item-element_avalibility-line">

						<div class="item-element_comment-block" style="visibility: hidden;">
							<div class="item-element_comment-stars">
								@include('includes.stars_handler')
							</div>

							@if($item->comment_counter) {{-- Выводим если есть отзывы --}}

							<div class="item-element_comment-string">
								{{-- Функция end_сomment_string() в - App/Helpers/helpers.php --}}
								{{ $item->comment_counter }} отзыв{{ end_сomment_string($item->comment_counter) }}
							</div>

							@endif
						
						</div>

						<div class="item-element_count-block">

							@if($item->count > 0)
								@php
									if($item->count < 5) {
										$style_2 = '';
										$style_3 = '';
										$title = $item->count;
									} elseif ($item->count <= 10) {
										$style_2 = 'active';
										$style_3 = '';
										$title = $item->count;
									} else {
										$style_2 = 'active';
										$style_3 = 'active';
										$title = 'более 10';
									}
								@endphp

							<div class="item-element_count-ico-block">
								<div class="item-element_count-ico-el-1"></div>
								<div class="item-element_count-ico-el-2 {{ $style_2 }}"></div>
								<div class="item-element_count-ico-el-3 {{ $style_3 }}"></div>
							</div>

							<div class="item-element_count-string" title="На складе {{ $title }} шт.">
								в наличии
							</div>

							@else

							<div class="item-element_count-string">
								нет наличии
							</div>

							@endif

						</div>
					</div>

					<div class="item-element_action-line {{ $action_class }}">

						@if($item->is_action && $item->action_price)

						<div class="item-element_action-old-price">
							{{ number_format($item->price, 2, '.', '') }} руб
						</div>

						<div class="item-element_action-percent">
							-{{ number_format((1 - $item->action_price / $item->price) * 100, 0) }}%
						</div>

						<div class="item-element_action-benefit">
							{{ number_format(($item->price - $item->action_price), 2, '.', '') }} руб
						</div>

						@endif

					</div>

					<div class="item-element_price-line">
						<div class="item-element_price">

							@if($item->is_action && $item->action_price)

							{{ number_format($item->action_price, 2, '.', '') }} руб

							@else

							{{ number_format($item->price, 2, '.', '') }} руб

							@endif
							
						</div>

						<div class="item-element_in-cart-block">
							<div
								class="item-element_one-click-link js-one-click-butt"
								title="Оформить заказ в 1 клик"
								data-id_1c="{{ $item->id_1c }}"
								data-name="{{ $item->name }}"
							>
								@include('svg.one_click')
							</div>

						@php
							$item_in_cart = false;

							if(count($cart_items)) { // данные из ViewComposers
								foreach($cart_items as $val) {
									if($val->item_code == $item->id_1c) {
										$item_in_cart = true;
										break;
									}
								}
							}

							if($item_in_cart) {
								$button_title = "Перейти в корзину";
								$item_in_cart_class = "item_in_cart";
							} else {
								$button_title = "Добавить товар в корзину";
								$item_in_cart_class = "";
							}

						@endphp

							<div
								class="item-element_in-cart-link js-item-block-button {{ $item_in_cart_class }}"
								title="{{ $button_title }}"
								data-item-code="{{ $item->id_1c }}"
							>
								@include('svg.in_cart')
							</div>
						</div>
					</div>

				</a>
