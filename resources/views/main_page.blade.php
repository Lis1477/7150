@extends('layouts.base')

@section('content')

<section class="main-page_promo-line">
	<div class="container">

		<div class="main-page_promo-line_slider-container">

			<div class="main-page_promo-line_slider-block" data-pic-count="{{ $sliders->count() }}">

				@php($key = 1)

				@foreach($sliders as $slide)

				<a href="{{ $slide->link }}" target="_blank" class="js-img-link" data-pic="{{ $key }}">
					<img
						src="{{ asset('img/'.$slide->image) }}"
						alt="{{ $slide->image }}"
					>
				</a>
				
					@php($key++)
				@endforeach

			</div>

			<div class="main-page_slider-lines-block">

				@for($i = 1; $i <= $sliders->count(); $i++)

				<div 
					class="main-page_slider-lines-block_line"
					data-line="{{ $i }}"
				>
					<div class="main-page_slider-lines-block_line-back"></div>
				</div>

				@endfor
				
			</div>

		</div>

		<div class="main-page_promo-line_sales-block">

			<a href="{{ asset($banners[0]->link) }}" class="main-page_promo-line_big-block" target="_blank">
				<div class="main-page_promo-line_orange-round"></div>

				<div class="main-page_promo-line_sale-percent">
					Хит
				</div>

				<div class="main-page_promo-line_sale-header">
					{{ $banners[0]->title }}
				</div>

				<div class="main-page_promo-line_sale-image-big">
					<img src="{{ asset('img/'.$banners[0]->image) }}">
				</div>
				
			</a>
			<div class="main-page_promo-line_small-blocks">
				<a href="{{ asset($banners[1]->link) }}" class="main-page_promo-line_small-blocks-element" target="_blank">
					<div class="main-page_promo-line_orange-round"></div>

					<div class="main-page_promo-line_sale-percent">
						Хит
					</div>

					<div class="main-page_promo-line_sale-header">
						{{ $banners[1]->title }}
					</div>
					
					<div class="main-page_promo-line_sale-image-small">
						<img src="{{ asset('img/'.$banners[1]->image) }}">
					</div>
				</a>
				<a href="{{ asset($banners[2]->link) }}" class="main-page_promo-line_small-blocks-element" target="_blank">
					<div class="main-page_promo-line_orange-round"></div>

					<div class="main-page_promo-line_sale-percent">
						Хит
					</div>
					
					<div class="main-page_promo-line_sale-header">
						{{ $banners[2]->title }}
					</div>
				
					<div class="main-page_promo-line_sale-image-small">
						<img src="{{ asset('img/'.$banners[2]->image) }}">
					</div>
				</a>
			</div>
		</div>
	    
	</div>
</section>

<section class="main-page_benefits-line">
	<div class="container">
		<div class="main-page_benefit-element">
			<div class="main-page_benefit-img">
				<img src="{{ asset('img/delivery_ico.png') }}">
			</div>
			<div class="main-page_benefit-text">
				Доставка по РБ<br>БЕСПЛАТНАЯ
			</div>
		</div>
		
		<div class="main-page_benefit-element">
			<div class="main-page_benefit-img">
				<img src="{{ asset('img/card_ico.png') }}">
			</div>
			<div class="main-page_benefit-text">
				Возможна оплата<br>КАРТАМИ РАССРОЧКИ
			</div>
		</div>
		
		<div class="main-page_benefit-element">
			<div class="main-page_benefit-img">
				<img src="{{ asset('img/sale_ico.png') }}">
			</div>
			<div class="main-page_benefit-text">
				Дополнительные<br>СКИДКИ за самовывоз
			</div>
		</div>
		
		<div class="main-page_benefit-element">
			<div class="main-page_benefit-img">
				<img src="{{ asset('img/gift_ico.png') }}">
			</div>
			<div class="main-page_benefit-text">
				ПОДАРКИ за<br>видеоотзыв
			</div>
		</div>
		
	</div>
</section>

@if($new_items)

<section class="main-page_popular-items-block">

	<div class="container">

		<h2>
			<a href="{{ asset('noviye-tovary') }}" title="Все новинки">
				Новинки
			</a>
		</h2>

		<div class="main-page_popular-items">

			<div class="main-page_items-line news" data-item-count = "{{ $new_items->count() }}">

				@foreach($new_items as $item)
@include('includes.item_block')
				@endforeach

			</div>

			<div class="main-page_left-lister news" style="opacity: 0;">
				<img src="{{ asset('img/corner.png') }}">
			</div>

			<div class="main-page_right-lister news" style="opacity: 1;">
				<img src="{{ asset('img/corner.png') }}">
			</div>

		</div>

	</div>
</section>

@endif

<section class="main-page_popular-items-block">

	<div class="container">

		<h2>Популярные товары</h2>

		<div class="main-page_popular-items">

			<div class="main-page_items-line popular" data-item-count = "{{ $popular_items->count() }}">

				@foreach($popular_items as $item)
@include('includes.item_block')
				@endforeach

			</div>

			<div class="main-page_left-lister popular" style="opacity: 0;">
				<img src="{{ asset('img/corner.png') }}">
			</div>

			<div class="main-page_right-lister popular" style="opacity: 1;">
				<img src="{{ asset('img/corner.png') }}">
			</div>

		</div>

	</div>
</section>

@if($brands->count())

	<section class="main-page_brand-block">

		<div class="container">

			<h2>
				<a href="{{ asset('/brands') }}" title="Смотреть все бренды">
					Бренды
				</a>
			</h2>

			<div class="brand-wrapper">

				@foreach($brands as $brand)

					<div class="brand-element">

						<a
							href="{{ asset('brand/'.$brand->slug) }}"
							class="image"
							title="Жми, чтобы узнать подробнее о бренде {{ $brand->name }}"
						>
							<img src="https://alfastok.by/storage/item-images/brand_logo/{{ $brand->image }}">
						</a>
						
					</div>

				@endforeach
				
			</div>

		</div>

	</section>

@endif

@if($news->count())

	<section class="main-page_news-block">

		<div class="container">

			<h2>
				<a href="{{ asset('novosty') }}" title="Смотреть ВСЕ новости">
					Новости
				</a>
			</h2>

			<div class="main-page_news-links">

				@foreach($news as $val)

					<a href="{{ asset('novost/'.$val->alias) }}" class="main-page_news-element" title="{{ $val->title }}">
						<img src="https://alfastok.by/storage/{{ $val->path_image }}">
					</a>

				@endforeach

			</div>
			
		</div>

	</section>

@endif

@if($seen_items)

<section class="main-page_seen-items-block">
	
	<div class="container">

		<h2>Просмотренные товары</h2>

		<div class="main-page_seen-items">

			<div class="main-page_items-line seen" data-item-count = "{{ $seen_items->count() }}">

				@foreach($seen_items as $item)
@include('includes.item_block')
				@endforeach

			</div>

			<div class="main-page_left-lister seen" style="opacity: 0;">
				<img src="{{ asset('img/corner.png') }}">
			</div>

			<div class="main-page_right-lister seen" style="opacity: 1;">
				<img src="{{ asset('img/corner.png') }}">
			</div>

		</div>

	</div>

</section>

@endif

@endsection

@section('css')
@parent

    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui-touch.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main_page_slider.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main_page_block_lister.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/image_links_handler.js') }}"></script>

<script type="text/javascript">
// редирект в родительскую категорию
$(document).ready(function(){
	$('.js-parent-cat-link').click(function(e){
		e.preventDefault();
		window.open($(this).data('link'));
	});
});
</script>

@endsection