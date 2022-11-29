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
			Запрос Хочу дешевле на сайте 7150.by
		</p>

		<p style="margin-bottom: 5px;">Товар: <strong>{{ $item_name }}</strong></p>

		<p style="margin-bottom: 5px;">Имя: <strong>{{ $client_name }}</strong></p>

		<p style="margin-bottom: 5px;">Телефон: <strong>{{ $client_phone }}</strong></p>

		<p style="margin-bottom: 5px;">Время звонка: с <strong>{{ $first_time }}</strong> до <strong>{{ $second_time }}</p>

		@if($comment)

			<p style="margin-bottom: 5px;">Комментарий:<br><pre>{{ $comment }}</pre></p>

		@endif

	</div>

</div>
	
</body>
</html>