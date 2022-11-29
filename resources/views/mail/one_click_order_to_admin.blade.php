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

		<p style="margin-bottom: 5px; font-size: 1.4em; font-weight: bold;">
			Заказ в 1 клик на сайте 7150.by
		</p>

		<p style="margin-bottom: 5px;">№ заказа: <strong>{{ $order_id }}</strong></p>

		<p style="margin-bottom: 5px;">Товар: <strong>{{ $item_id_1c }} - {{ $item_name }}</strong></p>

		<p style="margin-bottom: 5px;">Имя заказчика: <strong>{{ $client_name }}</strong></p>

		<p style="margin-bottom: 5px;">Телефон: <strong>{{ $client_phone }}</strong></p>

		@if($client_email)
		
			<p style="margin-bottom: 5px;">Email: <strong>{{ $client_email }}</strong></p>

		@endif

		@if($comment)

			<p style="margin-bottom: 5px;">Комментарий:<br><pre>{{ $comment }}</pre></p>

		@endif

	</div>

</div>
	
</body>
</html>