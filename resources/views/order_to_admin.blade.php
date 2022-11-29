<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Письмо</title>
</head>
<body>


<div style="width: 100%;">
	<div style="width: 600px; border: solid 1px #c6c6c6; padding: 15px; margin: 0 auto; box-sizing: border-box; text-align: center;">

		<div style="display: inline-block;">
			<img src="{{ asset('img/logo2626.png') }}" alt="logo 2626.by">
		</div>

		<div style="font-size: 18px; text-align: left;">

			<p style="margin-bottom: 10px; font-size: 1.2em; font-weight: bold;">Заказ на сайте 2626.by</p>

			<table>
				<tr>
					<th style="border: solid 1px #c6c6c6; padding: 5px;">
						Наименование
					</th>
					<th style="border: solid 1px #c6c6c6; padding: 5px;">
						Количество
					</th>
					<th style="border: solid 1px #c6c6c6; padding: 5px;">
						Цена, руб
					</th>
					<th style="border: solid 1px #c6c6c6; padding: 5px;">
						Экономия, руб
					</th>
					<th style="border: solid 1px #c6c6c6; padding: 5px;">
						Стоимость, руб
					</th>
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

			{{-- <p>Стоимость доставки: {{  }} руб</p> --}}


			





		</div>

		<div style="font-size: 12px; text-align: left;">
			<p>Если регистрация произведена не Вами, или это письмо пришло к Вам по ошибке, просто удалите письмо. Аккаунт будет аннулирован автоматически.</p>
		</div>

	</div>
</div>
	
</body>
</html>