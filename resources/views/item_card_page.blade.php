@extends('layouts.base')

@section('content')

<div class="item-card-page">
	<div class="container">

		@include('includes.bread_crumbs_line')

		<section class="item-card-page_wrapper">
			
			<h1 class="item-card-page_name">
				{{ $item->name }}
			</h1>

			<div class="item-card-page_info-block">

				<div class="item-card-page_description-block">
					
					<div class="item-card-page_description-block_top-line">

						<div class="item-card-page_description-block_top-line-left">

							<div class="item-card-page_description-block_comments-wrapper">

								@if($item->comment_counter > 0)

									<div class="item-card-page_description-block_comment-stars">
										@include('includes.stars_handler')
									</div>

									<div class="item-card-page_description-block_comment-count">
										{{ $item->comment_counter }} отзывов
									</div>

								@endif

							</div>

							<div class="item-card-page_description-block_sings-block">

								@if($item->is_new_item)

									<div class="item-card-page_description-block_new-item-sing">
										NEW
									</div>

								@endif
								
								@if($item->is_action)

									<div class="item-card-page_description-block_action-sing">
										Акция
									</div>

								@endif

							</div>
							
						</div>

						<div class="item-card-page_description-block_top-line-right">
							
							<div class="item-card-page_description-block_item-code">
								Код товара: {{ $item->id_1c }}
							</div>

						</div>

					</div>

		            <div class="item-page_images-block">

		                <div class="item-page_big-images js-big-images" data-img-count="{{ $item->images->count() }}">

		                    @if($item->images->count() > 1)

		                        <div class="item-page_image-corner left js-left">
		                            @include('svg.arrow')                    
		                        </div>

		                    @endif

		                    <div class="item-page_image">

		                        @php($bnt = 1)

		                        @forelse($item->images as $image)

		                            @php
		                                if($loop->first) {
		                                    $disp = "block";
		                                    $bcls = "active";
		                                } else {
		                                    $disp = "none";
		                                    $bcls = "";
		                                }
		                            @endphp

		                            <a href="https://alfastok.by/storage/{{ $image->path_image }}"
		                                class="js-big-pic {{ $bcls }}"
		                                data-fancybox='images'
		                                data-caption="Изображение {{ $bnt }}"
		                                data-big-img-nun="{{ $bnt }}"
		                                style="display: {{ $disp }};"
		                            >
		                                <div class="image-wrapper">
		                                    <img src="https://alfastok.by/storage/{{ $image->path_image }}">
		                                </div>
		                            </a>

		                            @php($bnt++)

		                        @empty

		                            <img src="{{ asset('/img/no_image.jpg') }}">

		                        @endforelse

		                    </div>

		                    @if($item->images->count() > 1)

		                        <div class="item-page_image-corner right js-right">
		                            @include('svg.arrow')                    
		                        </div>
		                    
		                    @endif

		                </div>

		                <div class="item-page_thumb-images">

		                    @php($cnt = 1)

		                    @foreach($item->images as $image)

		                        @php
		                            if($cnt == 1) $cls = "active";
		                                else $cls = "";
		                        @endphp

		                        <div class="item-page_thumb-element {{ $cls }} js-img" data-img-num="{{ $cnt }}">
		                            <img src="https://alfastok.by/storage/{{ $image->path_image }}">
		                        </div>

		                        @php($cnt++)

		                    @endforeach
		            
		                </div>

		                <div class="item-page_thumb-images">

		                    @if(trim($item->youtube))

		                        @php
		                            $youtube_array = array_diff(explode(';', trim($item->youtube)), array('', NULL, false));
		                        @endphp

		                        @foreach($youtube_array as $youtube_link)

		                            @if(count(explode('=', $youtube_link)) > 1)
		                                @php
		                                    $youtube_code = explode('=', $youtube_link)[1];
		                                @endphp
		                            @else
		                                @php
		                                    $youtube_code = explode('.be/', $youtube_link)[1];
		                                @endphp
		                            @endif

		                            <div class="item-page_thumb-element" data-slide-index="{{ $cnt }}">
		                                <div
		                                    class="youtube js_video_link"
		                                    title="Смотреть видео о товаре на Youtube"
		                                    video="{{ $youtube_code }}"
		                                >
		                                    <img src="https://alfastok.by/assets/img/youtube.png">
		                                </div>
		                                <img src="@if($item->images->count()){{
		                                        'https://alfastok.by/storage/'.$item->images[0]->path_image
		                                    }}@else{{
		                                        'https://alfastok.by/upload/no-thumb.png'
		                                    }}@endif"
		                                >
		                            </div>

		                            @php($cnt++)

		                        @endforeach

		                    @endif

		                    @if($item->manual)

{{-- 		                        <a href="https://alfastok.by/storage/item-images/manuals/{{ $item->manual }}" class="item-page_thumb-element" target="_blank" title="скачать инструкцию по эксплуатации">
		                            <img src="">
		                            <div>Инструкция</div>
		                        </a>
 --}}
		                    @endif

		                </div>

		            </div>

				</div>

				<div class="item-card-page_price-block">
					
					<div class="item-card-page_icon-line">

						<div class="item-card-page_icons-block">

							<div
								class="icon discount js-want-cheaper-link"
								title="Хочу дешевле"
								data-name="{{ $item->name }}"
							>
								@include('svg.discount')
	 						</div>

							<div class="icon compare" title="Сравнить">
								@include('svg.compare')
							</div>

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
								class="icon favorites js-to-selected {{ $item_in_favorite_class }}"
								title="{{ $favorite_title }}"
								data-id-1c="{{ $item->id_1c }}"
							>
								@include('svg.favorites')
							</div>

						</div>

						<div class="item-card-page_in-stock-block">

							<div class="item-card-page_count-block">

								@if($item->count > 0)
									@php
										if($item->count < 5) {
											$style_2 = '';
											$style_3 = '';
											$tag_title = $item->count;
										} elseif ($item->count <= 10) {
											$style_2 = 'active';
											$style_3 = '';
											$tag_title = $item->count;
										} else {
											$style_2 = 'active';
											$style_3 = 'active';
											$tag_title = 'более 10';
										}
									@endphp

								<div class="item-card-page_count-ico-block">
									<div class="item-card-page_count-ico-el-1"></div>
									<div class="item-card-page_count-ico-el-2 {{ $style_2 }}"></div>
									<div class="item-card-page_count-ico-el-3 {{ $style_3 }}"></div>
								</div>

								<div class="item-card-page_count-string" title="На складе {{ $tag_title }} шт.">
									в наличии
								</div>

								@else

								<div class="item-card-page_count-string">
									нет наличии
								</div>

								@endif

							</div>

						</div>

					</div>

					@if($item->is_action && $item->action_price)

						<div class="item-card-page_action-line">

							<div class="item-card-page_action-old-price">
								{{ number_format($item->price, 2, '.', '') }} руб
							</div>

							<div class="item-card-page_action-percent">
								-{{ number_format((1 - $item->action_price / $item->price) * 100, 0) }}%
							</div>

							<div class="item-card-page_action-benefit">
								{{ number_format(($item->price - $item->action_price), 2, '.', '') }} руб
							</div>

						</div>

					@endif

					<div class="item-card-page_price-line">
						
						<div class="item-card-page_price">

							@if($item->is_action && $item->action_price)

								{{ number_format($item->action_price, 2, '.', '') }} руб

							@else

								{{ number_format($item->price, 2, '.', '') }} руб

							@endif

						</div>

						@php

							$item_in_cart = false;

							if(count($cart_items)) { // данные из ViewComposers
								foreach($cart_items as $val) {
									if($val->item_code == $item->id_1c) {
										$item_in_cart = true;
										$input_val = $val->item_count;
										break;
									}
								}
							}

							if($item_in_cart) {
								$button_str = "ТОВАР В КОРЗИНЕ";
								$button_class = "item_in_cart";
								$button_title = "Перейти в корзину";
								$item_in_cart_class = "item_in_cart";
							} else {
								$button_str = "ДОБАВИТЬ В КОРЗИНУ";
								$button_class = "";
								$button_title = "Добавить товар в корзину";
								$input_val = 1;
								$item_in_cart_class = "";
							}

						@endphp

						<div class="item-card-page_count-input-block">

							<div class="minus js-in-cart-minus {{ $item_in_cart_class }}">-</div>

							<div
								class="order-count js-in-cart-input {{ $item_in_cart_class }}"
								data-item-code="{{ $item->id_1c }}"
								data-rout-name="{{ Route::currentRouteName() }}";
							>
								<input type="number" value="{{ $input_val }}" min="1" max="99999">
							</div>

							<div class="plus js-in-cart-plus {{ $item_in_cart_class }}">+</div>

						</div>

					</div>

					<div
						class="item-card-page_in-cart-button js-in-cart-button {{ $button_class }}"
					>
						<div class="title" title="{{ $button_title }}">{{ $button_str }}</div>
						<div class="icon">
							@include('svg.in_cart')
						</div>
					</div>

					<div
						class="item-card-page_one-click-button js-one-click-butt"
						title="Оформить заказ в 1 клик"
						data-id_1c="{{ $item->id_1c }}"
						data-name="{{ $item->name }}"
					>
						<div class="title">
							КУПИТЬ В 1 КЛИК
						</div>
						<div class="icon">
							@include('svg.finger')
						</div>
					</div>

				</div>

			</div>

			<h2 class="item-card-page_about-product-title">Информация о продукте</h2>

			<div class="item-card-page_about-product-block">

				<div class="left-block">

					@if($about_product['brief_description'])

						<div class="brief-description">
							{{ $about_product['brief_description'] }}
						</div>

					@endif

					@if(count($about_product['advantages']))

						<div class="advantages-description">

							<h3>Преимущества:</h3>

							<div class="advantages-description-text">

								@foreach($about_product['advantages'] as $str)

									<p>{{ $str }}</p>

								@endforeach

							</div>

						</div>
					
					@endif

					@if(count($about_product['characteristics']))

						<div class="characteristics-description">

							<h3>Характеристики:</h3>

							<div class="characteristics-description-text">

								@foreach($about_product['characteristics'] as $key => $val)

									<p><span class="parameter-name">{{ $key }}:</span> {{ $val }}</p>

								@endforeach

							</div>

						</div>
					
					@endif

				</div>

				<div class="right-block">

					@if(count($about_product['equipment']))

						<div class="equipment-description">

							<h3>Комплектация:</h3>

							<div class="equipment-description-text">

								@foreach($about_product['equipment'] as $str)

									<p>{{ $str }}</p>

								@endforeach

							</div>

						</div>
					
					@endif

					@if(count($about_product['additional_datas']))

						<div class="additional-description">

							<h3>Дополнительные данные:</h3>

							<div class="additional-description-text">

								@foreach($about_product['additional_datas'] as $key => $val)

									<p><span class="parameter-name">{{ $key }}:</span> {{ $val }}</p>

								@endforeach

							</div>

						</div>
					
					@endif
					
				</div>
					
			</div>

		</section>

		@if($cat_items->count())

			<section class="main-page_popular-items-block">

				<div class="container">

					<h2>Похожие товары</h2>

					<div class="main-page_popular-items">

						<div class="main-page_items-line popular" data-item-count = "{{ $cat_items->count() }}">

							@foreach($cat_items as $item)

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



	</div>
</div>

{{-- Всплывающее окно видео Youtube --}}
@include('popups.popup_youtube')  


@endsection

@section('css')
@parent

<link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}">

@endsection


@section('scripts')

<script type="text/javascript" src="{{ asset('js/blowup.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/item_card_img.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/youtube.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/jquery.fancybox.js') }}"></script>
<script>
    $(function() {
        $("[data-fancybox]").fancybox({loop:true});
    });
</script>

<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui-touch.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main_page_block_lister.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/image_links_handler.js') }}"></script>

@parent


@endsection