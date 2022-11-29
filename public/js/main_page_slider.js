$(document).ready(function(){

	// метка
	console.log('обработчик слайдера на главной');

	// берем ширину слайдер-контейнера
	var slide_width = $('.main-page_promo-line_slider-container').outerWidth();

 	// переставляем последнее изображение вначало
	$('.main-page_promo-line_slider-block a:last').prependTo('.main-page_promo-line_slider-block');

	// перемещаем блок с изображениями влево на ширину контейнера
	$('.main-page_promo-line_slider-block').css('left', - slide_width);	

	// записываем содержимое блока с изображениями
	var image_block = $('.main-page_promo-line_slider-block');
	// делаем копию
	var image_block_clone = image_block.clone();

	// собираем все изображения
	var images = $('.main-page_promo-line_slider-block a');

	// даем изображению ширину контейнера
	images.css('width', slide_width);

	// вычисляем ширину контейнера в зависимости от ширины браузера
	// меняем ширину изображения
	$(window).resize(function(){
			slide_width = $('.main-page_promo-line_slider-container').outerWidth();
			images.css('width', slide_width);
	});

	// добавляем класс active к 1-й линии
	$('[data-line="1"]').addClass('active');


	var pic_count = $('.main-page_promo-line_slider-block').data('pic-count');
	var line = $('.main-page_slider-lines-block_line');
	var i = 2;
	// назначаем ширину линии
	var line_width = 90 / pic_count + '%';
	line.css('width', line_width);

	var interval_id = setInterval(change_img, 5000);

	function change_img() {
		// отработка смены изображений в слайдере
		$('.main-page_promo-line_slider-block').animate({left: -(slide_width*2)}, 1000, function(){
			$('.main-page_promo-line_slider-block > a:first').appendTo('.main-page_promo-line_slider-block');
		});
		$('.main-page_promo-line_slider-block').animate({left: -slide_width}, 0);

		// удаляем класс active у всех линий
		line.removeClass('active');
		// добавляем класс active к соответствующей линии
		$('[data-line=' + i + ']').addClass('active');

		i++;
		if (i > pic_count) {
			i = 1;
		}
	}

/*------------------------------------------------------------------*/
	// показ картинки по клику на линию
	line.on('click', function(){

		console.log('КЛИК');

		// останавливаем setinterval
		clearInterval(interval_id);

		// удаляем класс active у всех линий
		line.removeClass('active');

		// добавляем класс active к соответствующей линии
		$(this).addClass('active');

		//составляем массив порядка размещения изображений
		var arr = [];
		var num_line = $(this).data('line');
		for (var k = 0; k < pic_count; k++) {
			arr[k] = num_line;
			num_line++;
			if (num_line > pic_count) {
				num_line = 1;
			}
		}

		// удаляем все изображения
		images.remove();

		// расставляем изображения в соответстви с порядком в arr
		$.each(arr, function(s, num_line){
			image_block_clone.find('a[data-pic="' + num_line + '"]').appendTo(image_block);
		});

	 	// переставляем последнее изображение вначало
		$('.main-page_promo-line_slider-block a:last').prependTo('.main-page_promo-line_slider-block');

		// перемещаем блок с изображениями влево на ширину контейнера
		$('.main-page_promo-line_slider-block').css('left', - slide_width);	

		// записываем содержимое блока с изображениями
		image_block = $('.main-page_promo-line_slider-block');
		// делаем копию
		image_block_clone = image_block.clone();
		// собираем все изображения
		images = $('.main-page_promo-line_slider-block a');

		// берем ширину слайдер-контейнера
		var slide_width = $('.main-page_promo-line_slider-container').outerWidth();

		// даем изображению ширину контейнера
		images.css('width', slide_width);

		// вычисляем ширину контейнера в зависимости от ширины браузера
		// меняем ширину изображения
		$(window).resize(function(){
				slide_width = $('.main-page_promo-line_slider-container').outerWidth();
				images.css('width', slide_width);
		});

		// запускаем setinterval
		i = num_line + 1;
		if (i > pic_count) {
			i = 1;
		}
		interval_id = setInterval(change_img, 5000);
	});


/*------------------------------------------------------------------*/
	// перетаскивание мышью
	$('.main-page_promo-line_slider-block').draggable({
		axis:'x',
		start:function(e, ui){
			// останавливаем setinterval
			clearInterval(interval_id);

			// фиксируем начальную позицию
            this.previousPosition = ui.position;

        },
        revert: function(e, ui) {


        },
        stop: function(e, ui) {

        	// узнаем номер текущего изображения
        	var k = $('.js-img-link').eq(2).data('pic');
        	// узнаем индекс текущей линии
        	var line_index = k - 2;

			// удаляем класс active у всех линий
			line.removeClass('active');

	        if(this.previousPosition.left > ui.position.left) { // если двинули влево


console.log('влево!')

				// определяем индекс следующей линии
				var line_next = line_index + 1;

				if(line_next == pic_count) line_next = 0;

				// добавляем класс active к следующей линии
				$(line).eq(line_next).addClass('active');

				// отработка смены изображений в слайдере
				$('.main-page_promo-line_slider-block').animate({left: -(slide_width*2)}, 500, function(){
					$('.main-page_promo-line_slider-block > a:first').appendTo('.main-page_promo-line_slider-block');
				});
				$('.main-page_promo-line_slider-block').animate({left: -slide_width}, 0);

				// запускаем setinterval
				i = k + 1;
				if (i > pic_count) {
					i = 1;
				}
				interval_id = setInterval(change_img, 5000);

	        } else { // если двинули вправо

console.log('вправо!');

				// определяем индекс предыдущей линии
				var line_prev = line_index - 1;
				if(line_prev == -1) line_prev = pic_count - 1;
				// добавляем класс active к предыдущей линии
				$(line).eq(line_prev).addClass('active');


				// отработка смены изображений в слайдере
				$('.main-page_promo-line_slider-block').animate({left: 0}, 500, function(){
					$('.main-page_promo-line_slider-block > a:last').prependTo('.main-page_promo-line_slider-block');
				});
				$('.main-page_promo-line_slider-block').animate({left: -slide_width}, 0);

				// запускаем setinterval
				i = k-1;
				if (i == 0) {
					i = pic_count;
				}
				interval_id = setInterval(change_img, 5000);

	        }

		},
	});



});