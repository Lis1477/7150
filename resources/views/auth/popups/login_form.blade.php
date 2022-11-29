            <form method="POST" action="{{ route('login') }}" class="js-form js-login-form" style="display: {{ $login_style_par }};">

                {{ csrf_field() }}
                <input type="hidden" name="login_form" value="1">

                <div class="{{ $errors->has('email') ? 'has-error' : '' }}">

                    <label for="log-email" class="input-title">
                        Электронная почта
                        <span class="red-star">*</span>
                    </label>

                    <div class="input email">

                        <input id="log-email" type="email" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))

                            <div class="error">
                                {{ $errors->first('email') }}
                            </div>

                        @endif

                    </div>

                </div>

                <div class="password-input-block {{ $errors->has('password') ? 'has-error' : '' }}">

                    <label for="log-password" class="input-title">
                        Пароль
                        <span class="red-star">*</span>
                    </label>

                    <div class="input pass">

                        <input id="log-password" type="password" name="password" required>

                        @if ($errors->has('password'))

                            <div class="error">
                                {{ $errors->first('password') }}
                            </div>

                        @endif

                        <div class="eye-toggler js-eye-toggler">

                            <div class="eye-closed js-eye-closed">
                                @include('svg.eye_closed')
                            </div>

                            <div class="eye-opened js-eye-opened toggled">
                                @include('svg.eye_opened')
                            </div>

                        </div>

                    </div>

                </div>

                <div class="remember-block">

{{--                     <div class="remember-checkbox">

                        <label>
                            <input type="checkbox" name="remember" checked>
                            <span>Запомнить меня</span>
                        </label>
                        
                    </div>
 --}}
                    <div class="forgot-pass-link js-remember-open-form">
                        Я не помню пароль
                    </div>

                </div>

                <button class="submit-button" type="submit">
                    Войти
                </button>

                <div class="transfer-link js-reg-open-form">
                    Регистрация
                </div>

            </form>
