<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Письмо</title>
</head>
<body>


<div style="width: 100%;">

	<div style="font-size: 16px; text-align: left;">

		<p style="margin-bottom: 5px; font-size: 1.4em; font-weight: bold;">Заказ на сайте 7150.by</p>

		<table style="margin-bottom: 5px; border-spacing: 0;">
			<tr>
				<td style="border: solid 1px #c6c6c6; padding: 5px;">
					Наименование
				</td>
				<td style="border: solid 1px #c6c6c6; padding: 5px;">
					Количество
				</td>
				<td style="border: solid 1px #c6c6c6; padding: 5px;">
					Цена, руб
				</td>
				<td style="border: solid 1px #c6c6c6; padding: 5px;">
					Экономия, руб
				</td>
				<td style="border: solid 1px #c6c6c6; padding: 5px;">
					Стоимость, руб
				</td>
			</tr>

			@foreach($items as $item)

				<tr>
					<td style="border: solid 1px #c6c6c6; padding: 5px;">
						{{ $item['name'] }}
					</td>
					<td style="border: solid 1px #c6c6c6; padding: 5px;">
						{{ $item['count'] }}
					</td>
					<td style="border: solid 1px #c6c6c6; padding: 5px;">
						{{ number_format($item['price'], 2, '.', '') }}
					</td>
					<td style="border: solid 1px #c6c6c6; padding: 5px;">
						{{ number_format($item['economy'], 2, '.', '') }}
					</td>
					<td style="border: solid 1px #c6c6c6; padding: 5px;">
						{{ number_format(($item['price'] - $item['economy']) * $item['count'], 2, '.', '') }}
					</td>
				</tr>

			@endforeach

		</table>

		<p style="margin-bottom: 5px;">Итого по товару: {{ $total_price }} руб</p>

		@if(floatval($total_economy))

			<p style="margin-bottom: 5px;">Экономия: {{ $total_economy }} руб</p>

		@endif

		@if(floatval($delivery_price))

			<p style="margin-bottom: 5px;">Стоимость доставки: {{ $delivery_price }} руб</p>
			<p style="margin-bottom: 5px;">Всего: {{ $total_price + $delivery_price }} руб</p>

		@endif

		@if(floatval($total_weight))

			<p style="margin-bottom: 5px;">Общий вес: {{ $total_weight }} кг</p>

		@endif

		<p style="margin-bottom: 5px; font-size: 1.2em; font-weight: bold;">Данные покупателя:</p>

		<p style="margin-bottom: 5px;">Тип клиента: {{ $client_type }}</p>

		<p style="margin-bottom: 5px;">Имя заказчика: {{ $client_name }}</p>

		<p style="margin-bottom: 5px;">Телефон: {{ $phone }}</p>
		
		<p style="margin-bottom: 5px;">Email: {{ $email }}</p>

		@if($client_type == 'юридическое лицо')

			<p style="margin-bottom: 5px;">Наименование организации: {{ $company_name }}</p>

			<p style="margin-bottom: 5px;">УНП: {{ $company_unp }}</p>

			<p style="margin-bottom: 5px;">Реквизиты:<br><pre>{{ $company_requisites }}</pre></p>

		@endif

		<p style="margin-bottom: 5px; font-size: 1.2em; font-weight: bold;">Доставка:</p>

		<p style="margin-bottom: 5px;">Тип доставки: {{ $delivery_type }}</p>

		@if($delivery_type == 'доставка')

			<p style="margin-bottom: 5px;">Вариант доставки: {{ $shipping }}</p>

			@if($shipping == 'Европочтой до Пункта Выдачи' || $shipping == 'Европочтой до двери')

				<p style="margin-bottom: 5px;">Получатель: {{ $family_name." ".$first_name." ".$second_name }}</p>

			@endif

			@if($shipping != 'Европочтой до Пункта Выдачи')

				<p style="margin-bottom: 5px;">
					Адрес доставки:
					{{ "г. ".$city.", ул. ".$street.", дом ".$house }}

					@if($corpus)

						{{ ", корп. ".$corpus }}

					@endif
					@if($flat)

						{{ ", кв./офис ".$flat }}

					@endif
					@if($entrance)

						{{ ", подъезд ".$entrance }}

					@endif
					@if($floor)

						{{ ", этаж ".$floor }}

					@endif.
				</p>

			@endif

			@if($shipping == 'Европочтой до Пункта Выдачи' && $euro_pv)

				<p style="margin-bottom: 5px;">Пункт выдачи Европочты: {{ $euro_pv }}</p>

			@endif

			@if($comment)

				<p style="margin-bottom: 5px;">Комментарий:<br><pre>{{ $comment }}</pre></p>

			@endif

		@endif

		<p style="margin-bottom: 5px; font-size: 1.2em; font-weight: bold;">Оплата:</p>

		<p style="margin-bottom: 5px;">Тип оплаты: {{ $paying_type }}</p>

		@if($paying_type != 'безналичная оплата по счету')

			<p style="margin-bottom: 5px;">Вариант оплаты: {{ $money_type }}</p>

		@endif

	</div>

</div>
	
</body>
</html>