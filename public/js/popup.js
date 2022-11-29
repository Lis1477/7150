$(document).ready(function(){

	console.log('Закрываем всплывающее окно сообщения');

	// закрываем popup
	$('.js-popup-note-background, .js-popup-close-button').click(function() {

		//скрываем формы, закрываем окно
		$('.js-popup-note').fadeOut();

	});

});