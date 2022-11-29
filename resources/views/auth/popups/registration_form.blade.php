            <form id="captcha-validate-4" method="POST" action="{{ route('register') }}" class="js-form js-reg-form" style="display: {{ $reg_style_par }};">

                {{ csrf_field() }}
                <input type="hidden" name="reg_form" value="1111">

                <div class="{{ $errors->has('name') ? ' has-error' : '' }}">

                    <label for="name" class="input-title">
                        Имя
                        <span class="red-star">*</span>
                    </label>

                    <div class="input name">

                        <input id="name" type="text" name="name" value="{{ old('name') }}" required>

                        @if ($errors->has('name'))

                            <div class="error">
                                {{ $errors->first('name') }}
                            </div>

                        @endif

                    </div>

                </div>

                <div class="reg-email-input {{ $errors->has('email') ? 'has-error' : '' }}">

                    <label for="reg-email" class="input-title">
                        Электронная почта
                        <span class="red-star">*</span>
                    </label>

                    <div class="input email">

                        <input id="reg-email" type="email" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))

                            <div class="error">
                                {{ $errors->first('email') }}
                            </div>

                        @endif

                    </div>

                </div>

                <div class="personal-data-checkbox">

                    <input type="checkbox" name="personal" value="1" required>
                    <div class="personal-data-links-string">
                        Ознакомлен с
                        <a href="{{ asset('policy') }}" target="_blank">Политикой конфиденциальности</a>
                        и
                        <a href="{{ asset('public-offer') }}" target="_blank">Договором публичной оферты</a>.
                        Даю согласие на обработку своих персональных данных.
                    </div>
                    
                </div>

                <div class="captcha-block" id="RecaptchaField4"></div>

                <input type="hidden" name="RecaptchaField4" data-conditional="captcha" required>

                <button class="submit-button" type="submit">
                    Регистрация
                </button>

                <div class="transfer-link js-login-open-form">
                    Войти
                </div>

            </form>

<script type="text/javascript">
    var CaptchaCallback4 = function() {
        grecaptcha.render('RecaptchaField4', {
            'sitekey' : '6LdcjQ8jAAAAACyYNiHrj2lyWJEiaUP5V5RLY1N8',
            'callback': verifyCallback4,
        });
   };

    var verifyCallback4 = function (response) {
        if (response.length > 0 && response != false) {
            $('input[name=RecaptchaField4]').val(1);
        }
    };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback4&render=explicit" async defer></script>
