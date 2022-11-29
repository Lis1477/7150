@extends('layouts.base')

@section('content')

<div class="items-page">
	<div class="container">

		{{-- @include('includes.bread_crumbs_line') --}}

		<section class="items-page_wrapper">
			
			<h1 class="items-page_name">
				Избранные товары
			</h1>

 			<div class="items-page_info-block">

				<aside class="items-page_left-block">

{{-- 					<div class="items-page_advertising-block">
						<div class="advertising-test">
							<div class="text">РЕКЛАМА</div>
						</div>
					</div>
					<div class="items-page_advertising-block">
						<div class="advertising-test">
							<div class="text">РЕКЛАМА</div>
						</div>
					</div>
 --}}
				</aside>

				<div class="items-page_items-wrapper">

					@if($favorite_items)

						<div class="items-page_items-block">

							@foreach($favorite_items as $item)

								@include('includes.item_block')

							@endforeach
							
						</div>

					@endif

					@php
						if($favorite_items) {
							$no_favorites_class = "none";
						} else {
							$no_favorites_class = "block";
						}
					@endphp

					<div class="favorites-page_no-favorites js-no-favorites" style="display: {{ $no_favorites_class }};">
						У Вас пока нет избранных товаров!
					</div>
					
				</div>

			</div>

		</section>

	</div>
</div>

@endsection


@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('js/image_links_handler.js') }}"></script>

@endsection