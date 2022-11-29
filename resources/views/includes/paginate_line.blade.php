@if ($paginator->hasPages())

	<div class="paginate-links-block">

		<ul class="pagination">

	        @if($paginator->onFirstPage())
		            
				<li>
					<div class="arrow-block left">
						@include('svg.arrow')
					</div>
				</li>

	        @else
		            
				<li>
					<a href="{{ $paginator->previousPageUrl().$search_string_param.$sort_first_param.$paginate_second_param }}" rel="prev">
						<div class="arrow-block left active" title="Предыдущая страница">
							@include('svg.arrow')
						</div>
					</a>
				</li>

	        @endif

            @foreach($elements[0] as $page => $url)

                @if($page == $paginator->currentPage())

					<li>
						<div class="page-number active" title="Страница {{ $page }}">
							{{ $page }}
						</div>
					</li>

                @else

					<li>
						<a href="{{ $url.$search_string_param.$sort_first_param.$paginate_second_param }}">
							<div class="page-number" title="Страница {{ $page }}">
								{{ $page }}
							</div>
						</a>
					</li>

                @endif

            @endforeach


	        @if($paginator->hasMorePages())

				<li>
					<a href="{{ $paginator->nextPageUrl().$search_string_param.$sort_first_param.$paginate_second_param }}" rel="next">
						<div class="arrow-block right active" title="Следующая страница">
							@include('svg.arrow')
						</div>
					</a>
				</li>

	        @else
		            
				<li>
					<div class="arrow-block right">
						@include('svg.arrow')
					</div>
				</li>

	        @endif

	    </ul>

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

	    		<a
	    			href="{{ $paginator->url(1).$search_string_param.$paginate_second_param }}"
	    			class="{{ $p_20 }} js-paginate-link"
	    		>
	    			20
	    		</a>
	    		<a
	    			href="{{ $paginator->url(1).$search_string_param }}&items=40{{ $paginate_second_param }}"
	    			class="{{ $p_40 }} js-paginate-link"
	    		>
	    			40
	    		</a>
	    		<a
	    			href="{{ $paginator->url(1).$search_string_param }}&items=60{{ $paginate_second_param }}"
	    			class="{{ $p_60 }} js-paginate-link"
	    		>
	    			60
	    		</a>

	    	</div>

	    </div>

	</div>

@endif
