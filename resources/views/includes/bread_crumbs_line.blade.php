<div class="bread-crumbs-block">

	<a href="/" class="current-category-name">Главная</a>

	<div>
		@include('svg.arrow')
	</div>

	@if($bread_crumbs[0]['id_1c'] != 193)

		@foreach($bread_crumbs as $bread)

			@if($bread_crumbs->count() == $loop->iteration && $bread_crumbs_type != "tovar")

				<div class="current-category-name-wrapper">

					<div class="current-category-name no-link">

						{{ $bread['all_cats']->where('id_1c', $bread['id_1c'])->first()->name }}

					</div>

					@if($bread['all_cats']->where('id_1c', '!=', $bread['id_1c'])->count())

						<nav class="category-links-block">
							<ul>

								@foreach($bread['all_cats']->where('id_1c', '!=', $bread['id_1c']) as $cat)

									@if($cat->id_1c == 193)
										@continue
									@endif

									<li>
										<a href="{{ asset(asset('category/'.$cat->id_1c.'/'.$cat->slug)) }}">
											{{ $cat->name }}
										</a>
									</li>

								@endforeach
								
							</ul>
						</nav>

					@endif
					
				</div>

			@else

				<div class="current-category-name-wrapper">

					<a
						href="{{ asset('category/'.$bread['id_1c'].'/'.$bread['all_cats']->where('id_1c', $bread['id_1c'])->first()->slug) }}"
						class="current-category-name"
					>

						{{ $bread['all_cats']->where('id_1c', $bread['id_1c'])->first()->name }}

					</a>

					@if($bread['all_cats']->where('id_1c', '!=', $bread['id_1c'])->count())

						<nav class="category-links-block">
							<ul>

								@foreach($bread['all_cats']->where('id_1c', '!=', $bread['id_1c']) as $cat)

									@if($cat->id_1c == 193)
										@continue
									@endif

									<li>
										<a href="{{ asset(asset('category/'.$cat->id_1c.'/'.$cat->slug)) }}">
											{{ $cat->name }}
										</a>
									</li>

								@endforeach
								
							</ul>
						</nav>

					@endif

				</div>

				<div>
					@include('svg.arrow')
				</div>

			@endif

		@endforeach

	@else

				<div class="current-category-name-wrapper">

					<a
						href="{{ asset('utsenionniye-tovary') }}"
						class="current-category-name"
					>
						Уцененные товары
					</a>

				</div>

				<div>
					@include('svg.arrow')
				</div>

	@endif

	@if($bread_crumbs_type == "tovar")

		<div class="current-category-name no-link">

			{{ $item->name }}

		</div>

	@endif

</div>