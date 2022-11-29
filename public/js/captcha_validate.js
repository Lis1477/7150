$(document).ready(function(){

    console.log('валидатор капчи');

    $('#captcha-validate-1').on('submit', function(e) {

        var captcha = $('input[name=RecaptchaField1]').val();
     
        if (captcha) {
            return true;
        } else {
            // добавляем сообщение об ошибке, если его еще нет
            if(!$('#captcha-error-1').length) {
                $('#RecaptchaField1').prepend('<div id="captcha-error-1" style="color: red; font-size: 14px; margin-bottom: 5px">Подтвердите, что Вы не робот!</div>');
            }
            return false;
        }

    });

    $('#captcha-validate-2').on('submit', function(e) {

        var captcha = $('input[name=RecaptchaField2]').val();
     
        if (captcha) {
            return true;
        } else {
            // добавляем сообщение об ошибке, если его еще нет
            if(!$('#captcha-error-2').length) {
                $('#RecaptchaField2').prepend('<div id="captcha-error-2" style="color: red; font-size: 14px; margin-bottom: 5px">Подтвердите, что Вы не робот!</div>');
            }
            return false;
        }

    });

    $('#captcha-validate-3').on('submit', function(e) {

        var captcha = $('input[name=RecaptchaField3]').val();
     
        if (captcha) {
            return true;
        } else {
            // добавляем сообщение об ошибке, если его еще нет
            if(!$('#captcha-error-3').length) {
                $('#RecaptchaField3').prepend('<div id="captcha-error-3" style="color: red; font-size: 14px; margin-bottom: 5px">Подтвердите, что Вы не робот!</div>');
            }
            return false;
        }

    });

    $('#captcha-validate-4').on('submit', function(e) {

        var captcha = $('input[name=RecaptchaField4]').val();
     
        if (captcha) {
            return true;
        } else {
            // добавляем сообщение об ошибке, если его еще нет
            if(!$('#captcha-error-4').length) {
                $('#RecaptchaField4').prepend('<div id="captcha-error-4" style="color: red; font-size: 14px; margin-bottom: 5px">Подтвердите, что Вы не робот!</div>');
            }
            return false;
        }

    });

});