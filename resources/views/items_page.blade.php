@extends('layouts.base')

@section('content')

@php
	// для блоков Показывать по и Сортировки
	if($paginate_num == 60) {
		$p_60 = 'active';
		$p_40 = '';
		$p_20 = '';
		$sort_first_param = "?items=".$paginate_num;
		$sort_delimiter = "&";
		$sort_first_param_pl = "&items=".$paginate_num;
	} elseif($paginate_num == 40) {
		$p_60 = '';
		$p_40 = 'active';
		$p_20 = '';

		$sort_first_param = "?items=".$paginate_num;
		$sort_delimiter = "&";
		$sort_first_param_pl = "&items=".$paginate_num;
	} else {
		$p_60 = '';
		$p_40 = '';
		$p_20 = 'active';

		$sort_first_param = URL::current();
		$sort_delimiter = "?";
		$sort_first_param_pl = "";
	}

	if($sort_parameter == "popular") {
		$paginate_second_param = "";
		$paginate_first_delimiter = "";
		$paginate_delimiter = "";
	} else {
		$paginate_second_param = "sort=".$sort_parameter;
		$paginate_first_delimiter = "?";
		$paginate_delimiter = "&";
	}

	$popular_active = $new_items_active = $low_price_active = $high_price_active = $actions_active = $comments_active ="";

	if($sort_parameter == "new_items") {
		$sort_str = "новинки";
		$new_items_active = "active";
	} elseif($sort_parameter == "low_price") {
		$sort_str = "дешевые";
		$low_price_active = "active";
	} elseif($sort_parameter == "high_price") {
		$sort_str = "дорогие";
		$high_price_active = "active";
	} elseif($sort_parameter == "actions") {
		$sort_str = "акции и скидки";
		$actions_active = "active";
	} elseif($sort_parameter == "comments") {
		$sort_str = "с отзывами";
		$comments_active = "active";
	} else {
		$sort_str = "популярные";
		$popular_active = "active";
	}

@endphp

<div class="items-page">
	<div class="container">

		@include('includes.bread_crumbs_line')

		<section class="items-page_wrapper">
			
			<h1 class="items-page_name">
				{{ $current_cat->name }}
			</h1>

			<div class="items-page_info-block">

				<aside class="items-page_left-block">

					<div class="items-page_bread-crumbs-wrapper">

						@foreach($bread_crumbs as $bread)

							<div class="items-page_bread-crumbs-block">

								@if(($bread_crumbs->count() != $loop->iteration))

									<div class="svg-block">
										@include('svg.arrow')
									</div>

									<a href="{{ asset('category/'.$bread['id_1c'].'/'.$bread['all_cats']->where('id_1c', $bread['id_1c'])->first()->slug) }}">

										{{ $bread['all_cats']->where('id_1c', $bread['id_1c'])->first()->name }}

									</a>

								@endif
								
							</div>

						@endforeach
						
					</div>

					@if($max_price > $min_price)

						<div class="item-page_filters-wrapper">
							@include('includes.item_filters')
						</div>

					@endif

				</aside>

				<div class="items-page_items-wrapper">

					<div class="items-page_sort-line-block">
						
						<div class="sort-block">
							<div class="title">
								Сначала
							</div>
							<div class="title-block">
								<div class="title js-sort-but">
									<div>{{ $sort_str }}</div>
									<div class="sort-arrow">
										@include('svg.arrow')
									</div>
								</div>
								<div class="sort-links js-sort-block" style="display: none;" data-sort="{{ $sort_str }}">
									<a href="{{ $sort_first_param }}" class="{{ $popular_active }} js-sort-link">популярные</a>
									<a href="{{ $sort_first_param.$sort_delimiter }}sort=new_items" class="{{ $new_items_active }} js-sort-link">новинки</a>
									<a href="{{ $sort_first_param.$sort_delimiter }}sort=low_price" class="{{ $low_price_active }} js-sort-link">дешевые</a>
									<a href="{{ $sort_first_param.$sort_delimiter }}sort=high_price" class="{{ $high_price_active }} js-sort-link">дорогие</a>

{{-- 									<a href="{{ $sort_first_param.$sort_delimiter }}sort=actions" class="{{ $actions_active }} js-sort-link">акции и скидки</a>
									<a href="{{ $sort_first_param.$sort_delimiter }}sort=comments" class="{{ $comments_active }} js-sort-link">с отзывами</a> --}}

								</div>
							</div>
						</div>

						@if($items->total() > 20)

						    <div class="paginate-counts-block">

						    	<div class="title">
						    		Показывать по:
						    	</div>

						    	<div class="paginate-count-link js-select-but">
							    	<div class="paginate-count">
							    		{{ $paginate_num }}
							    	</div>
							    	<div class="link-arrow-block">
							    		@include('svg.arrow')
							    	</div>
						    	</div>


						    	<div class="select-block js-select-block" style="display: none;" data-paginate="{{ $paginate_num }}">
						    		<a href="{{ URL::current().$paginate_first_delimiter.$paginate_second_param }}" class="{{ $p_20 }} js-paginate-link">20</a>
						    		<a href="?items=40{{ $paginate_delimiter.$paginate_second_param }}" class="{{ $p_40 }} js-paginate-link">40</a>
						    		<a href="?items=60{{ $paginate_delimiter.$paginate_second_param }}" class="{{ $p_60 }} js-paginate-link">60</a>
						    	</div>

						    </div>

						@endif

					</div>

					@if($items->count())

						<div class="items-page_items-block">

							@foreach($items as $item)

								@include('includes.item_block')

							@endforeach
							
						</div>

						{{ $items->links('includes.paginate_line', with([
								'paginate_num' => $paginate_num,
								'p_20' => $p_20,
								'p_40' => $p_40,
								'p_60' => $p_60,
								'paginate_second_param' => '&'.$paginate_second_param,
								'sort_first_param' => $sort_first_param_pl,
								'search_string_param' => '',
							])) }}

					@endif
					
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