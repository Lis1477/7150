<div class="search-result-block">

	@if($categories->count())

		<div class="category-block">
			<div class="category-title">Категории товаров</div>

			@foreach($categories as $cat)

				@php
					$cat_name_str = $cat['name'];
					foreach($words_arr as $word) {
						$cat_name_str = str_replace($word, "<span style='color: #ff6600'>$word</span>", $cat_name_str);
					}
				@endphp

				<div class="category-name">
					<a href="{{ asset('category/'.$cat['id_1c'].'/'.$cat['slug']) }}">{!! $cat_name_str !!}</a>
				</div>

			@endforeach

		</div>

	@endif

	@if($items->count())

		<div class="items-block">
			<div class="items-title">Товары</div>

				@foreach($items as $item)

					@php
						$item_name_str_2 = $item->name;
						foreach($words_arr as $word) {
							$item_name_str_2 = str_replace($word, "<span style='color: #ff6600'>$word</span>", $item_name_str_2);
						}
					@endphp

					<div class="item-name">
						<a href="{{ asset('tovar/'.$item->id_1c.'/'.$item->slug) }}">{!! $item_name_str_2 !!}</a>
					</div>

				@endforeach

		</div>

		<div class="result-line">
			<a href="{{ asset('search?search_string='.$search_string) }}">Показать все найденные товары ({{ $items_count }})</a>
		</div>

	@endif


</div>
