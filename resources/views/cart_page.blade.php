@extends('layouts.base')

@section('content')

@php
	if(session('promo_code')) {
		$promo_code = session('promo_code');
		$items_arr = session('items_arr');
	}

// dd($errors);

@endphp

<div class="cart-page">
	<div class="container">

		<div class="bread-crumbs-block">

			<a href="/" class="current-category-name">Главная</a>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">
					Корзина товаров
				</div>

			</div>

		</div>

		<div class="cart-page_items-block-wrapper">

			<h1>Корзина товаров</h1>

			@if($cart_products)

				<div class="cart-page_in-cart-info-wrapper js-info-wrapper">

					<div class="cart-page_items-block">

						<div class="cart-page_headers">

							<div class="image-block"></div>
							<div class="name-block">Товар</div>
							<div class="in-cart-block">Количество</div>
							<div class="line-total-price-block">Стоимость</div>
							
						</div>

						@foreach($cart_products as $item)

							<div
								class="cart-page_item-line js-cart-line"
								data-item-weight="{{ $item['item']->weight }}"
								data-item-id="{{ $item['item']->id_1c }}"
							>

								<div class="image-block">

									@if($item['item']->images->count())

										<img src="https://alfastok.by/storage/{{ $item['item']->images[0]->path_image }}">

									@else

										<img src="{{ asset('/img/no_image.jpg') }}">

									@endif

								</div>

								<div class="name-block">
									<div class="name">
										<a href="{{ asset('tovar/'.$item['item']->id_1c.'/'.$item['item']->slug) }}">
											{{ $item['item']->name }}
										</a>
									</div>

									<div class="code">
										Код товара: {{ $item['item']->id_1c }}
									</div>

									<div class="sings-line">

										@if($item['item']->comment_counter > 0)

											<div class="comments-wrapper">

												<div class="comment-stars">
													@include('includes.stars_handler')
												</div>

												<div class="comment-count">
													{{ $item['item']->comment_counter }} отзывов
												</div>

											</div>

										@endif

										@if($item['item']->is_new_item)

											<div class="new-item-sing">
												NEW
											</div>

										@endif
										
										@if($item['item']->is_action)

											<div class="action-sing">
												Акция
											</div>

										@endif

										@if(session('promo_code') && (in_array($item['item']->id_1c, $items_arr) || !$items_arr) && !$item['item']->is_action)

											<div class="promo-sing">
												Промокод: <span class="promo-name">{{ $promo_code->name }}</span>
											</div>

										@endif
									</div>

								</div>

								<div class="in-cart-block">

									<div class="item-card-page_count-input-block cart">

										<div class="minus js-in-cart-minus item_in_cart">-</div>

										<div
											class="order-count js-in-cart-input item_in_cart"
											data-item-code="{{ $item['item']->id_1c }}"
											data-rout-name="{{ Route::currentRouteName() }}"
										>
											<input type="number" value="{{ $item['count'] }}" min="1">
										</div>

										<div class="plus js-in-cart-plus item_in_cart">+</div>

									</div>

									@if($item['item']->is_action)

										<div class="item-price">
											<span class="js-item-price">{{ number_format($item['item']->action_price, 2, '.', '') }}</span>
											руб за шт.
										</div>

										<div class="old-price-wrapper">
											<div class="old-price-block">
												<div class="old-price">
													<span class="js-old-price">{{ number_format($item['item']->price, 2, '.', '') }}</span>
													руб
												</div>
												<div class="action-percent">
													-{{ number_format((1 - $item['item']->action_price / $item['item']->price) * 100, 2, '.', '') }}
													%
												</div>
											</div>
										</div>

									@elseif(session('promo_code') && (in_array($item['item']->id_1c, $items_arr) || !$items_arr))

										@php
											if(doubleval($promo_code->fixed)) {
												$promo_price = $item['item']->price - $promo_code->fixed;
												$promo_percent = $promo_code->fixed / $item['item']->price * 100;
											} else {
												$promo_price = $item['item']->price * (1 - $promo_code->percent / 100);
												$promo_percent = $promo_code->percent;
											}
										@endphp

										<div class="item-price">
											<span class="js-item-price">{{ number_format($promo_price, 2, '.', '') }}</span>
											руб за шт.
										</div>

										<div class="old-price-wrapper">
											<div class="old-price-block">
												<div class="old-price">
													<span class="js-old-price">{{ number_format($item['item']->price, 2, '.', '') }}</span>
													руб
												</div>
												<div class="action-percent">
													-{{ number_format($promo_percent, 2, '.', '') }}
													%
												</div>
											</div>
										</div>

									@else

										<div class="item-price">
											<span class="js-item-price">{{ number_format($item['item']->price, 2, '.', '') }}</span>
											руб за шт.
										</div>

									@endif

								</div>

								@php
									if($item['item']->is_action) {
										$line_price = $item['item']->action_price;
										$line_economy = number_format((($item['item']->price - $item['item']->action_price) * $item['count']), 2, '.', '');
									} elseif(session('promo_code') && (in_array($item['item']->id_1c, $items_arr) || !$items_arr)) {
										$line_price = number_format($promo_price, 2, '.', '');
										$line_economy = ($item['item']->price - number_format($promo_price, 2, '.', '')) * $item['count'];
									} else {
										$line_price = $item['item']->price;
										$line_economy = 0;
									}
								@endphp

								<div class="line-total-price-block">

									<div class="line-total-price-wrapper">

										<div class="line-total-price">
											<span class="js-line-total-price">{{ number_format($item['count'] * $line_price, 2, '.', '') }}</span>
											руб
										</div>

										@if(session('promo_code') && (in_array($item['item']->id_1c, $items_arr) || !$items_arr) || $item['item']->is_action)

											<div class="line-economy">
												экономия:
												<span class="js-line-economy">{{ $line_economy }}</span>
												руб
											</div>

										@endif
										
									</div>

									<div class="delete-item-link js-delete-item" title="Удалить {{ $item['item']->name }}">
										Удалить
									</div>

								</div>

							</div>

						@endforeach

					</div>

					<div class="cart-page_result-line">

						<div class="cart-page_promocode-block">

							<form method="POST" action="{{ route('promocode-activate') }}">

								{{ csrf_field() }}

								<div class="input">
									<input type="text" name="promo_code" placeholder="Промокод">
								</div>

								<div class="button" title="Применить промокод">
									<button type="submit" class="js-promo-button">Применить</button>
								</div>
								
							</form>

							<div class="drop-out-wrapper js-drop-out">
								<div class="drop-out-block">

									<div class="js-answer-text"></div>

									<div class="arrow">
										<div class="close-button js-close-drop">✕</div>
									</div>

								</div>
							</div>

						</div>

						@php
							// считаем результат
							$total_price = 0;
							$total_economy = 0;
							$total_weight = 0;
							// строка экономии
							$economy_str = "";

							foreach($cart_products as $item) {

								if($item['item']->is_action) {
									$line_economy_price = ($item['item']->price - $item['item']->action_price) * $item['count'];
									$total_economy += $line_economy_price;
									$total_price += $item['item']->action_price * $item['count'];

								} elseif(session('promo_code') && (in_array($item['item']->id_1c, $items_arr) || !$items_arr)) {

									if(doubleval($promo_code->fixed)) {
										$promo_price = $item['item']->price - $promo_code->fixed;
									} else {
										$promo_price = $item['item']->price * (1 - $promo_code->percent / 100);
									}

									$line_economy_price = ($item['item']->price - number_format($promo_price, 2, '.', '')) * $item['count'];
									$total_economy += $line_economy_price;
									$total_price += number_format($promo_price, 2, '.', '') * $item['count'];
								} else {
									$line_economy_price = "";
									$total_price += $item['item']->price * $item['count'];
								}

								// если есть экономия
								if($line_economy_price) {
									$economy_str .= $item['item']->id_1c."-".$line_economy_price."|";
								}

								$total_weight += $item['item']->weight * $item['count'];
							}

							// если строка экономии не пуста, удаляем крайнюю палочку
							if($economy_str) {
								$economy_str = mb_substr($economy_str, 0, -1);
							}

							// отображение строки результата экономии
							if($total_economy) {
								$total_economy_style = "block";
							} else {
								$total_economy_style = "none";
							}

							// отображение способов доставки в зависимости от веса
							if($total_weight < 28) {
								$delivery_type_style = "flex";
							} else {
								$delivery_type_style = "none";
							}

							$total_price = number_format($total_price, 2, '.', '');
							$total_economy = number_format($total_economy, 2, '.', '');
							$total_weight = number_format($total_weight, 2, '.', '');

						@endphp

						<div class="cart-page_result-block">

							<div class="total-price-block">
								<div class="title">Итого:</div>
								<div class="price">
									<span class="js-total-price">{{ $total_price }}</span>
									руб
								</div>
							</div>

							<div class="total-economy-wrapper js-total-economy-wrapper" style="display: {{ $total_economy_style }};">
								<div class="total-economy-block">
									<div class="title">Экономия:</div>
									<div class="economy">
										<span class="js-total-economy">{{ $total_economy }}</span>
										руб
									</div>
								</div>
							</div>

							<div class="total-weight-wrapper js-total-weight-wrapper">
								<div class="total-weight-block">
									<div class="title">Общий вес:</div>
									<div class="weight">
										<span class="js-total-weight">{{ $total_weight }}</span>
										кг
									</div>
								</div>
							</div>

						</div>

					</div>

					<div class="cart-page_start-registration-line js-start-registration">
						<div class="button">Оформить заказ</div>
					</div>

					<div class="cart-page_order-registration-block js-registration-block" style="display: none;">

						<form id="order-form" method="POST" action="{{ route('order') }}">
							{{ csrf_field() }}

							<input type="hidden" name="items_total" value="{{ $total_price }}">
							<input type="hidden" name="items_economy" value="{{ $total_economy }}">
							<input type="hidden" name="items_weight" value="{{ $total_weight }}">
							<input type="hidden" name="delivery_price" value="0">
							<input type="hidden" name="items_string" value="{{ $economy_str }}">
							<input type="hidden" name="promo_code_id" value="@if(session('promo_code')){{ $promo_code->id }}@endif">

							<div class="cart-page_personal-data-block js-personal-data-block" style="display: none;">

								<div class="title-block">
									<div class="title">Данные покупателя</div>

									@if(!Auth::check())

										<div class="enter-user-block">
											<span class="delimiter">|</span>
											<span class="enter js-enter-user">Войти</span>
										</div>

									@endif
									
								</div>

								@php
									// для типа клиента
									if(Auth::check()) {
										if($user['profile']->client_type == "Физическое лицо") {
											$cl_type_disp_fiz = "block";
											$cl_type_check_fiz = "checked";
											$cl_type_disp_jur = "none";
											$cl_type_check_jur = "";
											$requisites_block = "none";
										} else {
											$cl_type_disp_fiz = "none";
											$cl_type_check_fiz = "";
											$cl_type_disp_jur = "block";
											$cl_type_check_jur = "checked";
											$requisites_block = "block";
										}
									} else {
										$cl_type_disp_fiz = "block";
										$cl_type_check_fiz = "checked";
										$cl_type_disp_jur = "none";
										$cl_type_check_jur = "";
										$requisites_block = "none";
									}
								@endphp

								<div class="client-type-block">

									<label class="js-client">

										<div class="round-block">
											<div class="inner-round js-round" style="display: {{ $cl_type_disp_fiz }};"></div>
										</div>

										<input type="radio" name="client_type" value="individual" {{ $cl_type_check_fiz }}>

										<span class="title">Физическое лицо</span>

									</label>
									
									<label class="js-client">

										<div class="round-block">
											<div class="inner-round js-round" style="display: {{ $cl_type_disp_jur }};"></div>
										</div>

										<input type="radio" name="client_type" value="company" {{ $cl_type_check_jur }}>

										<span class="title">Юридическое лицо</span>

									</label>

								</div>

								<div class="user-data-block js-user-data-block">
									
									<div class="name-input-block">

										<div class="title">
											Имя
											<span class="red-star">*</span>
										</div>

										<div class="input required">
											<input
												type="text"
												name="name"
												placeholder="Имя на сайте"
												value="@if(Auth::check()){{ $user['name'] }}@endif"
											>
											<div class="inset js-input-inset" style="display: none;">
												<span class="">Это обязательное поле</span>
												<div class="inset-arrow"></div>
											</div>
										</div>

									</div>

									<div class="phone-input-block">

										<div class="title">
											Телефон
											<span class="red-star">*</span>
										</div>

										<div class="input required">
											<input
												type="tel"
												id="phone"
												name="phone"
												placeholder="+375 (29) 123-45-67"
												value="@if(Auth::check()){{ $user['phone'] }}@endif"
											>
											<div class="inset js-input-inset" style="display: none;">
												<span class="">Это обязательное поле</span>
												<div class="inset-arrow"></div>
											</div>
										</div>

										<div class="note">
											Для уточнения деталей
										</div>

									</div>

									<div class="email-input-block">

										<div class="title">
											E-mail
											<span class="red-star">*</span>
										</div>

										<div class="input required">
											<input
												type="email"
												name="email"
												placeholder="Ваш E-mail"
												value="@if(Auth::check()){{ $user['email'] }}@endif"
											>
											<div class="inset js-input-inset" style="display: none;">
												<span class="">Это обязательное поле</span>
												<div class="inset-arrow"></div>
											</div>
										</div>

										<div class="note">
											Для подтверждения заказа
										</div>

									</div>

									<div class="company-requisites-block js-requisites" style="display: {{ $requisites_block }};">

										<div class="company-input-block">

											<div class="input-block name-block">

												<div class="title">
													Наименование организации
												</div>

												<div class="input">
													<input
														type="text"
														name="company_name"
														placeholder="OOO Альфасад"
														value="@if(Auth::check()){{ $user['profile']->company_name }}@endif"
													>
												</div>

											</div>
											
											<div class="input-block unp-block">

												<div class="title">
													УНП
												</div>

												<div class="input">
													<input
														type="text"
														name="company_unp"
														placeholder="987876765"
														value="@if(Auth::check()){{ $user['profile']->unp }}@endif"
													>
												</div>

											</div>

											<div class="input-block empty-block"></div>
											
										</div>

										@php
											if(Auth::check() && $user['profile']->requisites){
												$requisites = $user['profile']->requisites;
											} else {
												$requisites = "Расчетный счет: 
Банк: 
Код банка: 
Адрес банка: 
ФИО руководителя: 
Должность руководителя: 
Действует на основании: ";
											}
										@endphp

										<textarea name="requisites">{{ $requisites }}</textarea>

										<div class="note">
											Вы значительно ускорите оформление документов, если заполните реквизиты вашей организации, или просто скопируете их с вашего фирменного бланка
										</div>

									</div>

								</div>
								
							</div>

							<div class="cart-page_personal-data_continue-button js-personal-data-continue" style="display: none;">
								Продолжить
							</div>

							<div class="cart-page_delivery-block js-delivery-block" style="display: none;">

								<div class="delivery-title">Доставка</div>

								<div class="delivery-type-block js-delivery-type-block">

									<label class="js-delivery">

										<div class="round-block">
											<div class="inner-round js-d-round" style="display: none;"></div>
										</div>

										<input type="radio" name="delivery_type" value="pickup">

										<span class="title">Самовывоз</span>

									</label>
									
									<label class="js-delivery">

										<div class="round-block">
											<div class="inner-round js-d-round" style="display: none;"></div>
										</div>

										<input type="radio" name="delivery_type" value="shipping">

										<span class="title">Доставка</span>

									</label>

{{-- 									<div class="calculator-link-block js-calculator-link-block">
										<span class="delimiter">|</span>
										<span class="enter js-calculator-link" title="Воспользуйтесь калькулятором для выбора оптимального способа доставки">Калькулятор</span>
									</div> --}}

									<div class="inset js-radio-inset" style="display: none;">
										<span class="">Сделайте выбор</span>
										<div class="inset-arrow"></div>
									</div>

								</div>

								<div class="cart-page_pickup-block js-pickup-block" style="display: none;">

									<div class="main-info">Самовывоз по адресу: г.Минск, Рогачевская, 14/14.</div>
									<div class="additional-info">
										Смотрите наш Пункт Выдачи
										<a href="https://yandex.ru/maps/?um=constructor%3A939b0307653b91871f8c5baf88738e962b64c78fd2488c1a999a9858806cca5a&source=constructorLink" target="_blank">
											на Yandex Карте</a>,
										<a href="https://www.google.com/maps/place/Альфасад/@53.9453365,27.7302985,17z/data=!3m1!4b1!4m6!3m5!1s0x46dbcbbfb4d85353:0x9ca9d9f7ef31a6e6!8m2!3d53.9453334!4d27.7324872!16s%2Fg%2F11hypsr7rv?hl=ru" target="_blank">
											на Google Карте
										</a>
									</div>
									<div class="additional-info">
										Скачать
										<a href="{{ asset('/files/route_scheme_retail.pdf') }}">
											Схему проезда
										</a>
									</div>

								</div>

								<div class="cart-page_shipping-wrapper">

									<div class="cart-page_shipping-block js-shipping-block" style="display: none;">
										
										<div class="shipping-type-header-block js-shipping-choice">
											<div class="shipping-type-header js-shipping-header">Выберите вариант доставки</div>
											<div class="arrow">
												@include('svg.arrow')
											</div>
										</div>

										<div class="label-block js-shipping-lable" style="display: none;">
											<label class="js-euro-to-punkt" style="display: {{ $delivery_type_style }};">
												<input type="radio" name="shipping" value="euro_punkt">
												<span class="js-shipping-title">Европочтой до Пункта Выдачи</span>
											</label>

											<label class="js-euro-to-door" style="display: {{ $delivery_type_style }};">
												<input type="radio" name="shipping" value="euro_door">
												<span class="js-shipping-title">Европочтой до двери</span>
											</label>

											<label class="js-to-minsk">
												<input type="radio" name="shipping" value="minsk">
												<span class="js-shipping-title">По Минску</span>
											</label class="js-shipping-lable">

											<label class="js-alfasad">
												<input type="radio" name="shipping" value="alfasad">
												<span class="js-shipping-title">По РБ (кроме Минска)</span>
											</label>
										</div>

										<div class="inset js-radio-inset" style="display: none;">
											<span class="">Сделайте выбор</span>
											<div class="inset-arrow"></div>
										</div>

									</div>

									<div class="cart-page_delivery-price-block js-shipping-price-block" style="display: none;">
										Стоимость доставки:
										<strong><span class="js-shipping-price">0</span>
										руб</strong>
									</div>
									
								</div>

								<div class="cart-page_address-block js-address-block" style="display: none;">

									<div class="title-line js-address-line js-for-minsk js-for-euro-door js-for-alfa" style="display: none;">

										<div class="title">Адрес доставки</div>

										@if(Auth::check())

											<div class="select-link-block">
												<span class="delimiter">|</span>
												<span class="select-link js-select-link" title="Выбрать / добавить адрес">Выбрать адрес</span>
											</div>

										@endif

									</div>
										
									<div class="cart-page_ship-to-block js-address-line js-for-minsk js-for-euro-door js-for-alfa" style="display: none;">

										<div class="city-input-block">

											<div class="title">
												Населенный пункт
												<span class="red-star">*</span>
											</div>

											<div class="input">
												<input
													type="text"
													name="city"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->city }}@endif"
												>
												<div class="inset js-input-inset" style="display: none;">
													<span class="">Это обязательное поле</span>
													<div class="inset-arrow"></div>
												</div>
											</div>

										</div>

										<div class="street-input-block">

											<div class="title">
												Улица
												<span class="red-star">*</span>
											</div>

											<div class="input">
												<input
													type="text"
													name="street"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->street }}@endif"
												>
												<div class="inset js-input-inset" style="display: none;">
													<span class="">Это обязательное поле</span>
													<div class="inset-arrow"></div>
												</div>
											</div>

										</div>

										<div class="house-input-block">

											<div class="title">
												Дом
												<span class="red-star">*</span>
											</div>

											<div class="input">
												<input
													type="text"
													name="house"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->house }}@endif"
												>
												<div class="inset js-input-inset" style="display: none;">
													<span class="">Это обязательное поле</span>
													<div class="inset-arrow"></div>
												</div>
											</div>

										</div>
										
										<div class="house-input-block">

											<div class="title">
												Корпус
											</div>

											<div class="input">
												<input
													type="text"
													name="corpus"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->corpus }}@endif"
												>
											</div>

										</div>

										<div class="house-input-block">

											<div class="title">
												Кв./Офис
											</div>

											<div class="input">
												<input
													type="text"
													name="flat"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->flat }}@endif"
												>
											</div>

										</div>

										<div class="house-input-block">

											<div class="title">
												Подъезд
											</div>

											<div class="input">
												<input
													type="text"
													name="entrance"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->entrance }}@endif"
												>
											</div>

										</div>

										<div class="house-input-block">

											<div class="title">
												Этаж
											</div>

											<div class="input">
												<input
													type="text"
													name="floor"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->floor }}@endif"
												>
											</div>

										</div>

									</div>

									<div class="cart-page_recipient-block js-address-line js-for-euro-pv js-for-euro-door" style="display: none;">

										<div class="name-input-block">

											<div class="title">
												Фамилия
												<span class="red-star">*</span>
											</div>

											<div class="input">
												<input
													type="text"
													name="family_name"
													placeholder="Фамилия"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->family_name }}@endif"
												>
												<div class="inset js-input-inset" style="display: none;">
													<span class="">Это обязательное поле</span>
													<div class="inset-arrow"></div>
												</div>
											</div>

										</div>
										
										<div class="name-input-block">

											<div class="title">
												Имя получателя
												<span class="red-star">*</span>
											</div>

											<div class="input">
												<input
													type="text"
													name="first_name"
													placeholder="Имя получателя"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->first_name }}@endif"
												>
												<div class="inset js-input-inset" style="display: none;">
													<span class="">Это обязательное поле</span>
													<div class="inset-arrow"></div>
												</div>
											</div>

										</div>

										<div class="name-input-block">

											<div class="title">
												Отчество
												<span class="red-star">*</span>
											</div>

											<div class="input">
												<input
													type="text"
													name="second_name"
													placeholder="Отчество"
													value="@if(Auth::check() && $user['address']->count()){{ $user['address'][0]->second_name }}@endif"
												>
												<div class="inset js-input-inset" style="display: none;">
													<span class="">Это обязательное поле</span>
													<div class="inset-arrow"></div>
												</div>
											</div>

										</div>

									</div>

									<div class="cart-page_euro-pv-block js-address-line js-for-euro-pv" style="display: none;">

										<div class="pv-input-block">

											<div class="title">
												Пункт выдачи Европочты
											</div>

											<div class="input">
												<input type="text" name="euro_pv">
											</div>

										</div>

									</div>

									<div class="cart-page_comment-block">

										<div class="comment-block">

											<div class="title">
												Комментарий
											</div>

											<textarea name="comment"></textarea>

										</div>

									</div>


								</div>
								
							</div>

							<div class="cart-page_delivery_continue-button js-delivery-continue" style="display: none;">
								Продолжить
							</div>

							<div class="cart-page_paying-block js-paying-block" style="display: none;">

								<div class="paying-title">Оплата</div>

								<div class="paying-type-block js-paying-type-block">

									<label class="js-paying">

										<div class="round-block">
											<div class="inner-round js-p-round" style="display: none;"></div>
										</div>

										<input type="radio" name="paying_type" value="upon_delivery" checked>

										<span class="title">При получении</span>

									</label>
									
{{-- 									<label class="js-paying">

										<div class="round-block">
											<div class="inner-round js-p-round" style="display: none;"></div>
										</div>

										<input type="radio" name="paying_type" value="site_online">

										<span class="title">Сейчас онлайн</span>

									</label> --}}

									<label class="js-paying js-invoice-paying" style="display: none;">

										<div class="round-block">
											<div class="inner-round js-p-round" style="display: none;"></div>
										</div>

										<input type="radio" name="paying_type" value="invoice">

										<span class="title">Безналичная оплата по счету</span>

									</label>

									<div class="inset js-radio-inset" style="display: none;">
										<span class="">Сделайте выбор</span>
										<div class="inset-arrow"></div>
									</div>

								</div>

								<div class="money-type-wrapper js-money-type-wrapper">

									<div class="upon-delivery_money-type-block js-upon-delivery-block" style="display: none;">

										<label class="js-money">

											<div class="round-block">
												<div class="inner-round js-m-round" style="display: none;"></div>
											</div>

											<input type="radio" name="money_type" value="cash">

											<span class="title">Наличными</span>

										</label>
										
										<label class="js-money">

											<div class="round-block">
												<div class="inner-round js-m-round" style="display: none;"></div>
											</div>

											<input type="radio" name="money_type" value="card">

											<span class="title">Картой</span>

										</label>

									</div>

									<div class="site-online_money-type-block js-site-online-block" style="display: none;">

										<label class="js-money">

											<div class="round-block">
												<div class="inner-round js-m-round" style="display: none;"></div>
											</div>

											<input type="radio" name="money_type" value="card_online">

											<span class="title">Картой</span>

										</label>
										
										<label class="js-money">

											<div class="round-block">
												<div class="inner-round js-m-round" style="display: none;"></div>
											</div>

											<input type="radio" name="money_type" value="card_installment">

											<span class="title">Картой рассрочки</span>

										</label>

										<label class="js-money">

											<div class="round-block">
												<div class="inner-round js-m-round" style="display: none;"></div>
											</div>

											<input type="radio" name="money_type" value="erip">

											<span class="title">Через ЕРИП</span>

										</label>

									</div>
									
									<div class="inset js-radio-inset" style="display: none;">
										<span class="">Сделайте выбор</span>
										<div class="inset-arrow"></div>
									</div>

								</div>

								<div class="cart-page_delivery-price-block">
									Общая стоимость:
									<strong><span class="js-total-plus-price">{{ $total_price }}</span>
									руб</strong>
								</div>

							</div>

							<div class="cart-page_confirm-order-button js-confirm-order" style="display: none;">
								Подтвердить заказ
							</div>







							
						</form>

					</div>



				</div>

			@endif

			@php
				if($cart_products) {
					$items_no_style = "none";
				} else {
					$items_no_style = "block";
				}
			@endphp

			<div class="cart-page_no-items-wrapper js-empty-cart" style="display: {{ $items_no_style }};">

				<div class="cart-page_no-items">
					Корзина пуста!
				</div>
				
			</div>
			
		</div>

	</div>

</div>

@if(\Auth::check() && isset($user))

	@include('popups.view_address')
	@include('cabinet.popups.new_address')
	@include('cabinet.popups.change_address')

@endif

@endsection

@section('css')
@parent


@endsection


@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('js/promo_code.js') }}"></script>

@endsection