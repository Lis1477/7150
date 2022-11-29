$(document).ready(function(){

	// $.cookie('in_cart', '', {expires: -1, path: '/'});

	console.log('манипуляции с корзиной');

	// меняем количество товара по нажатию на + **************************************
	$('.js-in-cart-plus').on('click', function(){

		// находим input
		var input = $(this).prev('.js-in-cart-input').children('input[type="number"]');
		// текущее значение val
		var input_val = +input.val();
		if(input_val > 99998) {
			input_val = 99998;
		}
		// добавляем 1 и пишем в input
		input.val(input_val + 1);

		// если товар есть в корзине
		if($(this).hasClass('item_in_cart')) {

			// определяем код товара
			var item_code = $(this).prev('.js-in-cart-input').data('itemCode');

			// определяем количество
			var item_count = Number(input.val());

			// проверяем авторизован ли пользователь,
			// если да, меняем в БД
			var user_checked = changeCart(item_code, item_count);

			// если не авторизован
			if(user_checked == 0) {
				// переводим строку корзины в объект
				cart_elements = JSON.parse($.cookie('in_cart'));

				$.each(cart_elements, function(i, el){
					// меняем количество соответствующего товара
					if(el['item_code'] == item_code) {
						// меняем количество
						cart_elements[i]['item_count'] = item_count;
						// завершаем цикл
						return false;
					}
				});

				// преобразуем в строку
				cart_elements = JSON.stringify(cart_elements);

				// переписываем куку
				$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});
			}

			// определяем текущий роут
			var route_name = $(this).parents('.js-cart-line').find('.js-in-cart-input').data('routName');
			if(route_name == "cart-page") { // если находимся в корзине

				// берем текущую линию
				var current_cart_line = $(this).parents('.js-cart-line');

				// берем цену товара
				var item_price = Number(current_cart_line.find('span.js-item-price').text());
				// расчитываем результирующую стоимость
				var total_price = item_count * item_price;
				// записываем
				current_cart_line.find('.js-line-total-price').text(number_format(total_price));

				// берем старую цену товара
				var item_old_price = Number(current_cart_line.find('span.js-old-price').text());
				// расчитываем результирующую экономию
				var total_economy = item_count * (item_old_price - item_price);
				// записываем
				current_cart_line.find('.js-line-economy').text(number_format(total_economy));

				// пересчитываем результаты корзины
				recalc_cart();
			}
		}
	});

	// меняем количество товара по нажатию на - *************************************
	$('.js-in-cart-minus').click(function(){
		// находим input
		var input = $(this).next('.js-in-cart-input').children('input[type="number"]');
		// значение val
		var input_val = +input.val();
		// уменьшаем на 1
		var input_val_new = input_val - 1;
		// если меньше 1, пишем 1
		if(input_val_new < 1) {
			input_val_new = 1;
		}
		// пишем в input
		input.val(input_val_new);

		// если товар есть в корзине
		if($(this).hasClass('item_in_cart')) {

			// определяем код товара
			var item_code = $(this).next('.js-in-cart-input').data('itemCode');

			// определяем количество
			var item_count = Number(input.val());

			// проверяем авторизован ли пользователь,
			// если да, меняем в БД
			var user_checked = changeCart(item_code, item_count);

			// если не авторизован
			if(user_checked == 0) {
				// переводим строку корзины в объект
				cart_elements = JSON.parse($.cookie('in_cart'));

				$.each(cart_elements, function(i, el){
					// меняем количество соответствующего товара
					if(el['item_code'] == item_code) {
						// меняем количество
						cart_elements[i]['item_count'] = item_count;
						// завершаем цикл
						return false;
					}
				});

				// преобразуем в строку
				cart_elements = JSON.stringify(cart_elements);

				// переписываем куку
				$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});
			}

			// определяем текущий роут
			var route_name = $(this).parents('.js-cart-line').find('.js-in-cart-input').data('routName');
			if(route_name == "cart-page") { // если находимся в корзине

				// берем текущую линию
				var current_cart_line = $(this).parents('.js-cart-line');

				// берем цену товара
				var item_price = Number(current_cart_line.find('span.js-item-price').text());
				// расчитываем результирующую стоимость
				var total_price = item_count * item_price;
				// записываем
				current_cart_line.find('.js-line-total-price').text(number_format(total_price));

				// берем старую цену товара
				var item_old_price = Number(current_cart_line.find('span.js-old-price').text());
				// расчитываем результирующую экономию
				var total_economy = item_count * (item_old_price - item_price);
				// записываем
				current_cart_line.find('.js-line-economy').text(number_format(total_economy));

				// пересчитываем результаты корзины
				recalc_cart();
			}
		}

	});

	// ручной ввод ******************************************************************
	$('.js-in-cart-input input[type="number"]').bind('change', function(){
		// определяем измененное значение
		var input_val = $(this).val();
		// если не число или меньше 1, пишем 1
		if(!$.isNumeric(input_val) || input_val < 1) {
			input_val = 1;
		} else if(input_val > 99999) {
			input_val = 99999;
		}
		// записываем значение
		$(this).val(input_val);

		// если товар есть в корзине
		if($('.js-in-cart-input').hasClass('item_in_cart')) {

			// определяем код товара
			var item_code = $(this).parent('.js-in-cart-input').data('itemCode');

			// определяем количество
			var item_count = Number($(this).val());

			// проверяем авторизован ли пользователь,
			// если да, меняем в БД
			var user_checked = changeCart(item_code, item_count);

			// если не авторизован
			if(user_checked == 0) {

				// переводим строку корзины в объект
				cart_elements = JSON.parse($.cookie('in_cart'));

				$.each(cart_elements, function(i, el){
					// меняем количество соответствующего товара
					if(el['item_code'] == item_code) {
						// меняем количество
						cart_elements[i]['item_count'] = item_count;
						// завершаем цикл
						return false;
					}
				});

				// преобразуем в строку
				cart_elements = JSON.stringify(cart_elements);

				// переписываем куку
				$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});
			}

			// определяем текущий роут
			var route_name = $(this).parents('.js-cart-line').find('.js-in-cart-input').data('routName');
			if(route_name == "cart-page") { // если находимся в корзине

				// берем текущую линию
				var current_cart_line = $(this).parents('.js-cart-line');

				// берем цену товара
				var item_price = Number(current_cart_line.find('span.js-item-price').text());
				// расчитываем результирующую стоимость
				var total_price = item_count * item_price;
				// записываем
				current_cart_line.find('.js-line-total-price').text(number_format(total_price));

				// берем старую цену товара
				var item_old_price = Number(current_cart_line.find('span.js-old-price').text());
				// расчитываем результирующую экономию
				var total_economy = item_count * (item_old_price - item_price);
				// записываем
				current_cart_line.find('.js-line-economy').text(number_format(total_economy));

				// пересчитываем результаты корзины
				recalc_cart();
			}
		}

	});

	// нажимаем кнопку Добавить в корзину в карточке товаров *************************
	$('.js-in-cart-button').on('click', function(){

		if(!$(this).hasClass('item_in_cart')) { // если товар не в корзине

			// определяем код товара
			var item_code = $('.js-in-cart-input').data('itemCode');
			// определяем количество
			var item_count = Number($('.js-in-cart-input input[type="number"]').val());

			// проверяем авторизован ли пользователь,
			// если да, добавляем в БД
			var user_checked = changeCart(item_code, item_count);

			// добавляем класс для кнопки
			$(this).addClass('item_in_cart').attr('title', 'Перейти в корзину');

			// если не авторизован
			if(user_checked == 0) {

				// для записи элементов корзины
				var cart_elements;
				// присутствие кода в корзине
				var code_in_cart = false;
				// количество элементов в корзине
				var count_in_cart;

				if($.cookie('in_cart')) { // если есть кука Корзины

					cart_elements = JSON.parse($.cookie('in_cart'));
					$.each(cart_elements, function(i, el){
						// если код есть в корзине
						if(el['item_code'] == item_code) {
							// меняем количество
							cart_elements[i]['item_count'] += item_count;

							// меняем метку присутствия кода в корзине, останавливаем цикл
							code_in_cart = true;
							return false;
						}
					});

					if(code_in_cart) { // если код присутствует в корзине
						// преобразуем в строку
						cart_elements = JSON.stringify(cart_elements);
						// переписываем куку
						$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});
					} else { // если кода нет в корзине
						// добавляем код в корзину
						cart_elements.push({
							item_code : item_code,
							item_count : item_count
						});

						// определяем количество элементов в корзине
						count_in_cart = cart_elements.length;

						// преобразуем в строку
						cart_elements = JSON.stringify(cart_elements);

						// перезаписываем куку
						$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});

						// меняем количество в миникорзине (в шапке)
						$('.js-in-cart-mini').html(count_in_cart);

						// добавляем класс и надпись и title у кнопки
						$(this).addClass('item_in_cart').children('.title').html('ТОВАР В КОРЗИНЕ').attr('title', 'Перейти в корзину');

						// добавляем класс для input
						$('.js-in-cart-plus, .js-in-cart-minus, .js-in-cart-input').addClass('item_in_cart');
					}

				} else {
					// создаем массив и добавляем значение кода и количества
					cart_elements = new Array();
					cart_elements.push({
						item_code : item_code,
						item_count : item_count
					});

					cart_elements = JSON.stringify(cart_elements);

					// создаем куку и записываем в нее данные
					$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});

					// меняем класс и количество в миникорзине (в шапке)
					$('.js-in-cart-mini').addClass('item_in_cart').html('1');

					// добавляем класс и надпись и title у кнопки
					$(this).addClass('item_in_cart').children('.title').html('ТОВАР В КОРЗИНЕ').attr('title', 'Перейти в корзину');

					// добавляем класс для input
					$('.js-in-cart-plus, .js-in-cart-minus, .js-in-cart-input').addClass('item_in_cart');

				}
			}
		} else { // если товар в корзине
			window.location.href = '/cart';
		}

	});

	// нажимаем кнопку Добавить в корзину в товарном блоке ***************************
	$('.js-item-block-button').on('click', function(e){

		e.preventDefault();

		if (!$(this).hasClass('item_in_cart')) { // если товар не в корзине
			// определяем код товара
			var item_code = $(this).data('itemCode');

			// проверяем авторизован ли пользователь,
			// если да, добавляем в БД
			var user_checked = changeCart(item_code, 1);

			// добавляем класс для кнопки
			$(this).addClass('item_in_cart').attr('title', 'Перейти в корзину');

			// если не авторизован
			if(user_checked == 0) {

				// для записи элементов корзины
				var cart_elements;

				if($.cookie('in_cart')) { // если есть кука Корзины

					// преобразуем строку в объект
					cart_elements = JSON.parse($.cookie('in_cart'));

					// добавляем код в корзину
					cart_elements.push({
						item_code : item_code,
						item_count : 1,
					});

					// определяем количество элементов в корзине
					count_in_cart = cart_elements.length;

					// преобразуем в строку
					cart_elements = JSON.stringify(cart_elements);

					// перезаписываем куку
					$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});

					// меняем количество в миникорзине (в шапке)
					$('.js-in-cart-mini').html(count_in_cart);

				} else {

					// создаем массив и добавляем значение кода и количества
					cart_elements = new Array();
					cart_elements.push({
						item_code : item_code,
						item_count : 1
					});

					// преобразуем в строку
					cart_elements = JSON.stringify(cart_elements);

					// создаем куку и записываем в нее данные
					$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});

					// меняем класс и количество в миникорзине (в шапке)
					$('.js-in-cart-mini').addClass('item_in_cart').html('1');

				}
			}

		} else { // если товар в корзине
			window.location.href = '/cart';
		}
	});

	// удаляем товарную линию ************************************************
	$('.js-delete-item').click(function(){
		// берем товарную линию
		var current_cart_line = $(this).parents('.js-cart-line');

		// узнаем код товара
		var item_code = current_cart_line.find('.js-in-cart-input').data('itemCode');

		// проверяем авторизован ли пользователь,
		// если да, меняем в БД
		var user_checked = changeCart(item_code, 0);

		// если не авторизован
		if(user_checked == 0) {

			// берем позиции корзины из куки
			cart_elements = JSON.parse($.cookie('in_cart'));

			// удаляем из массива данный товар
			$.each(cart_elements, function(i, el){
				// если код есть в корзине
				if(el['item_code'] == item_code) {
					// удаляем
					cart_elements.splice(i, 1);
					return false;
				}
			});

			if(cart_elements.length) { // если массив не пустой
				// преобразуем в строку
				cart_elements = JSON.stringify(cart_elements);
				// переписываем куку
				$.cookie('in_cart', cart_elements, {expires: 365, path: '/'});

				// берем количество в миникорзине
				var mini_cart_count =  Number($('.js-in-cart-mini').text());
				// уменьшаем и записываем
				$('.js-in-cart-mini').text(mini_cart_count - 1);

			} else {
				// удаляем куку
				$.cookie('in_cart', '', {expires: -1, path: '/'});

				// обнуляем миникорзину
				$('.js-in-cart-mini').removeClass('item_in_cart').text('0');

			}

		}

		// удаляем товарную линию
		current_cart_line.remove();

		// пересчитываем результат корзины
		recalc_cart();

		// узнаем количество линий
		var count_line = $('.js-cart-line').length;

		// если есть линии
		if(count_line == 0) {
			// прячем блок товарных линий
			$('.js-info-wrapper').hide();

			// отображаем блок Корзина пуста
			$('.js-empty-cart').show();

			// обнуляем миникорзину
			$('.js-in-cart-mini').removeClass('item_in_cart');
		}

	});

	// переход в корзину по клику в миникорзине *******************************************
	$('.js-mini-cart-link').click(function(){
		window.location.href = '/cart';
	});

	// функция пересчета корзины товаров *****************************************************
	function recalc_cart() {

		// собираем товарные линии
		var cart_lines = $('.js-cart-line');

		// для подсчета результирующей стоимости
		var total_price = 0;
		// для подсчета результирующей экономии
		var economy_line_price;
		var total_economy = 0;
		// для подсчета результирующего веса
		var total_weight = 0;

		// строка товар-экономия
		var economy_str = '';
		var item_id_1c;

		cart_lines.each(function(){
			// берем результирующую стоимость по товарным линиям
			total_price += Number($(this).find('span.js-line-total-price').text());

			// берем результирующую экономию по товарным линиям
			economy_line_price = Number($(this).find('span.js-line-economy').text())
			total_economy += economy_line_price;

			// формируем строку товаров с экономией
			// если есть экономия
			if(economy_line_price) {
				// берем id_1c товара
				item_id_1c = $(this).data('itemId');
				// дописываем строку экономии
				economy_str += item_id_1c + '-' + economy_line_price + '|';
			}

			// берем результирующий вес по товарным линиям
			total_weight += Number($(this).data('itemWeight') * $(this).find('input[type=number]').val());
		});

		// если строка товар-экономия не пуста
		if(economy_str) {
			// удаляем крайнюю палочку
			economy_str = economy_str.slice(0, -1);
			// пишем в инпут
			$('input[name=items_string]').val(economy_str);
		}

		// скрываем результирующую экономию, если 0
		if(!total_economy) {
			$('.js-total-economy-wrapper').hide();
		}

		// записываем
		$('.js-total-price, input[name=items_total]').text(number_format(total_price));
		$('input[name=items_total]').val(total_price);
		$('.js-total-economy').text(number_format(total_economy));
		$('input[name=items_economy]').val(total_economy);
		$('.js-total-weight').text(number_format(total_weight));
		$('input[name=items_weight]').val(total_weight);

		// если вес больше 28 кг, прячем некоторые способы доставок
		if (total_weight > 28) {
			$('.js-euro-to-punkt, .js-euro-to-door').hide();
		} else {
			$('.js-euro-to-punkt, .js-euro-to-door').show();
		}

		// отменяем выбранные значения способов доставки
    	// вставляем в заголовок блока вариантов доставки
    	$('.js-shipping-header').text('Выберите вариант доставки');
    	// прячем выпадашку вариантов доставки
		$('.js-shipping-lable').slideUp();
		$('.js-shipping-choice').removeClass('toggled');
		// скрываем внутренний кружочек радиокнопки типа доставок
		$('.js-d-round').hide();
		// снимаем checked у инпута
		$('input[name=delivery_type]').attr('checked', false);
		// скрываем ссылку на калькулятор
		$('.js-calculator-link-block').hide();
		// скрываем строку стоимости доставки и обнуляем
		$('.js-shipping-price-block').hide().find('.js-shipping-price').text(0);
		// обнуляем input стоимости доставки
		$('input[name=delivery_price]').val(0);
		// скрываем блоки доставок
		$('.js-pickup-block, .js-shipping-block, .js-address-block').fadeOut();

	}

    // функция обновления корзины для зарегистрированных 
    function changeCart(item_code, item_count) {

		// берем токен
		var token = $('meta[name=csrf-token]').attr('content');

		// если пользователь авторизован, добавляем товар в БД
        var checked = $.ajax({
            type: 'post',
            url: "/change-cart",
			global: false,
			async:false,
            data: {
				'item_code' : item_code,
				'item_count' : item_count,
                '_token': token,
            },
            success: function(data){

            	// если пользователь зарегистрирован
            	if(data['user_checked'] == 1) {
					// записываем количество в миникорзину
					$('.js-in-cart-mini').addClass('item_in_cart').text(data['cart_item_count']);
            	}

	           	// console.log(data);
            },
        }).responseText;

        return JSON.parse(checked)['user_checked'];
    }

	// Оформление заказа ****************************************************************

	// кнопка Оформить заказ
	$('.js-start-registration').click(function(){
		// скрываем кнопку Оформить заказ
		$(this).hide();
		// отображаем блок оформления заказа
		$('.js-registration-block').show();
		// отображаем блок ввода персональных данных
		$('.js-personal-data-block').slideDown();
		// отображаем кнопку Продолжить
		$('.js-personal-data-continue').show();
	});

	// блок Данные покупателя
	$('.js-client').click(function(){

		// скрываем внутренний кружочек радиокнопки
		$('.js-round').hide();
		// отображаем нужный
		$(this).find('.js-round').show();

		// устанавливаем checked у инпута
		$(this).find('input[name=client_type]').attr('checked', true);

		// если юр лицо
		if($('input[name=client_type]:checked').val() == 'company') {
			// отображаем блок для реквизитов
			$('.js-requisites').slideDown();
			// отображаем тип оплаты Безнал
			$('.js-invoice-paying').show()
		} else {
			// скрываем блок для реквизитов
			$('.js-requisites').slideUp();
			// скрываем тип оплаты Безнал
			$('.js-invoice-paying').hide()
		}
	});

	// кнопка Продолжить блока Данные покупателя
	$('.js-personal-data-continue').click(function(){

		// валидация обязательных полей
		// берем все обязательные инпуты
		var required_inputs = $('.js-user-data-block').find('.input.required');

		var input_data;
		// счетчик итераций
		var cnt = 0;
		// отображаем inset если input пустой
		required_inputs.each(function(){
			// определяем введенные данные в input
			input_data = $(this).find('input').val().trim();
			// если пусто, отображаем inset
			if(!input_data) {
				$(this).find('.js-input-inset').fadeIn();
				// останавливаем итерацию
				return false;
			}
			cnt ++;
		});

		// останавливаем, если кол итераций не равно кол инпутов
 		if(cnt != required_inputs.length) {
			return false;
		}

		//прячем кнопку Продолжить
		$(this).hide();

		// отображаем блок доставок
		$('.js-delivery-block').slideDown();

		// отображаем кнопку Продолжить блока
		$('.js-delivery-continue').show()

	});

	// блок Доставка
	$('.js-delivery').click(function(){

		// скрываем внутренний кружочек радиокнопки
		$('.js-d-round').hide();
		// отображаем нужный
		$(this).find('.js-d-round').show();

		// устанавливаем checked у инпута
		$(this).find('input[name=delivery_type]').attr('checked', true);

		// отображаем блок самовывоза
		if($('input[name=delivery_type]:checked').val() == 'pickup') {

			// отображаем блок самовывоза
			$('.js-pickup-block').slideDown();

			// скрываем ссылку на калькулятор
			$('.js-calculator-link-block').hide();

			// скрываем блоки доставки, стоимости и адреса
			$('.js-shipping-block, .js-shipping-price-block, .js-address-block').hide();
			// возвращаем в дефолтное состояние
			$('.js-shipping-header').text('Выберите вариант доставки');
			$('.js-shipping-price').text(0);

			// обнуляем input стоимости доставки
			$('input[name=delivery_price]').val(0);

			// снимаем checked у инпутов вариантов доставки
			$('.js-shipping-block').find('input[name=shipping]').attr('checked', false);

	    	// снимаем обязательность всех лэйблов блока доставок
	    	$('.js-delivery-block').find('.input.required').removeClass('required');
			
	  		// определяем стоимость заказа
	  		var cart_sum = Number($('.js-total-price').text());
			// записываем
			$('.js-total-plus-price').text(number_format(cart_sum));

		} else {

			// скрываем блок самовывоза
			$('.js-pickup-block').hide();

			// отображаем ссылку на калькулятор
			$('.js-calculator-link-block').fadeIn();

			// отображаем блок доставки
			$('.js-shipping-block').slideDown();


		}
	});

	// выбираем вариант доставки
	$('.js-shipping-choice').click(function(){
		$('.js-shipping-lable').slideToggle();
		$(this).toggleClass('toggled');
	});

	// скрываем выпадашку вариантов доставки при нажатии вне выпадашки
    $(document).click(function(e) {
        if (!($('.js-shipping-block').has(e.target).length)) {
            $('.js-shipping-lable').slideUp();
            $('.js-shipping-choice').removeClass('toggled');
        }

        e.stopPropagation();
    });

    // обработка кликов вариантов доставки
    $('.js-to-minsk, .js-euro-to-punkt, .js-euro-to-door, .js-alfasad').click(function(e){

    	// берем строку названия способа
    	var delivery_title = $(this).find('.js-shipping-title').text();
    	// вставляем в заголовок блока вариантов доставки
    	$('.js-shipping-header').text(delivery_title);
    	// прячем выпадашку вариантов доставки
		$('.js-shipping-lable').slideUp();
		$('.js-shipping-choice').removeClass('toggled');

    	// отображаем строку Стоимость доставки
    	$('.js-shipping-price-block').slideDown();

    	// определяем сумму заказа
    	var cart_sum = Number($('.js-total-price').text());

    	// определяем вес заказа
    	var cart_weight = Number($('.js-total-weight').text());

    	// определяем используемый инпут
    	var input_val = $(this).find('input').val();

    	// отображаем блок ввода адреса доставки
    	$('.js-address-block').slideDown();

    	// прячем линии ввода получателя, адреса, ПВ
    	$('.js-address-line').hide();

    	// обнуляем value и disabled для input города
//    	$('input[name=city]').val('').prop('disabled', false);
	   	$('input[name=city]').prop('disabled', false);


    	// стоимость доставки
    	var delivery_price = 0;

    	// в зависимости от суммы вписываем стоимости доставки
    	if(input_val == 'minsk') { // по Минску до дома

    		// определяем стоимость доставки
	    	if (cart_sum < 150) {
	    		$('.js-shipping-price').text(number_format(10));
				// переписываем input стоимости доставки
				$('input[name=delivery_price]').val(10);
	    	} else {
	    		$('.js-shipping-price').text(0);
				// переписываем input стоимости доставки
				$('input[name=delivery_price]').val(0);
	    	}

	    	// отображаем линию ввода адреса
	    	$('.js-for-minsk').slideDown();

	    	// устанавливаем value и disabled для input города
	    	$('input[name=city]').val('Минск').prop('disabled', true);

	    	// снимаем обязательность всех лэйблов блока доставок
	    	$('.js-delivery-block').find('.input.required').removeClass('required');

	    	// добавляем обязательность лэйблам полей Улица и дом
	    	$('input[name=street], input[name=house]').parent('.input').addClass('required');

    	} else if (input_val == 'euro_punkt') { // Европочтой до Пункта выдачи

    		// определяем стоимость доставки
	    	if (cart_sum < 150) {

	    		if(cart_weight < 2) {
	    			delivery_price = 5;
	    		} else if(cart_weight < 10) {
	    			delivery_price = 7;
	    		} else if(cart_weight < 18) {
	    			delivery_price = 9;
	    		} else if(cart_weight < 28) {
	    			delivery_price = 12;
	    		}

	    		$('.js-shipping-price').text(number_format(delivery_price));
				// переписываем input стоимости доставки
				$('input[name=delivery_price]').val(delivery_price);

	    	} else {
	    		$('.js-shipping-price').text(delivery_price);
				// переписываем input стоимости доставки
				$('input[name=delivery_price]').val(delivery_price);
	    	}

	    	// отображаем соответствующие линии ввода
	    	$('.js-for-euro-pv').slideDown();

	    	// снимаем обязательность всех лэйблов блока доставок
	    	$('.js-delivery-block').find('.input.required').removeClass('required');

	    	// добавляем обязательность лэйблам полей Улица и дом
	    	$('input[name=first_name], input[name=second_name], input[name=family_name]').parent('.input').addClass('required');

  		} else if (input_val == 'euro_door') { // Европочтой до двери

    		// определяем стоимость доставки
	    	if (cart_sum < 300) {

	    		if(cart_weight < 2) {
	    			delivery_price = 12;
	    		} else if(cart_weight < 10) {
	    			delivery_price = 14;
	    		} else if(cart_weight < 18) {
	    			delivery_price = 18;
	    		} else if(cart_weight < 28) {
	    			delivery_price = 24;
	    		}

	    		$('.js-shipping-price').text(number_format(delivery_price));
				// переписываем input стоимости доставки
				$('input[name=delivery_price]').val(delivery_price);

	    	} else {
	    		$('.js-shipping-price').text(delivery_price);
				// переписываем input стоимости доставки
				$('input[name=delivery_price]').val(delivery_price);
	    	}

	    	// отображаем соответствующие линии ввода
	    	$('.js-for-euro-door').slideDown();

	    	// снимаем обязательность всех лэйблов блока доставок
	    	$('.js-delivery-block').find('.input.required').removeClass('required');

	    	// добавляем обязательность лэйблам полей Улица и дом
	    	$('input[name=first_name], input[name=second_name], input[name=family_name], input[name=city], input[name=street], input[name=house]').parent('.input').addClass('required');


  		} else if (input_val == 'alfasad') { // службой Альфасад

    		// определяем стоимость доставки
	    	if (cart_sum < 500) {
	    		$('.js-shipping-price').text(number_format(30));
				// переписываем input стоимости доставки
				$('input[name=delivery_price]').val(30);
	    	} else {
	    		$('.js-shipping-price').text(0);
				// переписываем input стоимости доставки
				$('input[name=delivery_price]').val(0);
	    	}

	    	// отображаем соответствующие линии ввода
	    	$('.js-for-alfa').slideDown();

	    	// снимаем обязательность всех лэйблов блока доставок
	    	$('.js-delivery-block').find('.input.required').removeClass('required');

	    	// добавляем обязательность лэйблам полей Улица и дом
	    	$('input[name=city], input[name=street], input[name=house]').parent('.input').addClass('required');

  		}

  		// определяем стоимость доставки
  		delivery_price = Number($('.js-shipping-price').text());
		// считаем сумму по заказу
		var items_price_plus_delivery = cart_sum + delivery_price;
		// записываем
		$('.js-total-plus-price').text(number_format(items_price_plus_delivery));


    });

	// блок Оплата
	$('.js-paying').click(function(){

		// скрываем внутренний кружочек радиокнопки
		$('.js-p-round').hide();
		// отображаем нужный
		$(this).find('.js-p-round').show();

		// устанавливаем checked у инпута типа оплаты
		$(this).find('input[name=paying_type]').attr('checked', true);

		// снимаем checked у инпута вариантов оплаты
		$('input[name=money_type]').attr('checked', false);
		// скрываем внутренний кружочек радиокнопки
		$('.js-m-round').hide();

		// отображаем блок вариантов платежа при получении
		if($('input[name=paying_type]:checked').val() == 'upon_delivery') {

			// скрываем блок вариантов оплаты онлайн
			$('.js-site-online-block').hide();

			// отображаем блок вариантов оплаты при доставке
			$('.js-upon-delivery-block').slideDown();

		} else if($('input[name=paying_type]:checked').val() == 'site_online') {

			// скрываем блок вариантов оплаты при доставке
			$('.js-upon-delivery-block').hide();

			// отображаем блок вариантов оплаты онлайн
			$('.js-site-online-block').slideDown();

		} else if($('input[name=paying_type]:checked').val() == 'invoice') {

			// скрываем блок вариантов оплаты онлайн
			$('.js-site-online-block').hide();

			// скрываем блок вариантов оплаты при доставке
			$('.js-upon-delivery-block').hide();

		}
	});

	// кнопка Продолжить блока Доставка
	$('.js-delivery-continue').click(function(){

		// валидация обязательных полей
		// берем все обязательные инпуты
		var required_inputs = $('.js-registration-block').find('.input.required');

		var input_data;
		// счетчик итераций
		var cnt = 0;
		// отображаем inset если input пустой
		required_inputs.each(function(){
			// определяем введенные данные в input
			input_data = $(this).find('input').val().trim();
			// если пусто, отображаем inset
			if(!input_data) {
				$(this).find('.js-input-inset').fadeIn();
				// останавливаем итерацию
				return false;
			}
			cnt ++;
		});

		// останавливаем, если кол итераций не равно кол инпутов
 		if(cnt != required_inputs.length) {
			return false;
		}

		// валидация обязательных радиокнопок блока Доставка
		if(!$('input[name=delivery_type]:checked').length) {
			$('.js-delivery-type-block').find('.inset').fadeIn();
			return false;
		}

		// валидация обязательных радиокнопок блока вариантов доставки
		if(!$('input[name=shipping]:checked').length && $('input[name=delivery_type]:checked').val() == 'shipping') {
			$('.js-shipping-block').find('.inset').fadeIn();
			return false;
		}

		//прячем кнопку Продолжить
		$(this).hide();

		// отображаем блок оплаты
		$('.js-paying-block').slideDown();

		// отображаем кнопку Подтвердить заказ
		$('.js-confirm-order').show()

    });


	// блок Оплата
	$('.js-money').click(function(){

		// скрываем внутренний кружочек радиокнопки
		$('.js-m-round').hide();
		// отображаем нужный
		$(this).find('.js-m-round').show();

		// устанавливаем checked у инпута
		$(this).find('input[name=money_type]').attr('checked', true);

	});


	// кнопка Подтвердить заказ
	$('.js-confirm-order').click(function(){

		// валидация обязательных полей
		// берем все обязательные инпуты
		var required_inputs = $('.js-registration-block').find('.input.required');

		var input_data;
		// счетчик итераций
		var cnt = 0;
		// отображаем inset если input пустой
		required_inputs.each(function(){
			// определяем введенные данные в input
			input_data = $(this).find('input').val().trim();
			// если пусто, отображаем inset
			if(!input_data) {
				$(this).find('.js-input-inset').fadeIn();
				// останавливаем итерацию
				return false;
			}
			cnt ++;
		});

		// останавливаем, если кол итераций не равно кол инпутов
 		if(cnt != required_inputs.length) {
			return false;
		}

		// валидация обязательных радиокнопок блока Доставка
		if(!$('input[name=delivery_type]:checked').length) {
			$('.js-delivery-type-block').find('.inset').fadeIn();
			return false;
		}

		// валидация обязательных радиокнопок блока вариантов доставки
		if(!$('input[name=shipping]:checked').length && $('input[name=delivery_type]:checked').val() == 'shipping') {
			$('.js-shipping-block').find('.inset').fadeIn();
			return false;
		}

		// валидация обязательных радиокнопок типа оплат блока Оплата
		if(!$('input[name=paying_type]:checked').length) {
			$('.js-paying-type-block').find('.inset').fadeIn();
			return false;
		}

		// валидация обязательных радиокнопок способа оплат блока Оплата
		// если не выбран способ оплата Безнал
		if($('input[name=paying_type]:checked').val() != 'invoice' && !$('input[name=money_type]:checked').length) {
			$('.js-money-type-wrapper').find('.inset').fadeIn();
			return false;
		}

		// отправляем заказ
		$('#order-form').submit();
		// alert('Записываем заказ в БД');
	});


	// скрываем инсеты инпутов блока Доставка
    $(document).click(function(e) {
    	if(!($(e.target).hasClass('js-personal-data-continue') || $(e.target).hasClass('js-delivery-continue')  )) {
			$('.js-registration-block').find('.inset').fadeOut();
    	}
        e.stopPropagation();
    });

    // манипуляции с выбором адреса ***************************************
    // отображаем всплывающее окно списка адресов
    $('.js-select-link').click(function() {
    	$('.js-view-address').fadeIn();
    });

	// скрываем всплывающее окно списка адресов
	$('.js-popup-background, .js-popup-close-button').click(function(){
		$('.js-view-address, .js-change-address').fadeOut();
	});

	// обработка кнопки Вставить
	$('.js-insert-address').on('click', function(){

		// почистим кэш
		$(this).parents('.js-address-block').removeData();

		// берем блок с адресом
		var address_block = $(this).parents('.js-address-block');

		// берем данные для вставки
		var first_name = address_block.data('first_name');
		var second_name = address_block.data('second_name');
		var family_name = address_block.data('family_name');
		var city = address_block.data('city');
		var street = address_block.data('street');
		var house = address_block.data('house');
		var flat = address_block.data('flat');
		var corpus = address_block.data('corpus');
		var entrance = address_block.data('entrance');
		var floor = address_block.data('floor');

		// вставляем в инпуты
		$('input[name=first_name]').val(first_name);
		$('input[name=second_name]').val(second_name);
		$('input[name=family_name]').val(family_name);
		$('input[name=city]').val(city);
		$('input[name=street]').val(street);
		$('input[name=house]').val(house);
		$('input[name=flat]').val(flat);
		$('input[name=corpus]').val(corpus);
		$('input[name=entrance]').val(entrance);
		$('input[name=floor]').val(floor);

		// скрываем всплывающее окно
		$('.js-view-address').fadeOut();
	});

	// обработка кнопки Изменить адрес
	// открываем окно редактирования адреса
	$('.js-cart-change-address').on('click', function(){

		// скрываем всплывающее окно списка адресов
		$('.js-view-address').fadeOut();

		// открываем окно редактирования адреса
		var popup = $('.js-change-address');
		popup.fadeIn();

		// почистим кэш
		$(this).parents('.js-address-block').removeData();

		// берем блок с адресом
		var address_block = $(this).parents('.js-address-block');
		// берем данные для вставки
		var address_id = address_block.data('id');
		var first_name = address_block.data('first_name');
		var second_name = address_block.data('second_name');
		var family_name = address_block.data('family_name');
		var city = address_block.data('city');
		var street = address_block.data('street');
		var house = address_block.data('house');
		var flat = address_block.data('flat');
		var corpus = address_block.data('corpus');
		var entrance = address_block.data('entrance');
		var floor = address_block.data('floor');
		var main = address_block.data('main');

		// заполняем value инпутов
		popup.find('input[name=address_id]').val(address_id);
		popup.find('input[name=first_name]').val(first_name);
		popup.find('input[name=second_name]').val(second_name);
		popup.find('input[name=family_name]').val(family_name);
		popup.find('input[name=city]').val(city);
		popup.find('input[name=street]').val(street);
		popup.find('input[name=house]').val(house);
		popup.find('input[name=flat]').val(flat);
		popup.find('input[name=corpus]').val(corpus);
		popup.find('input[name=entrance]').val(entrance);
		popup.find('input[name=floor]').val(floor);

		if(main == 1) {
			popup.find('input[name=main_address]').attr('checked', true).attr('disabled', 'disabled');
			popup.find('input[name=main]').val('1');
			popup.find('.js-checkbox-title').text('основной');
		} else {
			popup.find('input[name=main_address]').attr('checked', false).removeAttr('disabled');
			popup.find('input[name=main]').val('0');
			popup.find('.js-checkbox-title').text('сделать основным');
		}
	});

	// сохраняем изменения адреса и вставляем
	$('.js-change-address-submit').on('click', function(e){

		// узнаем страницу сайта
		var page = $(this).parents('.js-change-address').data('page');

		// если корзина
		if(page == '/cart') {

		    var is_validate = $('.js-change-address-form')[0].checkValidity();

		    if (is_validate) {

				// отменяем событие по умолчанию
				e.preventDefault();

				page = 'cart';

				// берем токен
				var token = $('input[name=_token]').val();

				// берем popup
				var popup = $('.js-change-address');

				// определяем данные
				var address_id = popup.find('input[name=address_id]').val();
				var first_name = popup.find('input[name=first_name]').val();
				var second_name = popup.find('input[name=second_name]').val();
				var family_name = popup.find('input[name=family_name]').val();
				var city = popup.find('input[name=city]').val();
				var street = popup.find('input[name=street]').val();
				var house = popup.find('input[name=house]').val();
				var flat = popup.find('input[name=flat]').val();
				var corpus = popup.find('input[name=corpus]').val();
				var entrance = popup.find('input[name=entrance]').val();
				var floor = popup.find('input[name=floor]').val();
				var main = popup.find('input[name=main]').val();

		        $.ajax({
		            type: 'post',
		            url: "/cabinet/update-address",
		            data: {
		                '_token': token,
		                'page' : 'cart',
						'address_id' : address_id,
						'first_name' : first_name,
						'second_name' : second_name,
						'family_name' : family_name,
						'city' : city,
						'street' : street,
						'house' : house,
						'flat' : flat,
						'corpus' : corpus,
						'entrance' : entrance,
						'floor' : floor,
						'main' : main,
		            },
		            success: function(data) {

		            	// вставляем новую адресную строку
		            	$('.js-address-'+address_id).html(data);

		            	// меняем data аттрибуты
		            	var addr_bl = $('.js-address-'+address_id).parents('.js-address-block');
		            	addr_bl.attr('data-first_name', first_name);
		            	addr_bl.attr('data-second_name', second_name);
		            	addr_bl.attr('data-family_name', family_name);
		            	addr_bl.attr('data-city', city);
		            	addr_bl.attr('data-house', house);
		            	addr_bl.attr('data-flat', flat);
		            	addr_bl.attr('data-corpus', corpus);
		            	addr_bl.attr('data-entrance', entrance);
		            	addr_bl.attr('data-floor', floor);
		            	addr_bl.attr('data-main', main);

		            	// закрываем окно редактирования адреса
		            	$('.js-change-address').fadeOut();

		            	// открываем окно списка адресов
				    	$('.js-view-address').fadeIn();	            	

				    	// если это основной адрес
						if(main == 1) {

							// обнуляем значение data-main у всех блоков
							$('.js-address-block').attr('data-main', 0);

							// устанавливаем у текущего 1
							addr_bl.attr('data-main', 1);

							// прячем все чекбоксы
							$('.js-view_addr_checkbox').hide();

							// отображаем текущий чекбокс в списке адресов
							addr_bl.find('.js-view_addr_checkbox').show();

							// показываем все кнопки Удалить
							$('.js-cart-del-address').show();

							// отображаем текущую кнопку Удалить
							addr_bl.find('.js-cart-del-address').hide();
						}

		           		// console.log(addr_bl.find('.js-cart-del-address'));

		            },
		        });
		    }
		}
	});

	// чекаем обязательный адрес
	$('.js-change-address-checkbox').on('click', 'input[name=main_address]', function(){

		if($('input[name=main_address]:checked').length) {
			$(this).next('input[name=main]').val('1').next('.js-checkbox-title').text('основной');
		} else {
			$(this).next('input[name=main]').val('0').next('.js-checkbox-title').text('сделать основным');
		}
	});

	// открываем окно добавления адреса
	$('.js-cart-new-address').click(function(){
		// скрываем всплывающее окно списка адресов
		$('.js-view-address').fadeOut();
		// открываем окно
		$('.js-new-address').fadeIn();
	});

	// скрываем окно добавления/редактирования адреса
	$('.js-popup-background, .js-popup-close-button').click(function(){
		$('.js-new-address').fadeOut();
	});

	// чекаем обязательный адрес
	$('.js-new-address-checkbox').on('click', 'input[name=main_address]', function(){
		// console.log($('input[name=main_address]:checked').length);
		if($('input[name=main_address]:checked').length) {
			$(this).next('input[name=main]').val('1').next('.js-checkbox-title').text('основной');

		} else {
			$(this).next('input[name=main]').val('0').next('.js-checkbox-title').text('сделать основным');
		}
	});

	// сохраняем адрес и отображаем в списке
	$('.js-new-address-submit').click(function(e){

		// узнаем страницу сайта
		var page = $('.js-new-address').data('page');

		// если корзина
		if(page == '/cart') {

		    var is_validate = $('.js-new-address-form')[0].checkValidity();

		    if (is_validate) {
		    	// отменяем событие по умолчанию
				e.preventDefault();

				page = 'cart';

				// берем токен
				var token = $('input[name=_token]').val();

				// берем popup
				var popup = $('.js-new-address');

				// определяем данные
				var address_id = popup.find('input[name=address_id]').val();
				var first_name = popup.find('input[name=first_name]').val();
				var second_name = popup.find('input[name=second_name]').val();
				var family_name = popup.find('input[name=family_name]').val();
				var city = popup.find('input[name=city]').val();
				var street = popup.find('input[name=street]').val();
				var house = popup.find('input[name=house]').val();
				var flat = popup.find('input[name=flat]').val();
				var corpus = popup.find('input[name=corpus]').val();
				var entrance = popup.find('input[name=entrance]').val();
				var floor = popup.find('input[name=floor]').val();
				var main = popup.find('input[name=main]').val();

		        $.ajax({
		            type: 'post',
		            url: "/cabinet/add-address",
		            data: {
		                '_token': token,
		                'page' : 'cart',
						'address_id' : address_id,
						'first_name' : first_name,
						'second_name' : second_name,
						'family_name' : family_name,
						'city' : city,
						'street' : street,
						'house' : house,
						'flat' : flat,
						'corpus' : corpus,
						'entrance' : entrance,
						'floor' : floor,
						'main' : main,
		            },
		            success: function(data) {

		            	// вставляем список адресов
		            	$('.js-address-wrapper').html(data);

		            	$('#new-address-script').remove();

		            	// скрываем окно добавления адреса
	           			$('.js-new-address').fadeOut();

		            	// открываем окно списка адресов
				    	$('.js-view-address').fadeIn();

		            },
		        });
		    }
		}
	});

	// удаляем адрес
	$('.js-cart-del-address').on('click', function(){

		// берем блок с адресом
		var address_block = $(this).parents('.js-address-block');

		// берем id адреса
		var address_id = address_block.data('id');

		// берем статус адреса
		var address_main = address_block.data('main');

		// если адрес не главный
		if(address_main != 1) {
			// берем токен
			var token = $('input[name=_token]').val();

			// запрос на удаление
	        $.ajax({
	            type: 'post',
	            url: "/cabinet/del-address",
	            data: {
	                'address_id': address_id,
	                '_token': token,
	            },
	            success: function(data){
	            	if(data == true) {
	            		// удаляем блок с адресом
	            		address_block.remove();

						// почистим кэш
						address_block.removeData();

	            	} else {
	            		console.log('не удалил');
	            	}
	            },
	        });
		}

	});

});
