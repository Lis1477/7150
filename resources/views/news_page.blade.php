@extends('layouts.base')

@section('content')

<div class="news-page">
	<div class="container">

		<div class="bread-crumbs-block">

			<a href="/" class="current-category-name">Главная</a>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">
					Новости
				</div>

			</div>

		</div>

		<div class="news-page_block">

			<h1>Новости</h1>

			<div class="news-page_wrapper">

				@foreach($news as $val)

					<div class="news-page_element">

						<div class="image">
							<a href="{{ asset('novost/'.$val->alias) }}" title="{{ $val->title }}">
								<img src="https://alfastok.by/storage/{{ $val->path_image }}">
							</a>
						</div>

						<div class="title-block">
							<div class="date">{{ date('d.m.Y', strtotime($val->created_at)) }}</div>
							<a href="{{ asset('novost/'.$val->alias) }}" class="title" title="{{ $val->title }}">
								{{ $val->title }}
							</a>
						</div>
					</div>

				@endforeach

			</div>

		</div>

	</div>
</div>

@endsection
