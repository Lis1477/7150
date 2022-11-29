$(document).ready(function(){

	console.log('выпадашка поиска');

	// показываем результат поиска
    $('body').on('change input click paste', '.js-search', function (e) {

    	// берем поисковую фразу
        search_string = $.trim($(this).val());

		// берем токен
		var token = $('input[name=_token]').val()

        if(search_string.length > 2) {

	        $.ajax({
	            type: 'post',
	            url: "/ajax-search",
	            data: {
	                'search_string': search_string,
	                '_token': token,
	            },
	            success: function(data){
	            	// вставляем результат
	            	$('.js-result-block').html(data).show();
	            	// console.log(data);
	            },
	        });

        } else {
            $('.js-result-block').hide();
        }

    });

    // прячем выпадашку при нажатии вне
    $(document).click(function(e) {
        if (!($('.js-search-block').has(e.target).length)) {
            $('.js-result-block').hide();
        }

        e.stopPropagation();
    });

    // удаляем поисковую строку по нажатию на крестик
    $('.js-string-del').click(function(){
    	$('input[name=search_string]').val('');
    });

    // предотвращение сработки кнопки поиска при запросе до 2 символов
    $('.js-search-submit').click(function(){
    	// берем поисковый запрос
    	var str = $.trim($('input[name=search_string]').val());
    	if(str.length < 3) {
    		return false;
    	}
    });

});