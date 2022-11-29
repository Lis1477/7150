$(document).ready(function(){

    // счетчик для подсчета количества видео
    var video_count = 0;

    // открываем окно, выводим видео
    $('.js_video_link').click(function() {

        // открываем
        $('.popup-youtube').fadeIn();

        // формируем массив кодов
        var cod_array = $(this).attr('video').split(';');

        // вставляем видео
        var inset = '';
        cod_array.forEach((item) => {

            if(item) {
                inset = inset + '<div class="popup-youtube_element"><iframe src="https://www.youtube.com/embed/' + item + '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
                video_count++;
            }
        });
        $('.popup-youtube_video-block').html(inset);

        //если только 1 видео скрываем правую кнопку
        if(video_count == 1) {
            $('.popup-youtube_right').css('display', 'none');
        }

    });

    // вводим параметр смещение
    var shift = 0;
    // вводим параметр кратность смещения
    var count_shift = 1;

    // жмем правую кнопку
    $('.popup-youtube_right').click(function(){
        // определяем ширину видео
        var element_width = $('.popup-youtube_element').width();
        // берем первый элемент
        var first_element = $('.popup-youtube_element').first();
        // смещаем влево
        shift -= element_width;
        first_element.animate({marginLeft: shift}, 'slow');

        count_shift++;

        // скрываем правую кнопку на последнем видео
        if(count_shift == video_count) {
            $(this).fadeOut('slow' , 'linear');
        }
        // отображаем левую кнопку начиная со второго видео
        if(count_shift > 1) {
            $('.popup-youtube_left').css('display', 'block');
        }
    });

    // жмем левую кнопку
    $('.popup-youtube_left').click(function(){
        // определяем ширину видео
        var element_width = $('.popup-youtube_element').width();
        // берем первый элемент
        var first_element = $('.popup-youtube_element').first();
        // смещаем влево
        shift += element_width;
        first_element.animate({marginLeft: shift}, 'slow');

        count_shift--;

        // показываем правую кнопку если не последнее видео
        if(count_shift < video_count) {
            $('.popup-youtube_right').css('display', 'block');
        }
        // скрываем левую кнопку если первое видео
        if(count_shift == 1) {
            $(this).fadeOut('slow' , 'linear');
        }
    });

    // закрываем окно
    $('.popup-youtube_close-button').click(function() {
        $('.popup-youtube').fadeOut();
        // даем дефолтные значения
        video_count = 0;
        shift = 0;
        count_shift = 1
        $('.popup-youtube_left').css('display', 'none');
        $('.popup-youtube_right').css('display', 'block');
        $('.popup-youtube_video-block').html('');
    });

	console.log('всплывающее окно Youtube');

});