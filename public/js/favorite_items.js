$(document).ready(function(){

// $.removeCookie('favorite_items');

	console.log('избранные товары');

	// добавляем в избранное
	$('.js-to-selected').click(function(e){

		// запрещаем действие по умолчанию
		e.preventDefault();

		// берем id_1c товара
		var item_code = $(this).data('id-1c');

		// тип события
		var event_type;

		// определяем событие
		if($(this).hasClass('item_in_favorite')) {
			// определяем событие
			event_type = 'del';
		} else {
			// определяем событие
			event_type = 'add';
		}

		// проверяем авторизован ли пользователь,
		// если да, добавляем в БД
		var user_checked = changeFavorite(item_code, event_type);

		// если авторизован
		if(user_checked == 1) {
			// добавляем/удаляем класс для кнопки
			if($(this).hasClass('item_in_favorite')) {
				// удаляем класс, меняем title
				$(this).removeClass('item_in_favorite').attr('title', 'В избранное');

				// узнаем имя текущего роута
				var current_route = $(this).data('routeName');

				// если страница избранных
				if(current_route == 'favorite-items-page') {
					// удаляем элемент
					$(this).parents('.js-item-element').remove();

					// считаем кол. товаров
					var count_in_favorite = $('.js-item-element').length;

					// если нет
					if(count_in_favorite == 0) {
						// отображаем блок отсутствия избранных
						$('.js-no-favorites').show();
					}
				}

			} else {
				// добавляем класс, меняем title
				$(this).addClass('item_in_favorite').attr('title', 'Удалить из избранного');
			}


		} else { // если не авторизован

			// для записи избранных элементов
			var favorite_elements;

			// количество избранных элементов
			var count_in_favorite;

			if($.cookie('favorite_items')) { // если есть кука Избранное

				// берем куку избранных
				favorite_elements = JSON.parse($.cookie('favorite_items'));

				// если товар в избранных
				if($(this).hasClass('item_in_favorite')) {

					// удаляем 
					favorite_elements = $.grep(favorite_elements, function(el){
						return el['item_code'] != item_code;
					});

					// если элементов более нет
					if(favorite_elements.length == 0) {
						// удаляем куку
						$.cookie('favorite_items', '', {expires: -1, path: '/'});

						// записываем количество к иконке в хэдере
						$('.js-item-in-favorite').removeClass('item_in_favorite').text('0');

						// добавляем класс, меняем title
						$(this).removeClass('item_in_favorite').attr('title', 'В избранное');

						// отображаем блок отсутствия избранных
						$('.js-no-favorites').show();
					} else {

						// количество элементов в куке
						count_in_favorite = favorite_elements.length;

						// преобразуем в строку
						favorite_elements = JSON.stringify(favorite_elements);

						// переписываем куку
						$.cookie('favorite_items', favorite_elements, {expires: 365, path: '/'});

						// записываем количество к иконке в хэдере
						$('.js-item-in-favorite').text(count_in_favorite);

						// добавляем класс, меняем title
						$(this).removeClass('item_in_favorite').attr('title', 'В избранное');
					}

					// узнаем имя текущего роута
					var current_route = $(this).data('routeName');

					// если страница избранных
					if(current_route == 'favorite-items-page') {
						// удаляем элемент
						$(this).parents('.js-item-element').remove();
					}

				} else {

					// добавляем код в избранное
					favorite_elements.push({
						item_code : item_code,
					});

					// количество элементов в куке
					count_in_favorite = favorite_elements.length;

					// преобразуем в строку
					favorite_elements = JSON.stringify(favorite_elements);

					// переписываем куку
					$.cookie('favorite_items', favorite_elements, {expires: 365, path: '/'});

					// записываем количество к иконке в хэдере
					$('.js-item-in-favorite').addClass('item_in_favorite').text(count_in_favorite);

					// добавляем класс, меняем title
					$(this).addClass('item_in_favorite').attr('title', 'Удалить из избранного');
				}

			} else {
				// создаем массив и добавляем значение кода и количества
				favorite_elements = new Array();
				favorite_elements.push({
					item_code : item_code,
				});

				favorite_elements = JSON.stringify(favorite_elements);

				// создаем куку и записываем в нее данные
				$.cookie('favorite_items', favorite_elements, {expires: 365, path: '/'});

				// записываем количество к иконке в хэдере
				$('.js-item-in-favorite').addClass('item_in_favorite').text('1');

				// добавляем класс, меняем title
				$(this).addClass('item_in_favorite').attr('title', 'Удалить из избранного');
			}
		}


		// console.log(user_checked);
	});

    // функция обновления таблицы Избранное для зарегистрированных 
    function changeFavorite(item_code, event_type) {

		// берем токен
		var token = $('meta[name=csrf-token]').attr('content');

		// если пользователь авторизован, добавляем товар в БД
        var checked = $.ajax({
            type: 'post',
            url: '/change-favorite',
			global: false,
			async:false,
            data: {
				'item_code' : item_code,
				'event_type' : event_type,
                '_token': token,
            },
            success: function(data){

            	// если пользователь зарегистрирован
            	if(data['user_checked'] == 1) {
					// записываем количество к иконке в хэдере
					$('.js-item-in-favorite').addClass('item_in_favorite').text(data['favorite_item_count']);
					// если нет в избранных, удаляем класс
					if(data['favorite_item_count'] == 0) {
						$('.js-item-in-favorite').removeClass('item_in_favorite');
					}
            	}
            },
        }).responseText;

        return JSON.parse(checked)['user_checked'];
    }


});