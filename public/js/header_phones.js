$(document).ready(function(){


    if($(window).width() <= 1023) {

        console.log('телефоны в хэдере');

        // отображаем/скрываем телефонную выпадашку
    	$('.js-phones').click(function(e){

            // запрещаем действие по умолчанию
            e.preventDefault();

            // добавляем-удаляем класс у выпадашки
            $('.js-phones-drop-down').toggleClass('active');

        });

        // скрываем выпадашку при нажатии вне
        $(document).click(function(e) {
            if (!($('.js-phones').has(e.target).length || $('.js-phones-drop-down').has(e.target).length)) {
                $('.js-phones-drop-down').removeClass('active');
            }

            e.stopPropagation();
        });

    }
});