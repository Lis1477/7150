@extends('layouts.base')

@section('content')

<div class="category-page">
	<div class="container">

		@include('includes.bread_crumbs_line')

		<section class="category-page_wrapper">
			
			<h1 class="category-page_name">
				{{ $current_cat->name }}
			</h1>

			<div class="category-page_info-block">
				
				<aside class="category-page_left-block">

					<nav class="sub-category-links-block">
						
						<ul>
							
							@foreach($sub_cats as $cat)

								<li>
									<a href="{{ asset('category/'.$cat->id_1c.'/'.$cat->slug) }}">
										{{ $cat->name }}
									</a>
								</li>

							@endforeach

						</ul>
					</nav>
					
				</aside>

				<div class="category-page_right-block">

					<div class="category-page_category-links-block">

						@foreach($sub_cats as $cat)

							<a href="{{ asset('category/'.$cat->id_1c.'/'.$cat->slug) }}" class="category-page_category-link-element">
								<div class="image">

									@if($cat->image)

										<img src="https://alfastok.by/storage/{{ $cat->image }}">

									@else

										<img src="{{ asset('/img/no_image.jpg') }}">

									@endif

								</div>

								<div class="name">
									{{ $cat->name }}
								</div>
							</a>
						
						@endforeach

					</div>

					<div class="category-page_text-block text">

						{!! $current_cat->text !!}
						
					</div>
					
				</div>

			</div>

		</section>

		@if($popular_items->count())

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

		@endif


	</div>
</div>

@endsection


@section('scripts')

<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui-touch.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main_page_block_lister.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/image_links_handler.js') }}"></script>

@parent


@endsection