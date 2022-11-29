@extends('layouts.base')

@section('content')

<div class="history-page">
	<div class="container">

		@include('cabinet.includes.cabinet_menu')

		<div class="history-page_orders-wrapper">

			<h1>Ваши заказы</h1>

			<div class="history-page_order-block">

				@if($orders->count())

					@foreach($orders as $order)

						<div class="history-page_order-header-line js-order-block">
							<div class="order-number js-items-block-button" title="Развернуть">
								Заказ №{{ $order->id }}
							</div>
							<div class="order-date">
								Создан {{ date('d.m.Y', strtotime($order->created_at)) }}
							</div>
							<div class="order-price">
								товаров <span class="color">{{ $order->items->count() }}</span>,
								на сумму <span class="color">{{ number_format($order->price_total, 2, '.', '') }}</span> руб.
							</div>
							<div class="arrow-block js-items-block-button">
								<div class="svg js-svg" title="Развернуть">
									@include('svg.arrow')
								</div>
							</div>
						</div>

						<div class="history-page_items-block-wrapper js-items-block">

							<div class="history-page_items-block">

								<div class="items-header">
									<div class="code">
										Код
									</div>
									<div class="name">
										Наименование
									</div>
									<div class="item-price">
										Цена
									</div>
									<div class="item-count">
										Кол-во
									</div>
									<div class="item-line-price">
										Стоимость
									</div>
								</div>
								
								@foreach($order->items as $item)

									<div class="item-lines">
										<div class="code">
											{{ $item->item_id_1c }}
										</div>
										<div class="name">
											<a href="{{ asset('tovar/'.$item->item_id_1c.'/'.str_slug($item->name, '-')) }}" target="_blank">
												{{ $item->name }}
											</a>
										</div>
										<div class="item-price">
											{{ number_format($item->price, 2, '.', '') }}
										</div>
										<div class="item-count">
											{{ $item->count }}
										</div>
										<div class="item-line-price">
											{{ number_format($item->price * $item->count, 2, '.', '') }}
										</div>
									</div>

								@endforeach

							</div>

							<div class="history-page_total-info-block">

								@if(doubleval($order->price_economy))

									<div class="economy">
										Экономия — {{ number_format($order->price_economy, 2, '.', '') }} руб.
									</div>

								@endif

								<div class="delivery">
									Доставка @if($order->shipping){{ '('.$order->shipping.')' }}@endif
									—
									@if(doubleval($order->price_delivery)){{ number_format($order->price_delivery, 2, '.', '') }}@else{{ '0' }}@endif руб.
								</div>

								<div class="total-price">
									Общая стоимость — {{ number_format($order->price_total + $order->price_delivery, 2, '.', '') }} руб.
								</div>

								@if($order->delivery_type != 'самовывоз')

									<div class="delivery-address">
										@if($order->shipping != 'Европочтой до Пункта Выдачи')

											Адрес доставки — г.{{ $order->city }},
											ул. {{ $order->street }},
											д. {{ $order->house }},
											@if($order->corpus){{ 'кор. '.$order->corpus.',' }}@endif
											@if($order->flat){{ 'кв. '.$order->flat.',' }}@endif
											@if($order->entrance){{ 'под. '.$order->entrance.',' }}@endif
											@if($order->floor){{ 'эт. '.$order->floor.',' }}@endif

										@else

											Пункт выдачи — {{ $order->euro_pv }}.

										@endif

									</div>

								@endif

							</div>
							
						</div>

					@endforeach

				@else

					<div class="history-page_no-history">
						У Вас пока нет истории!
					</div>

				@endif
				
			</div>
		</div>


	</div>
</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('js/cabinet.js') }}"></script>

@endsection