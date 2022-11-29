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

				<div class="current-category-name">

					<a href="{{ asset('/novosty') }}" class="current-category-name">Новости</a>

				</div>

			</div>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">

					{{ $news->title }}

				</div>

			</div>

		</div>

		<div class="simple-page_block">

			<h1>{{ $news->title }}</h1>

			<div class="simple-page_content news js-news-content">

				{!! $news->content !!}

			</div>

		</div>

	</div>
</div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{ asset('js/img_link_replacer.js') }}"></script>

@parent

@endsection
