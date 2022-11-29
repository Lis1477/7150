<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Письмо</title>
</head>
<body>


<div style="width: 100%;">
	<div style="width: 800px; border: solid 1px #c6c6c6; padding: 15px; margin: 0 auto; box-sizing: border-box; text-align: center;">

		<div style="display: inline-block;">
			<img src="{{ asset('img/logo7150.png') }}" alt="logo 7150.by">
		</div>

		<div style="font-size: 16px; text-align: left;">

			<p style="margin-bottom: 5px">Уважаемый(ая) {{ $client_name }}!</p>

			<p style="margin-bottom: 5px">Спасибо, что воспользовались интернет-магазином 7150.by</p>

			<p style="margin-bottom: 5px; font-size: 1.4em; font-weight: bold;">Ваш заказ:</p>

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

			<p style="margin-bottom: 5px;">Тип оплаты: {{ $paying_type }}</p>

			@if($paying_type != 'безналичная оплата по счету')

				<p style="margin-bottom: 5px;">Вариант оплаты: {{ $money_type }}</p>

			@endif

		</div>

		@if($new_user)

			<div style="font-size: 14px; text-align: left; margin-top: 20px;">

				<p style="margin-bottom: 5px">Для Вашего удобства мы создали для Вас кабинет пользователя, где Вы сможете воспользоваться всеми преимуществами нашего интернет-магазина.</p>

				<p style="margin-bottom: 5px">Email для входа: {{ $email }}</p>
				
				<p style="margin-bottom: 5px">Пароль: {{ $password }}</p>

				<p style="margin-bottom: 5px">Для активации аккаунта Вам необходимо в течение 7 дней авторизоваться на сайте <a href="{{ asset('/') }}" target="_blank">7150.by</a>.</p>

				<p>Если Вы не авторизируетесь в течение указанного срока, аккаунт будет автоматически аннулирован.</p>

			</div>

		@endif




	</div>
</div>
	
</body>
</html>