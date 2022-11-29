{{-- <div class="item-filters-block">

	<h2>Фильтры:</h2>

	<div class="price-range-block">

		<h3>Цена, руб.:</h3>

		<div class="min-max-block js-min-max" data-min-price="{{ $min_price }}" data-max-price="{{ $max_price }}">

			<div class="from-block">
				<div class="title">от</div>
				<input type="text" name="price_from">
			</div>

			<div class="to-block" id="amount">
				<div class="title">до</div>
				<input type="text" name="price_to">
			</div>

		</div>

		<div class="slider-range-block">

			<div id="slider-range"></div>

		</div>

	</div>

	@if(Route::currentRouteName() == 'get-search' || Route::currentRouteName() == 'new-items')

		@if(count($cats) >1)

			<div class="category-block">

				<h3>Категория:</h3>

				@foreach($cats as $cat)

					@php
						if($cat->id_1c == 3149) {
							$cat_name = "Уцененные товары";
						} else {
							$cat_name = $cat->name;
						}
					@endphp

					<div class="input-element">

						<label>
							<input type="checkbox" name="" value="">
							<span>{{ $cat_name }}</span>
						</label>

					</div>

				@endforeach

			</div>

		@endif

	@else

		@if(count($chars))

			<div class="characteristic-wrapper">

				@foreach($chars as $name => $char)

					@if(count($char) > 1)

						@php
							// считаем количество элементов в столбце
							// всего элементов
							$cnt = count($char);
							// если есть остаток деления на 2
							if($cnt/2 - floor($cnt/2)) {
								$el_count = floor($cnt/2) + 1;
							} else {
								$el_count = $cnt/2;
							}
						@endphp

						<div class="characteristic-block">
							
							<h3 class="name">{{ $name }}:</h3>

							<div class="input-block">

								<div class="input-element first">

									@foreach($char as $val)

										<label>
											<input type="checkbox" name="" value="">
											<span>{{ $val }}</span>
										</label>

										@if($loop->iteration == $el_count)
											@break
										@endif

									@endforeach
									
								</div>

								<div class="input-element second">

									@foreach($char as $val)

										@if($loop->iteration <= $el_count)
											@continue
										@endif

										<label>
											<input type="checkbox" name="" value="">
											<span>{{ $val }}</span>
										</label>

									@endforeach
									
								</div>

							</div>

						</div>

					@endif

				@endforeach

			</div>

		@endif

	@endif

	<div class="button">
		<button>
			Показать товары
			<span>(45)</span>
		</button>
	</div>


</div> --}}