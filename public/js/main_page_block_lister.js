$(document).ready(function(){

	console.log('переключатель отображения товарных блоков');

	var item_bl_width = $('.main-page_items-line.popular a').outerWidth(true); // ширина блока 1 товара с отступом
	var item_margin = item_bl_width - $('.main-page_items-line.popular a').outerWidth(); // правый отступ товарного блока
	var wrapper_bl_width = $('.main-page_popular-items').outerWidth(true); // ширина видимой части блока
	var bl_width = wrapper_bl_width + item_margin - 10; // величина ширины смещения блока

	// ДЛЯ БЛОКА ПОПУЛЯРНЫХ ТОВАРОВ *******************************************************************
	var popular_item_count = $('.main-page_items-line.popular').data('item-count'); // количество популярных товаров всего
	var popular_item_count_visible = (wrapper_bl_width + item_margin - 10) / item_bl_width; // количество популярных товаров видимых
	var screen_count_popular; // количество итераций
	if((popular_item_count / popular_item_count_visible).toString().split(".")[1]) {
		screen_count_popular = +(popular_item_count / popular_item_count_visible).toString().split(".")[0] + 1;
	} else {
		screen_count_popular = popular_item_count / popular_item_count_visible;
	}

	// если количество иттераций равно 1, скрываем правую кнопку
	if(screen_count_popular == 1) { 
		$('.main-page_right-lister.popular').css('visibility', 'hidden');
	}

	var pop_index = 1;
	var pop_shift = 0; // полное смещение блока

	$('.main-page_right-lister.popular').click(function(){
		console.log('двигаем влево');

		if (pop_index < screen_count_popular) {
			// отображаем левую кнопку
			$(this).siblings('.main-page_left-lister').animate({opacity: 1}, 1000);
			pop_index++;
			pop_shift = - (pop_index - 1) * bl_width;
			if (pop_index == screen_count_popular) {
				// прячем правую кнопку для крайнего правого блока
				$(this).animate({opacity: 0}, 1000);
			}
		}

		// перемещаем блок влево
		$(this).siblings('.main-page_items-line').animate({left: pop_shift}, 1000);

	});

	$('.main-page_left-lister.popular').click(function(){
		console.log('двигаем вправо');

		if (pop_index > 1) {
			// отображаем правую кнопку
			$(this).siblings('.main-page_right-lister').animate({opacity: 1}, 1000);
			pop_index--;
			pop_shift = - (pop_index - 1) * bl_width;
			if (pop_index == 1) {
				// прячем левую кнопку для крайнего левого блока
				$(this).animate({opacity: 0}, 1000);
			}
		}

		// перемещаем блок вправо
		$(this).siblings('.main-page_items-line').animate({left: pop_shift}, 1000);

	});

	// ПЕРЕТАСКИВАНИЕ МЫШЬЮ
	$('.main-page_items-line.popular').draggable({
		axis:'x',
		start:function(e, ui){

			// предотвращаем событие по клику
            ui.helper.bind("click.prevent", function(e){
            	e.preventDefault();
            });


			// фиксируем начальную позицию
            this.previousPosition = ui.position;

        },
        stop: function(e, ui) {

	        if(this.previousPosition.left > ui.position.left) { // если двинули влево

console.log('тянем влево!')

				if(pop_index < screen_count_popular) {

					// отображаем левую кнопку
					$(this).siblings('.main-page_left-lister').animate({opacity: 1}, 1000);

					pop_index++;
					pop_shift = - (pop_index - 1) * bl_width;
					$(this).animate({left: pop_shift}, 500)

					if (pop_index == screen_count_popular) {
						// прячем правую кнопку для крайнего правого блока
						$(this).siblings('.main-page_right-lister').animate({opacity: 0}, 1000);
					}

				} else {
					$(this).animate({left: pop_shift}, 500);
				}

	        } else { // если двинули вправо

console.log('тянем вправо!');

				if(pop_index > 1) {

					// отображаем правую кнопку
					$(this).siblings('.main-page_right-lister').animate({opacity: 1}, 1000);

					pop_index--;
					pop_shift = - (pop_index - 1) * bl_width;
					$(this).animate({left: pop_shift}, 500)

					if (pop_index == 1) {
						// прячем левую кнопку для крайнего левого блока
						$(this).siblings('.main-page_left-lister').animate({opacity: 0}, 1000);
					}

				} else {
					$(this).animate({left: pop_shift}, 500);
				}

	        }

	        // возвращаем возможность клика
			setTimeout(function(){
				ui.helper.unbind("click.prevent");
			}, 500);
		},
	});

	// ДЛЯ БЛОКА НОВЫХ ТОВАРОВ *******************************************************************
	var news_item_count = $('.main-page_items-line.news').data('item-count'); // количество товаров всего
	var news_item_count_visible = (wrapper_bl_width + item_margin - 10) / item_bl_width; // количество товаров видимых
	var screen_count_news; // количество итераций
	if((news_item_count / news_item_count_visible).toString().split(".")[1]) {
		screen_count_news = +(news_item_count / news_item_count_visible).toString().split(".")[0] + 1;
	} else {
		screen_count_news = news_item_count / news_item_count_visible;
	}

	// если количество иттераций равно 1, скрываем правую кнопку
	if(screen_count_news == 1) { 
		$('.main-page_right-lister.popular').css('visibility', 'hidden');
	}

	var news_index = 1;
	var news_shift = 0; // полное смещение блока

	$('.main-page_right-lister.news').click(function(){
		console.log('двигаем влево');

		if (news_index < screen_count_news) {
			// отображаем левую кнопку
			$(this).siblings('.main-page_left-lister').animate({opacity: 1}, 1000);
			news_index++;
			news_shift = - (news_index - 1) * bl_width;
			if (news_index == screen_count_news) {
				// прячем правую кнопку для крайнего правого блока
				$(this).animate({opacity: 0}, 1000);
			}
		}

		// перемещаем блок влево
		$(this).siblings('.main-page_items-line').animate({left: news_shift}, 1000);

	});

	$('.main-page_left-lister.news').click(function(){
		console.log('двигаем вправо');

		if (news_index > 1) {
			// отображаем правую кнопку
			$(this).siblings('.main-page_right-lister').animate({opacity: 1}, 1000);
			news_index--;
			news_shift = - (news_index - 1) * bl_width;
			if (news_index == 1) {
				// прячем левую кнопку для крайнего левого блока
				$(this).animate({opacity: 0}, 1000);
			}
		}

		// перемещаем блок вправо
		$(this).siblings('.main-page_items-line').animate({left: news_shift}, 1000);

	});

	// ПЕРЕТАСКИВАНИЕ МЫШЬЮ
	$('.main-page_items-line.news').draggable({
		axis:'x',
		start:function(e, ui){

			// предотвращаем событие по клику
            ui.helper.bind("click.prevent", function(e){
            	e.preventDefault();
            });


			// фиксируем начальную позицию
            this.previousPosition = ui.position;

        },
        stop: function(e, ui) {

	        if(this.previousPosition.left > ui.position.left) { // если двинули влево

console.log('тянем влево!')

				if(news_index < screen_count_news) {

					// отображаем левую кнопку
					$(this).siblings('.main-page_left-lister').animate({opacity: 1}, 1000);

					news_index++;
					news_shift = - (news_index - 1) * bl_width;
					$(this).animate({left: news_shift}, 500)

					if (news_index == screen_count_news) {
						// прячем правую кнопку для крайнего правого блока
						$(this).siblings('.main-page_right-lister').animate({opacity: 0}, 1000);
					}

				} else {
					$(this).animate({left: news_shift}, 500);
				}

	        } else { // если двинули вправо

console.log('тянем вправо!');

				if(news_index > 1) {

					// отображаем правую кнопку
					$(this).siblings('.main-page_right-lister').animate({opacity: 1}, 1000);

					news_index--;
					news_shift = - (news_index - 1) * bl_width;
					$(this).animate({left: news_shift}, 500)

					if (news_index == 1) {
						// прячем левую кнопку для крайнего левого блока
						$(this).siblings('.main-page_left-lister').animate({opacity: 0}, 1000);
					}

				} else {
					$(this).animate({left: news_shift}, 500);
				}

	        }

	        // возвращаем возможность клика
			setTimeout(function(){
				ui.helper.unbind("click.prevent");
			}, 500);
		},
	});

	// ДЛЯ БЛОКА ПРОСМОТРЕННЫХ ТОВАРОВ *******************************************************************
	var seen_item_count = $('.main-page_items-line.seen').data('item-count'); // количество товаров всего
	var seen_item_count_visible = (wrapper_bl_width + item_margin - 10) / item_bl_width; // количество товаров видимых
	var screen_count_seen; // количество итераций
	if((seen_item_count / seen_item_count_visible).toString().split(".")[1]) {
		screen_count_seen = +(seen_item_count / seen_item_count_visible).toString().split(".")[0] + 1;
	} else {
		screen_count_seen = seen_item_count / seen_item_count_visible;
	}

	// если количество иттераций равно 1, скрываем правую кнопку
	if(screen_count_seen == 1) { 
		$('.main-page_right-lister.seen').css('visibility', 'hidden');
	}

	var seen_index = 1;
	var seen_shift = 0; // полное смещение блока

	$('.main-page_right-lister.seen').click(function(){
		console.log('двигаем влево');

		if (seen_index < screen_count_seen) {
			// отображаем левую кнопку
			$(this).siblings('.main-page_left-lister').animate({opacity: 1}, 1000);
			seen_index++;
			seen_shift = - (seen_index - 1) * bl_width;
			if (seen_index == screen_count_seen) {
				// прячем правую кнопку для крайнего правого блока
				$(this).animate({opacity: 0}, 1000);
			}
		}

		// перемещаем блок влево
		$(this).siblings('.main-page_items-line').animate({left: seen_shift}, 1000);

	});

	$('.main-page_left-lister.seen').click(function(){
		console.log('двигаем вправо');

		if (seen_index > 1) {
			// отображаем правую кнопку
			$(this).siblings('.main-page_right-lister').animate({opacity: 1}, 1000);
			seen_index--;
			seen_shift = - (seen_index - 1) * bl_width;
			if (seen_index == 1) {
				// прячем левую кнопку для крайнего левого блока
				$(this).animate({opacity: 0}, 1000);
			}
		}

		// перемещаем блок вправо
		$(this).siblings('.main-page_items-line').animate({left: seen_shift}, 1000);

	});

	// ПЕРЕТАСКИВАНИЕ МЫШЬЮ
	$('.main-page_items-line.seen').draggable({
		axis:'x',
		start:function(e, ui){

			// предотвращаем событие по клику
            ui.helper.bind("click.prevent", function(e){
            	e.preventDefault();
            });


			// фиксируем начальную позицию
            this.previousPosition = ui.position;

        },
        stop: function(e, ui) {

	        if(this.previousPosition.left > ui.position.left) { // если двинули влево

console.log('тянем влево!')

				if(seen_index < screen_count_seen) {

					// отображаем левую кнопку
					$(this).siblings('.main-page_left-lister').animate({opacity: 1}, 1000);

					seen_index++;
					seen_shift = - (seen_index - 1) * bl_width;
					$(this).animate({left: seen_shift}, 500)

					if (seen_index == screen_count_seen) {
						// прячем правую кнопку для крайнего правого блока
						$(this).siblings('.main-page_right-lister').animate({opacity: 0}, 1000);
					}

				} else {
					$(this).animate({left: seen_shift}, 500);
				}

	        } else { // если двинули вправо

console.log('тянем вправо!');

				if(seen_index > 1) {

					// отображаем правую кнопку
					$(this).siblings('.main-page_right-lister').animate({opacity: 1}, 1000);

					seen_index--;
					seen_shift = - (seen_index - 1) * bl_width;
					$(this).animate({left: seen_shift}, 500)

					if (seen_index == 1) {
						// прячем левую кнопку для крайнего левого блока
						$(this).siblings('.main-page_left-lister').animate({opacity: 0}, 1000);
					}

				} else {
					$(this).animate({left: seen_shift}, 500);
				}

	        }

	        // возвращаем возможность клика
			setTimeout(function(){
				ui.helper.unbind("click.prevent");
			}, 500);
		},
	});

});