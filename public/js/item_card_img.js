$(document).ready(function(){

	console.log('картинки в карточке товара');

	// zoom при наведении на картинку
	zoom_img();

	// определяем количество изображений
	var img_count = $('.js-big-images').data('img-count');

	// обработка по нажатию на маленькие изображения
	$('.js-img').click(function(){
		// удаляем класс у всех
		$('.js-img').removeClass('active');
		// добавляем класс у требуемой
		$(this).addClass('active');

		// определяем номер изображения
		var img_num = $(this).data('img-num');
		// скрываем все большие изображения
		$('.js-big-pic').fadeOut('600').removeClass('active');
		// отображаем по номеру
		$('[data-big-img-nun='+img_num+']').fadeIn('600').addClass('active');

		// zoom при наведении на картинку
		zoom_img();

	});

	// обработка нажатия правой стрелки
	$('.js-right').click(function(){
		// определяем номер текущего изображения
		var big_img_num = $('.js-big-pic.active').data('big-img-nun');
		// если равно количеству изображений, переопределяем
		if(big_img_num == img_count) big_img_num = 0;

		// скрываем все большие изображения
		$('.js-big-pic').fadeOut('600').removeClass('active');
		// отображаем по следующему номеру
		$('[data-big-img-nun='+(big_img_num+1)+']').fadeIn('600').addClass('active');

		// удаляем класс у всех маленьких изображений
		$('.js-img').removeClass('active');
		// добавляем класс у требуемой
		$('[data-img-num='+(big_img_num+1)+']').addClass('active');

		// zoom при наведении на картинку
		zoom_img();
	});

	// обработка нажатия левой стрелки
	$('.js-left').click(function(){
		// определяем номер текущего изображения
		var big_img_num = $('.js-big-pic.active').data('big-img-nun');
		// если равно количеству изображений, переопределяем
		if(big_img_num == 1) big_img_num = img_count+1;

		// скрываем все большие изображения
		$('.js-big-pic').fadeOut('600').removeClass('active');
		// отображаем по следующему номеру
		$('[data-big-img-nun='+(big_img_num-1)+']').fadeIn('600').addClass('active');

		// удаляем класс у всех маленьких изображений
		$('.js-img').removeClass('active');
		// добавляем класс у требуемой
		$('[data-img-num='+(big_img_num-1)+']').addClass('active');

		// zoom при наведении на картинку
		zoom_img();
	});

	// функция zoom при наведении на картинку

	function zoom_img(){
		if($(window).width()  > 1260) {
		    $('.js-big-pic.active img').blowup({
			    "width" : 400,
			    "height" : 400,
			    "border" : "3px solid #ff6600"
			});
		}
	}

});