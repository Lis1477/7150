$(document).ready(function(){

    if($(window).width() <= 1023) {

        console.log('бургер-меню');

        $('.js-burger').click(function() {

            $(this).toggleClass('active');

            $('.js-main-menu').fadeToggle();
        });

        // скрываем блок при нажатии вне выпадашки
        $(document).click(function(e) {
            if (!($('.js-burger').has(e.target).length)) {
                $('.js-main-menu').fadeOut();
                $('.js-burger').removeClass('active');
                e.stopPropagation();
            }

        });

    }

});