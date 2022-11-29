$(document).ready(function(){

    console.log('обработчик кнопки Каталог');

    // отображаем/скрываем категории
    $('.js-button-catalog').click(function(){
        $('.js-category-drop-down').fadeToggle();

        if($(window).width()  > 1023) {
            $('.js-comp-category').slideToggle();
        } else {
            $('.js-mobile-category').slideToggle();
        }

        // удаляем класс active у всех главных категорий
        $('.js-main-category').removeClass('active');
        // добавляем класс active к первой главной категории
        $('.js-first-main-cat').addClass('active');

        // прячем все блоки подкатегорий
        $('.js-sub-category').hide();
        // отображаем нужную
        $('.js-first-sub-cat').fadeIn('300');
    });

    // скрываем категории при нажатии вне выпадашки
    $(document).click(function(e) {
        if (!($('.js-button-catalog').has(e.target).length || $('.js-category-drop-down').has(e.target).length)) {
            $('.js-category-drop-down').fadeOut();
            $('.js-comp-category, .js-mobile-category').slideUp();
        }

        e.stopPropagation();
    });

    // показываем подкатегории при наведении на главные
    $('.js-main-category').mouseenter(function(){
        // определяем id_1c категории
        var cat_1c_id = $(this).data('cat');

        // удаляем класс active у всех главных категорий
        $('.js-main-category').removeClass('active');
        // добавляем класс active к текущей главной категории
        $(this).addClass('active');

        // прячем все блоки подкатегорий
        $('.js-sub-category').hide();
        // отображаем нужную
        $('.js-sub-cat-'+cat_1c_id).fadeIn('300');

    });

    // для малых экранов
    $('.js-main-category-mobile').click(function(e){
        // отменяем действие по умолчанию
        e.preventDefault();

        // открываем/закрываем подкатегории
        $(this).toggleClass('active').next('.js-subcategory-mobile-block').toggleClass('active').slideToggle();

        // класс для стрелки
        $(this).find('.js-arrow').toggleClass('active');
    });


});