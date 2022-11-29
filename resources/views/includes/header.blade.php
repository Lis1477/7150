<header>

	<div class="header_logo">
		<div class="container">
			<a href="/" title="На Главную страницу">
				<img src="{{ asset('img/logo7150.png') }}" alt="company logo">
			</a>
		</div>
	</div>

	<section class="top-line">
		<div class="container">

		    <div class="main-menu_burger js-burger">
		        <hr class="hr-1">
		        <hr class="hr-2">
		        <hr class="hr-3">
		    </div>

			<nav class="top-line_main-menu js-main-menu">
				<ul>
					<li>
						<a href="{{ asset('page/kontakty') }}">Контакты</a>
					</li>
					<li>
						<a href="{{ asset('page/dostavka') }}">Доставка</a>
					</li>
					<li>
						<a href="{{ asset('page/servisniye-tsentry') }}">Сервис-центр</a>
					</li>
					<li>
						<a href="{{ asset('page/oplata') }}">Оплата</a>
					</li>
					<li>
						<a href="{{ asset('novosty') }}">Новости</a>
					</li>
				</ul>
			</nav>

			<div class="top-line_info-block">
				<div class="top-line_phones">
					<div class="top-line_first-phone js-phones">
						<img src="{{ asset('img/a1_ico.png') }}" alt="a1 ico">
						<a href="tel:+375296867150">+375 29 686 71 50</a>
						<span>&#8250;</span>
					</div>
					<div class="top-line_dropdown-phones js-phones-drop-down">
						<div class="top-line_dropdown-phones_phone">
							<img src="{{ asset('img/a1_ico.png') }}" alt="a1 ico">
							<a href="tel:+375296867150">+375 29 686 71 50</a>
						</div>

						<div class="top-line_dropdown-phones_phone">
							<img src="{{ asset('img/mts_ico_2.png') }}" alt="mts ico">
							<a href="tel:+375336867150">+375 33 686 71 50</a>
						</div>

						<div class="top-line_dropdown-phones_phone">
							<img src="{{ asset('img/life_ico.png') }}" alt="mts ico">
							<a href="tel:+375256667150">+375 25 666 71 50</a>
						</div>

{{-- 						<div class="top-line_dropdown-phones_phone last">
							<img src="{{ asset('img/beltel_ico.png') }}" alt="beltelecom ico">
							<a href="tel:+375173884188">+375 17 388 41 88</a>
						</div> --}}

						<div class="top-line_dropdown-phones_common-phone">
							Единый номер -
							<a href="tel:7150">7150</a>
						</div>

						<div class="top-line_dropdown-phones_call-order-button">
							<a href="#" class="feedback-button js-feedback-button" title="Заказать звонок или Написать сообщение">
								Обратная связь
							</a>
						</div>
					</div>
				</div>

				<div class="top-line_address">
					<img src="{{ asset('img/address_ico.png') }}" alt="address ico">
					<address>г.Минск, ул.Рогачевская, 14/14</address>
				</div>
			</div>
		</div>
		
	</section>

	<section class="logo-line">
		<div class="container">


			<div class="logo-line_logo">
			</div>

			<div class="logo-line_search-block js-search-block">

				<form method="GET" action="{{ asset('search') }}">
					<input type="text" name="search_string" placeholder="Поиск по каталогу" class="js-search">
					{{-- {{ csrf_field() }} --}}
					<span class="js-string-del" title="Стереть запрос">✕</span>
					<button type="submit" class="js-search-submit" title="Поиск">
						<img src="{{ asset('img/search_ico.png') }}" alt="search button">	
					</button>
				</form>

				<div class="search-result-wrapper js-result-block" style="display: none;"></div>

			</div>

			<div class="logo-line_links-block">
{{-- 				<div class="logo-line_compare-block">

					<svg viewBox="0 0 100 80">
					  <path class="fil0" d="M78.94 -0.17l-20.16 7.57c-2.12,-2.51 -5.24,-4.15 -8.77,-4.15 -6.37,0 -11.54,5.18 -11.54,11.54 0,0.08 0.02,0.16 0.02,0.24l-19.25 7.46 -19.24 33.64 0 1.03c0,10.59 8.63,19.17 19.24,19.17 4.3,0 8.28,-1.41 11.48,-3.8l0 7.64c12.84,0 25.67,0 38.51,0l0 -7.69 -15.38 0 0 -46.86c4.46,-1.6 7.69,-5.83 7.69,-10.83 0,-0.07 -0.01,-0.14 -0.01,-0.21l16.2 -6.09 -16.19 28.36 0 1.02c0,10.6 8.63,19.22 19.24,19.22 10.59,0 19.22,-8.62 19.22,-19.22l0 -1.02 -17.27 -30.23 -3.79 -6.79 0 0zm-48.15 72.65c4.66,-3.5 7.68,-9.06 7.68,-15.32l0 -1.03 -15.35 -26.86 18.14 -7.06c1.3,1.54 2.97,2.72 4.89,3.41l0 46.86 -15.36 0 0 0zm19.22 -61.54c2.11,0 3.84,1.74 3.84,3.85 0,2.12 -1.73,3.84 -3.84,3.84 -2.13,0 -3.86,-1.72 -3.86,-3.84 0,-2.11 1.73,-3.85 3.86,-3.85zm30.77 7.75l8.76 15.33 -17.53 0 8.77 -15.33 0 0zm-61.54 19.3l8.72 15.26 -17.45 0 8.73 -15.26zm50.7 3.72l21.65 0c-1.58,4.47 -5.8,7.69 -10.81,7.69 -5.01,0 -9.24,-3.22 -10.84,-7.69zm-61.55 19.24l21.69 0c-1.58,4.49 -5.81,7.75 -10.84,7.75 -5.04,0 -9.27,-3.26 -10.85,-7.75z"/>
					</svg>

					<span>Сравнить</span>

					<div class="logo-line_compare-counter">0</div>
				</div> --}}

				@php 
					// класс для активной иконки избранных
					if(Route::currentRouteName() == 'favorite-items-page') {
						$favorite_icone_class = 'active';
					} else {
						$favorite_icone_class = '';
					}
					// для счетчика избранных
					if(count($selected_items)) { // данные из ViewComposers
						$in_favorite_count = count($selected_items);
						$in_favorite_class = "item_in_favorite";
					} else {
						$in_favorite_count = "0";
						$in_favorite_class = "";
					}
				@endphp

				<a href="{{ asset('favorite-items') }}" class="logo-line_favorites-block {{ $favorite_icone_class }}">

					<svg viewBox="0 0 100 91">
						<path class="fil0" d="M55.02 2.93c4.85,-2.38 9.1,-3.17 15.68,-3.17 16.84,0.07 29.3,14.27 29.3,32.36 0,13.82 -7.71,27.15 -22.05,40.04 -7.52,6.78 -17.13,13.47 -24.01,17.04l-3.94 2.04 -3.94 -2.04c-6.88,-3.57 -16.49,-10.27 -24.01,-17.04 -14.34,-12.89 -22.05,-26.22 -22.05,-40.04 0,-18.28 12.35,-32.36 29.33,-32.36 6.36,0 10.81,0.86 15.77,3.32 1.73,0.84 3.34,1.86 4.86,3.02 1.57,-1.23 3.25,-2.3 5.06,-3.17zm16.85 62.48c12.61,-11.34 19.04,-22.47 19.04,-33.29 0,-13.32 -8.7,-23.21 -20.23,-23.27 -5.29,0 -8.2,0.54 -11.68,2.24 -2.12,1.05 -4.03,2.46 -5.67,4.25l-3.32 3.6 -3.34 -3.57c-1.62,-1.72 -3.49,-3.1 -5.6,-4.15 -3.58,-1.77 -6.69,-2.37 -11.74,-2.37 -11.67,0 -20.24,9.76 -20.24,23.27 0,10.82 6.43,21.95 19.04,33.29 6.86,6.18 15.69,12.35 21.87,15.59 6.18,-3.24 15.01,-9.41 21.87,-15.59l0 0z"/>
					</svg>


					<span>Избранное</span>

					<div class="logo-line_favorites-counter js-item-in-favorite {{ $in_favorite_class }}">{{ $in_favorite_count }}</div>
				</a>

				@php
					// класс, если в кабинете
					if(Route::getCurrentRoute()->getPrefix() == '/cabinet') {
						$cabinet_icone_class = 'active';
					} else {
						$cabinet_icone_class = '';
					}
					// класс если залогинен
					if (Auth::check()) {
						$user_logo_style = "logged js-options-open";
						$name_str = Auth::user()->name;
					} else {
						$user_logo_style = "js-enter-user";
						$name_str = "Войти";
					}
				@endphp

				<div class="logo-line_user-block {{ $user_logo_style }} {{ $cabinet_icone_class }}" title="{{ $name_str }}">

					<svg viewBox="0 0 80 100">
						<path class="fil0" d="M15.01 39.98l0 -14.99c0,-13.81 11.18,-24.99 24.99,-24.99 13.81,0 24.99,11.18 24.99,24.99l0 14.99 5.01 0c5.34,0 10,3.89 10,9.17l0 41.68c0,5.28 -4.66,9.17 -10,9.17l-60 0c-5.34,0 -10,-3.89 -10,-9.17l0 -41.68c0,-5.28 4.66,-9.17 10,-9.17l5.01 0 0 0zm9.98 0l30.02 0 0 -14.99c0,-8.29 -6.72,-15.01 -15.01,-15.01 -8.29,0 -15.01,6.72 -15.01,15.01l0 14.99zm-14.99 10.02l0 40 60 0 0 -40 -60 0zm30 24.99c-2.77,0 -5.01,-2.24 -5.01,-5.01 0,-2.75 2.24,-4.99 5.01,-4.99 2.77,0 5.01,2.24 5.01,4.99 0,2.77 -2.24,5.01 -5.01,5.01z"/>
					</svg>

					<span title="{{ $name_str }}">{{ $name_str }}</span>

					<div class="user-options js-options-block" style="display: none;">

						<div class="user-options_user-name">
							{{ $name_str }}
						</div>

						<div class="user-options_links-block">

							<div>
								<a href="{{ asset('cabinet/profile') }}" title="Смотреть / редактировать профиль">Профиль</a>
							</div>

							<div>
								<a href="{{ asset('cabinet/history') }}" title="Смотреть историю заказов">История заказов</a>
							</div>

						</div>

						<div class="user-options_logout-link">

		                    <a href="{{ route('logout') }}"
		                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
		                        title="Выйти из аккаунта" 
		                    >
		                        Выйти
		                    </a>

		                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		                        {{ csrf_field() }}
		                    </form>

						</div>

					</div>

				</div>

				@php
					// класс для активной иконки корзины
					if(Route::currentRouteName() == 'cart-page') {
						$cart_icone_class = 'active';
					} else {
						$cart_icone_class = '';
					}
					// для счетчика корзины
					if(count($cart_items)) { // данные из ViewComposers
						$in_cart_count = count($cart_items);
						$in_cart_class = "item_in_cart";
					} else {
						$in_cart_count = "0";
						$in_cart_class = "";
					}
				@endphp

				<div class="logo-line_cart-block js-mini-cart-link {{ $cart_icone_class }}">

					<svg viewBox="0 0 100 100">
						<path class="fil0" d="M17.73 10.44c0.81,-0.19 1.67,-0.29 2.55,-0.29l69.6 4.98c6.25,0.11 12.34,5.28 9.33,11.99 -0.58,1.31 -3.23,6.65 -7.45,15.02 -1.71,3.43 -3.48,6.93 -5.25,10.43 -0.98,1.97 -0.98,1.97 -1.7,3.38 -0.32,0.63 -0.45,0.89 -0.53,1.03 -1.42,3.69 -4.45,6.54 -8.23,7.74l-0.73 0.24 -50.22 0 -0.07 -0.02 -9.84 0c-2.83,0.14 -5.1,2.41 -5.22,4.99l-0.02 4.69c0.17,2.85 2.46,5.12 4.99,5.28l0.86 0c2.04,-5.81 7.59,-9.97 14.1,-9.97 6.5,0 12.03,4.16 14.09,9.97l11.67 0c2.04,-5.81 7.59,-9.97 14.1,-9.97 8.25,0 14.94,6.7 14.94,14.96 0,8.24 -6.69,14.94 -14.94,14.94 -6.51,0 -12.06,-4.17 -14.1,-9.97l-11.67 0c-2.06,5.8 -7.59,9.97 -14.09,9.97 -6.53,0 -12.06,-4.17 -14.1,-9.97l-1.13 -0.02c-7.88,-0.44 -14.19,-6.74 -14.67,-14.94l0 -5.22c0.4,-7.93 6.73,-14.27 14.89,-14.69l-4.88 -34.18 -0.04 -0.71c0,-3.22 -1.65,-7.04 -3.53,-8.92 -0.49,-0.5 -2.66,-1.04 -6.44,-1.04l0 -9.97c6.19,0 10.65,1.12 13.49,3.96 1.66,1.66 3.12,3.86 4.24,6.31l0 0zm7.73 44.55l48.12 0c0.67,-0.37 1.18,-0.97 1.45,-1.69l0.24 -0.58c0.12,-0.22 0.12,-0.22 0.64,-1.27 0.72,-1.39 0.72,-1.39 1.71,-3.37 1.77,-3.49 3.52,-7 5.16,-10.26l0.08 -0.15c2.89,-5.74 5.09,-10.14 6.3,-12.61l-69.18 -4.96 4.88 34.19c0.04,0.33 0.3,0.6 0.6,0.7l0 0zm44.3 34.87c2.74,0 4.97,-2.23 4.97,-4.98 0,-2.75 -2.23,-4.99 -4.97,-4.99 -2.76,0 -4.99,2.24 -4.99,4.99 0,2.75 2.23,4.98 4.99,4.98zm-39.86 0c2.74,0 4.97,-2.23 4.97,-4.98 0,-2.75 -2.23,-4.99 -4.97,-4.99 -2.76,0 -5,2.24 -5,4.99 0,2.75 2.24,4.98 5,4.98z"/>
					</svg>

					<span>Корзина</span>

					<div class="logo-line_cart-counter js-in-cart-mini {{ $in_cart_class }}">{{ $in_cart_count }}</div>
				</div>
			</div>
		</div>
	</section>

	<section class="catalog-line">
		<div class="container">
			<div class="catalog-line_catalogues-button js-button-catalog">
				<a href="#">
					<div class="catalog-line_catalogues-button_icon">
						<img src="{{ asset('img/burger_katalog_ico.png') }}" alt="katalog burger">
					</div>

					<div class="catalog-line_catalogues-button_title">
						Каталог
					</div>
				</a>
			</div>

			<div class="catalog-line_catalog-titles">

{{-- 				<a href="#" class="catalog-line_actions-link">
					Акции
				</a> --}}

				@foreach($header_cats as $cat)

				<a href="{{ asset('category/'.$cat->id_1c.'/'.$cat->slug) }}" class="catalog-line_catalog-link">
					{{ $cat->name }}
				</a>

				@endforeach

			</div>

			@include('includes.button_category')

		</div>

	</section>

</header>
