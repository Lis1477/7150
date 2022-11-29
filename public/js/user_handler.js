$(document).ready(function(){

	console.log('Вход/регистрация');

	$('.js-enter-user').click(function() {

		// открываем popup
		$('.js-popup-login').fadeIn();

		// показываем форму Войти
		$('.js-login-form').show();

		// меняем заголовок для формы
		$('.js-form-title').text('Войти')


	});

	// закрываем popup входа/регистрации
	$('.js-popup-close-button, .js-popup-wrapper').click(function() {

		//скрываем формы, закрываем окно
		$('.js-popup-login, .js-form').fadeOut();

	});

	// кнопка Регистрация в форме Войти
	$('.js-reg-open-form').click(function() {
		// скрываем все формы
		$('.js-form').hide();

		// отображаем форму регистрации
		$('.js-reg-form').fadeIn();

		// меняем заголовок для формы
		$('.js-form-title').text('Регистрация')
	});

	// кнопка Не помню пароль в форме Войти
	$('.js-remember-open-form').click(function() {
		// скрываем все формы
		$('.js-form').hide();

		// отображаем форму Восстановление пароля
		$('.js-remember-form').fadeIn();

		// меняем заголовок для формы
		$('.js-form-title').text('Восстановление пароля')
	});

	// кнопка Войти в форме Регистрация
	$('.js-login-open-form').click(function() {
		// скрываем все формы
		$('.js-form').hide();

		// отображаем форму регистрации
		$('.js-login-form').fadeIn();

		// меняем заголовок для формы
		$('.js-form-title').text('Войти');
	});

	// отображаем/скрываем блок опций для Юзера
	$('.js-options-open').click(function() {
		$('.js-options-block').fadeToggle();
	});

	// скрываем блок опций при нажатии вне выпадашки
    $(document).click(function(e) {
        if (!($('.js-options-open').has(e.target).length)) {
            $('.js-options-block').fadeOut();
        }

        e.stopPropagation();
    });

    // отображение/скрытие символов пароля
    $('.js-eye-toggler').click(function(){

    	$('.js-eye-closed, .js-eye-opened').toggleClass('toggled');

    	if($('.js-eye-closed').hasClass('toggled')) {
    		$('input[name=password], input[name=password_confirm]').attr('type', 'text');
    	}

    	if($('.js-eye-opened').hasClass('toggled')) {
    		$('input[name=password], input[name=password_confirm]').attr('type', 'password');
    	}

    });

});