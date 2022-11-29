$(document).ready(function(){

    console.log('товарные фильтры');

    // берем дефолтные значения для ценового диапазона ************************************
    var min_price = Number($('.js-min-max').data('minPrice'));
    var max_price = Number($('.js-min-max').data('maxPrice'));

    // обрабатываем ценовой диапазон
    $("#slider-range").slider({
        range: true,
        min: min_price,
        max: max_price,
        values: [min_price, max_price],
        step: .01,
        slide: function(event, ui) {
            $("input[name=price_from]").val(number_format(ui.values[0]));
            $("input[name=price_to]").val(number_format(ui.values[1]));
        }
    });

    $('input[name=price_from]').val(number_format($("#slider-range").slider("values", 0)));
    $('input[name=price_to]').val(number_format($("#slider-range").slider("values", 1)));

    // ручной ввод цен **********************************************************************
    $('input[name=price_from], input[name=price_to]').bind('blur', function(){

        // берем введенное значение; меняем запятую на точку, если есть; преобразуем в число
        var entered_price = parseFloat($(this).val().replace(/,/, '.'), 10);

        // определяем значения для левого и правого инпута
        var left_price, right_price;
        if($(this).attr('name') == 'price_from') {

            // значение левого инпута
            if(entered_price < min_price || !entered_price) {
                left_price = min_price;
            } else if(entered_price > max_price) {
                left_price = max_price;
            } else {
                left_price = entered_price;
            }
            
            // берем значение правого инпута
            right_price = Number($('input[name=price_to]').val());

            // если меньше левого, уравниваем
            if(right_price < left_price) {
                right_price = left_price;
            }

        } else if($(this).attr('name') == 'price_to') {

            // значение правого инпута
            if(entered_price > max_price || !entered_price) {
                right_price = max_price;
            } else if(entered_price < min_price) {
                right_price = min_price;
            } else {
                right_price = entered_price;
            }
            
            // берем значение правого инпута
            left_price = Number($('input[name=price_from]').val());

            // если больше правого, уравниваем
            if(left_price > right_price) {
                left_price = right_price;
            }

        }

        // меняем положение ползунка
        $("#slider-range").slider({
            values: [left_price, right_price],
        });

        // вписываем новые значения в инпуты
        $('input[name=price_from]').val(number_format($("#slider-range").slider("values", 0)));
        $('input[name=price_to]').val(number_format($("#slider-range").slider("values", 1)));

    });

    




});