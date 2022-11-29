@extends('layouts.base')

@section('content')

<section class="error-page">
	<div class="container">

		<div class="image-block">
			<img src="{{ asset('img/404_1.jpg') }}" class="img-1">
			<div class="block-2">
				<img src="{{ asset('img/500.jpg') }}" class="img-2">
				<div class="text-block">
					<div class="sorry">Извините, эта страница по техническим причинам не доступна!</div>
					<div class="what-to-do">
						<p class="title">Что можно сделать:</p>
						<p>Перейти на <a href="/">Главную страницу</a> и повторить запрос.</p>
						<p>Сделать заказ по телефонам указанным в &laquo;шапке&raquo; сайта.</p>
						<form method="get" action="{{ asset('error-page-mail') }}">
							<input type="hidden" name="page" value="{{ \Request::fullUrl() }}">
							Если ошибка повторится
							<button type="submit" title="Жмите, чтобы отправить сообщение">Сообщить разработчику</button>
							о проблеме.
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>

@endsection
