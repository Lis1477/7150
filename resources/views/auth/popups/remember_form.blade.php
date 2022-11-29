            <form method="POST" action="{{ asset('password/send') }}" class="js-form js-remember-form" style="display: {{ $rem_style_par }};">
                {{ csrf_field() }}
                <input type="hidden" name="remember_form" value="1">

                <div class="{{ $errors->has('email') ? ' has-error' : '' }}">

                    <label for="rem-email" class="input-title">
                        Электронная почта
                        <span class="red-star">*</span>
                    </label>

                    <div class="input email">

                        <input id="rem-email" type="email" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))

                            <div class="error">
                                {{ $errors->first('email') }}
                            </div>

                        @endif

                    </div>

                </div>

                <button class="submit-button" type="submit">
                    Отправить пароль
                </button>

                <div class="transfer-link js-login-open-form">
                    Войти
                </div>

                <div class="transfer-link js-reg-open-form">
                    Регистрация
                </div>

            </form>
