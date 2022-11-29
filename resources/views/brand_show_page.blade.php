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

				<div class="current-category-name">

					<a href="{{ asset('/brands') }}" class="current-category-name">Бренды</a>

				</div>

			</div>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">

					{{ $brand->name }}

				</div>

			</div>

		</div>

		<section class="items-page_wrapper">
			
			<h1 class="items-page_name">
				Бренд {{ $brand->name }}
			</h1>

 			<div class="items-page_info-block">

				<div class="description">

					<img
						src="https://alfastok.by/storage/item-images/brand_logo/{{ $brand->image }}"
						class="image"
						title="логотип {{ $brand->name }}"
						alt="logo {{ $brand->name }}"
					>
					{!! $brand->content !!}

				</div>

			</div>

		</section>

	</div>
</div>

@endsection

@section('css')
@parent

    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('js/image_links_handler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/paginate_handler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sort_handler.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/filters.js') }}"></script>

@endsection