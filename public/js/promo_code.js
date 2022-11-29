$(document).ready(function(){

	console.log('активация промокода');

	$('.js-promo-button').click(function(e){

		e.preventDefault();

		// берем промокод
		var promo_code = $('input[name=promo_code]').val();
		promo_code = $.trim(promo_code);

		if(promo_code) { // если не пусто

			// берем токен
			var token = $('input[name=_token]').val()

	        $.ajax({
	            type: 'post',
	            url: "/promocode-verify",
	            data: {
	                'promo_code': promo_code,
	                '_token': token,
	            },
	            success: function(data){

	            	if (data['active'] == 0) {

	            		// вставляем ответ в выпадашку
	            		$('.js-answer-text').text(data['text']);

	            		// отображаем выпадашку
	            		$('.js-drop-out').fadeIn();

	            	} else {
	            		// отменяем запрет действия по умолчанию
	            		$('.js-promo-button').unbind('click').click();
	            	}
	            },
	        });
		}

	});

	// скрываем выпадашку нажимая на крестик
	$('.js-close-drop').click(function(){
		// скрываем выпадашку
		$('.js-drop-out').fadeOut();
	});

	// скрываем выпадашку при нажатии вне
    $(document).click(function(e) {
        if (!($('.js-drop-out').has(e.target).length)) {
            $('.js-drop-out').fadeOut();
        }
        e.stopPropagation();
    });

});