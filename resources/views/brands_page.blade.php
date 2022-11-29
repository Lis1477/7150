@extends('layouts.base')

@section('content')

<div class="items-page">
	<div class="container">

		<div class="bread-crumbs-block">

			<a href="/" class="current-category-name">Главная</a>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">

					Бренды

				</div>

			</div>

		</div>

		<section class="items-page_wrapper">
			
			<h1 class="items-page_name">
				Бренды
			</h1>

 			<div class="items-page_info-block">

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

	</div>
</div>

@endsection

@section('scripts')
@parent


@endsection