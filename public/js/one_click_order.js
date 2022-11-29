$(document).ready(function(){

	console.log('Заказ в 1 клик');

	$('.js-one-click-butt').click(function(e) {

		// запрещаем действие по умолчанию
		e.preventDefault();

		// открываем окно с формой
		$('.js-one-click-order').fadeIn();

		// узнаем имя и id_1c товара
		var item_name = $(this).data('name');
		var item_id_1c = $(this).data('id_1c');

		// вставляем имя товара в заголовок и в input
		$('.js-item-name').text(item_name);
		$('input[name=item_name]').val(item_name);

		// вставляем id_1c товара в input
		$('input[name=item_id_1c]').val(item_id_1c);

	});

	// закрываем окно с формой
	$('.js-popup-close-button, .js-popup-background').click(function(){
		$('.js-one-click-order').fadeOut();
	});

});