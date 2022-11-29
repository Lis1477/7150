@extends('layouts.base')

@section('content')

<div class="simple-page">
	<div class="container">

		<div class="bread-crumbs-block">

			<a href="/" class="current-category-name">Главная</a>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">

					{{ $page->name }}

				</div>

			</div>

		</div>

		<div class="simple-page_block">

			<h1>{{ $page->name }}</h1>

			<div class="simple-page_content">

{{-- 				<p style="font-size: 18px;">
					<strong><a href="tel:7150">7150</a></strong>
					— единый мобильный номер для всех сотовых операторов<br>
					Звонок для <strong>всех</strong> абонентов – бесплатный
				</p>

				<br>

				<h2><strong>Телефоны интернет-магазина:</strong></h2>

				<p>
					<a href="tel:+375296867150">
						<img src="img/a1_ico.png" style="height: 16px; padding-right: 7px;">
						+375(29) 686-7150
					</a>
					<br>
					<a href="tel:+375336867150">
						<img src="img/mts_ico_2.png" style="height: 16px; padding-right: 7px;">
						+375(33) 686-7150
					</a>
					<br>
					<a href="tel:+375256667150">
						<img src="img/life_ico.png" style="height: 16px; padding-right: 7px;">
						+375(25) 666-7150
					</a>
				</p>

				<br>
 
				<h2><strong>Телефон сервисного центра:</strong></h2>

				<p>
					<a href="tel:+375291272626">
						<img src="img/a1_ico.png" style="height: 16px; padding-right: 7px;">
						+375(29) 127-26-26
					</a>
				</p>

				<br>

				<h2><strong>График работы:</strong></h2>

				<p>
					Пн-Чт: 9.00-17.30<br>
					Пт: 9.00-17.00<br>
					Пункт выдачи товаров до 16.30<br>
					Сб-Вс: Выходной
				</p>

				<br>

				<p style="font-style: italic;">Заказы через корзину принимаются круглосуточно 24/7</p>

				<br>

				<h2><strong>E-mail:</strong></h2>

				<p>
					<a href="mailto:7150@7150.by">7150@7150.by</a>
				</p>

				<br>

				<h2><strong>Мы в социальных сетях:</strong></h2>

				<div class="footer_social-links contact-page">

					<a href="https://www.instagram.com/katana.by/" target="_blank">
						<img src="/img/insta_ico.png" alt="ok ico" title="Мы в Instagram">
					</a>

					<a href="https://ok.ru/alfabelarus" target="_blank">
						<img src="/img/ok_ico.png" alt="ok ico" title="Мы в Одноклассниках">
					</a>

					<a href="https://vk.com/alfabelarus" target="_blank">
						<img src="img/vk_ico.png" alt="vk ico" title="Мы ВКонтакте">
					</a>

					<a href="https://www.facebook.com/AlfaBelarus/" target="_blank">
						<img src="/img/facebook_ico.png" alt="facebook ico" title="Мы в Facebook">
					</a>

					<a href="https://www.youtube.com/c/SkiperALFA" target="_blank">
						<img src="/img/youtube_ico.png" alt="youtube ico" title="Мы в Youtube">
					</a>

					<a href="https://twitter.com/alfabelarus" title="_blank">
						<img src="/img/twitter_ico.png" alt="twitter ico" title="Мы в Twitter">
					</a>

				</div>

				<h2><strong>Фактический адрес офиса и склада:</strong></h2>

				<p>
					Республика Беларусь, г.Минск, ул. Рогачевская, 14/14<br>
					(Примечание: ориентир в Яндекс и Google картах ул. Основателей, 27)
				</p>

				<br>

				<p>
					<a href="/files/route_scheme.pdf" title="Жми, чтобы скачать схему проезда"><strong>Скачать схему проезда</strong></a><br>
					<a href="/files/route_scheme.pdf" title="Жми, чтобы скачать схему проезда"><img src="/img/route_scheme.jpg" style="width: 100%; max-width: 615px;"></a><br>
					Координаты для навигатора: 53.945328, 27.732426
				</p>

				<br>

				<p>
					<img src="img/i_mag_1.jpg" style="width: 100%; max-width: 615px;">
					<img src="img/i_mag_2.jpg" style="width: 100%; max-width: 615px;">
				</p>
 --}}

				{!! $page->content !!}

			</div>

		</div>

	</div>
</div>

@endsection
