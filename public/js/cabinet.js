$(document).ready(function(){

	// *******************************************************
	console.log('редактируем профиль');

	// открываем окно редактирования профиля
	$('.js-open-change-profile').click(function(){
		$('.js-change-profile').fadeIn();
	});

	// скрываем окно редактирования профиля
	$('.js-popup-background, .js-popup-close-button').click(function(){
		$('.js-change-profile').fadeOut();
	});

	// тип клиента
	$('.js-client').click(function(){

		// скрываем внутренний кружочек радиокнопки
		$('.js-round').hide();
		// отображаем нужный
		$(this).find('.js-round').show();

		// устанавливаем checked у инпута
		$(this).find('input[name=client_type]').attr('checked', true);

	});

	// пол клиента
	$('.js-gender').click(function(){

		// скрываем внутренний кружочек радиокнопки
		$('.js-gender-round').hide();
		// отображаем нужный
		$(this).find('.js-gender-round').show();

		// устанавливаем checked у инпута
		$(this).find('input[name=gender_type]').attr('checked', true);

	});

	// добавляем телефон
	$('.js-add-phone').click(function(){
		// проверяем, заполнен ли телефон в инпуте
		var phone = $('.js-phone').last().find('.js-phone-input').val();
		if(phone) {
			$(this).prev('.js-phones').append("<div class='phone js-phone'><input type='tel' name='phone[]' class='phone-input js-phone-mask js-phone-input'><div class='checkbox-input-block'><input type='radio' name='main' class='js-main-phone'><span class='checkbox-title js-checkbox-title'>сделать основным</span><div class='phone-close-wrapper'><div class='phone-close-button js-phone-close-button' title='Удалить телефон''>✕</div></div></div></div>");
			$(".js-phone-mask").mask("+375 (99) 999-99-99");
		}
		console.log();
	});

	// чекаем главный телефон
	$('body').on('click', '.js-main-phone', function(){
		// берем номер телефона
		var phone = $(this).parents('.js-phone').find('.js-phone-input').val();
		if (!phone) {
			return false;
		} else {
			// меняем имя радиокнопок
			$('.js-checkbox-title').text('сделать основным');
			// записываем в val
			$(this).val(phone);
			// меняем имя текущей радиокнопки
			$(this).parents('.js-phone').find('.js-checkbox-title').text('основной');


		}
		// console.log($(this).val());
	});

	// удаляем телефон
	$('body').on('click', '.js-phone-close-button', function(){
		// считаем количество телефонов
		var phone_count = $('.js-phone').length;
		// если больше 1, удаляем
		if(phone_count > 1) {
			$(this).parents('.js-phone').remove();
		}
	});

	// открываем / скрываем инпут подтверждения пароля
	$('input[name=password]').on('input', function() {
		var pass_val = $(this).val();
		if(pass_val.length > 0) {
			$('.js-password-second').slideDown();
		} else {
			$('.js-password-second').slideUp();
		}
	});

	// если меняется пароль, сравниваем с подтверждением
	$('.js-personal-submit').click(function(){
		// берем значение пароля
		var pass = $.trim($('input[name=password]').val());
		if(pass) {
			// берем подтверждение
			var pass_conf = $.trim($('input[name=password_confirm]').val());
			// если не равны, останавливаем
			if(pass != pass_conf) {
				// выделяем ошибку
				$('.js-confirm-string').addClass('error');
				// останавливаем
				return false;
			}
		}

	})

	// снимаем выделение ошибки подтверждения пароля
	$('input[name=password], input[name=password_confirm]').focus(function(){
		$('.js-confirm-string').removeClass('error');
	});

	// *******************************************************
	console.log('добавляем/редактируем/удаляем адрес');

	// открываем окно редактирования адресов
	$('.js-open-new-address').click(function(){
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

	// открываем окно редактирования адресов
	$('.js-open-change-address').click(function(){
		// открываем окно
		var popup = $('.js-change-address');
		popup.fadeIn();

		// заполняем value инпутов
		popup.find('input[name=address_id]').val($(this).data('id'));
		popup.find('input[name=first_name]').val($(this).data('first_name'));
		popup.find('input[name=second_name]').val($(this).data('second_name'));
		popup.find('input[name=family_name]').val($(this).data('family_name'));
		popup.find('input[name=city]').val($(this).data('city'));
		popup.find('input[name=street]').val($(this).data('street'));
		popup.find('input[name=house]').val($(this).data('house'));
		popup.find('input[name=flat]').val($(this).data('flat'));
		popup.find('input[name=corpus]').val($(this).data('corpus'));
		popup.find('input[name=entrance]').val($(this).data('entrance'));
		popup.find('input[name=floor]').val($(this).data('floor'));

		if($(this).data('main') == 1) {
			popup.find('input[name=main_address]').attr('checked', true).attr('disabled', 'disabled');
			popup.find('input[name=main]').val('1');
			popup.find('.js-checkbox-title').text('основной');
		} else {
			popup.find('input[name=main_address]').attr('checked', false).removeAttr('disabled');
			popup.find('input[name=main]').val('0');
			popup.find('.js-checkbox-title').text('сделать основным');
		}

	});

	// удаление адреса
	$('.js-del-address').click(function(){

		// берем id адреса
		var address_id = $(this).data('id');

		// берем токен
		var token = $('input[name=_token]').val();

		// берем блок с адресом
		var address_block = $(this).parents('.js-address-wrapper');

        $.ajax({
            type: 'post',
            url: "del-address",
            data: {
                'address_id': address_id,
                '_token': token,
            },
            success: function(data){
            	if(data == true) {
            		// удаляем блок с адресом
            		address_block.remove();
            	} else {
            		console.log('не удалил');
            	}
            },
        });

	});

	// скрываем окно добавления/редактирования профиля/адреса
	$('.js-popup-background, .js-popup-close-button').click(function(){
		$('.js-change-address').fadeOut();
	});

	// *****************************************************************
	console.log('история покупок');
	// отображение заказанных товаров
	$('.js-items-block-button').click(function(){
		$(this).parent('.js-order-block').next('.js-items-block').slideToggle();
		$(this).parent('.js-order-block').find('.js-svg').toggleClass('toggled');
	});


});
