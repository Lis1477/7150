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
			<img src="{{ asset('img/logo7150.png') }}" alt="logo 7150.by">
		</div>

		<div style="font-size: 18px; text-align: left;">

			<p style="margin-bottom: 10px">Уважаемый(ая) <strong>{{ $name }}!</strong></p>

			<p style="margin-bottom: 10px">Спасибо за регистрацию на сайте <a href="{{ asset('/') }}" target="_blank">7150.by</a>!</p>
			
			<p style="margin-bottom: 10px">Ваш пароль: <strong>{{ $password }}</strong></p>

			<p style="margin-bottom: 10px">Для активации аккаунта Вам необходимо в течение 7 дней авторизоваться на сайте <a href="{{ asset('/') }}" target="_blank">7150.by</a>.</p>

			<p>Если Вы не авторизируетесь в течение указанного срока, аккаунт будет автоматически аннулирован.</p>

		</div>

		<div style="font-size: 12px; text-align: left;">
			<p>Если регистрация произведена не Вами, или это письмо пришло к Вам по ошибке, просто удалите письмо. Аккаунт будет аннулирован автоматически.</p>
		</div>

	</div>
</div>
	
</body>
</html>