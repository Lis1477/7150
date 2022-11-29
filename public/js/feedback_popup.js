$(document).ready(function(){

	console.log('обратная связь');

	// открываем popup
	$('.js-feedback-button').click(function() {

		$('.js-feedback').fadeIn();

	});

	// закрываем popup
	$('.js-feedback-background, .js-popup-close-button').click(function() {

		// удаляем класс active у ссылки
		$('.js-link').removeClass('active');

		//скрываем формы, закрываем окно
		$('.js-feedback').fadeOut();

		// прячем формы
		$('.js-form').slideUp();

		// пишем имя ссылки
		$('.js-feedback').find('h2').text('Обратная связь');

	});

	// показываем форму
	$('.js-call-back-link, .js-mail-to-us-link').click(function(){

		// удаляем класс active у ссылки
		$('.js-link').removeClass('active');

		// делаем текущую ссылку активной
		$(this).addClass('active');

		// берем имя ссылки и вписываем в заголовок
		$('.js-feedback').find('h2').text($(this).text());

		// прячем формы
		$('.js-form').slideUp();

		// открываем текущую
		if($(this).hasClass('js-call-back-link')) {
			$('.js-call-back-form').slideDown();
		}
		if($(this).hasClass('js-mail-to-us-link')) {
			$('.js-mail-to-us-form').slideDown();
		}
	});

	// хочу дешевле *********************
	// открываем popup
	$('.js-want-cheaper-link').click(function(e){
		// отменяем действие по умолчанию
		e.preventDefault();

		// открываем 
		$('.js-want-cheaper').fadeIn();

		// узнаем имя товара
		var item_name = $(this).data('name');
		// вставляем в инпут
		$('input[name=item_name]').val(item_name);
	});

	// закрываем popup
	$('.js-want-cheaper-background, .js-popup-close-button').click(function() {
		$('.js-want-cheaper').fadeOut();
	});



});