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

			<p style="margin-bottom: 5px">Уважаемый(ая) <strong>{{ $client_name }}</strong>!</p>

			<p style="margin-bottom: 5px">Спасибо, что воспользовались интернет-магазином 7150.by</p>

			<p style="margin-bottom: 5px;">№ заказа: <strong>{{ $order_id }}</strong></p>

			<p style="margin-bottom: 5px;">Товар: <strong>{{ $item_name }}</strong></p>

			<p style="margin-bottom: 5px;">На имя: <strong>{{ $client_name }}</strong></p>

			<p style="margin-bottom: 5px;">Телефон: <strong>{{ $client_phone }}</strong></p>

			@if($client_email)
			
				<p style="margin-bottom: 5px;">Email: <strong>{{ $client_email }}</strong></p>

			@endif

			@if($comment)

				<p style="margin-bottom: 5px;">Комментарий:<br><pre>{{ $comment }}</pre></p>

			@endif

			<p style="margin-bottom: 5px">
				Наш специалист свяжется с Вами для уточнения деталей.
			</p>

		</div>

	</div>
</div>
	
</body>
</html>