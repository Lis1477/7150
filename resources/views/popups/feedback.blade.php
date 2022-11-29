<div class="popup-feedback js-feedback" style="display: none;">
    
    <div class="popup-feedback_background js-feedback-background"></div>

    <div class="popup-feedback_info-block">

        <div class="close-button js-popup-close-button">✕</div>

       	<h2>Обратная связь</h2>

        <div class="navigate-line">
        	<div class="link js-link js-call-back-link">Заказать звонок</div>
        	<div class="link js-link js-mail-to-us-link">Написать сообщение</div>
        </div>

        <div class="popup-feedback_callback-form-block js-form js-call-back-form" style="display: none;">

        	<div class="description">
        		<p>Нужна консультация? Закажите обратный звонок и мы свяжемся с Вами в удобное для Вас время.</p>
        		<p>Рабочее время Отдела Продаж пн-пт с 09:00 до 17:30, сб-вс выходной.</p>
        	</div>

        	<form id="captcha-validate-1" method="post" action="{{ asset('callback') }}">
	       		{{ csrf_field() }}

	       		<div class="input-block">
		            <label for="client_name" class="input-title">
		                Имя
		                <span class="red-star">*</span>
		            </label>

		            <div class="input">
		                <input
		                	id="client_name"
		                	type="text"
		                	name="client_name"
		                	value="@if(Auth::check()){{ Auth::user()->name }}@endif"
		                	required
		                >
		            </div>
	       		</div>

	       		<div class="input-block">
		            <label for="phone" class="input-title">
		                Телефон
		                <span class="red-star">*</span>
		            </label>

		            <div class="input">
		                <input
		                	id="phone"
		                	class="phone"
		                	type="tel"
		                	name="client_phone"
		                	value="@if(Auth::check() && Auth::user()->phones->count()){{ Auth::user()->phones[0]->phone }}@endif"
		                	required
		                >
		            </div>
	       		</div>

	       		<div class="input-block">
		            <label for="time" class="input-title">
		                Время звонка
		            </label>

		            <div class="select-block">
		            	<select id="time" name="first_time">
		            		<option value="9:00" selected>9:00</option>
		            		<option value="10:00">10:00</option>
		            		<option value="11:00">11:00</option>
		            		<option value="12:00">12:00</option>
		            		<option value="13:00">13:00</option>
		            		<option value="14:00">14:00</option>
		            		<option value="15:00">15:00</option>
		            		<option value="16:00">16:00</option>
		            		<option value="17:00">17:00</option>
		            	</select>
		            	—
		            	<select name="second_time">
		            		<option value="10:00">10:00</option>
		            		<option value="11:00">11:00</option>
		            		<option value="12:00">12:00</option>
		            		<option value="13:00">13:00</option>
		            		<option value="14:00">14:00</option>
		            		<option value="15:00">15:00</option>
		            		<option value="16:00">16:00</option>
		            		<option value="17:00">17:00</option>
		            		<option value="17:30" selected>17:30</option>
		            	</select>
		            </div>
	       		</div>

	       		<div class="input-block">
		            <label for="comment" class="input-title">
		                Комментарий
		            </label>

		            <div class="textarea">
		            	<textarea
			            	id="comment"
		            		name="comment"
		            		placeholder="Опишите тему звонка, чтобы наш специалист подготовился"
		            	></textarea>
		            </div>
	       		</div>

				<div class="captcha-block" id="RecaptchaField1"></div>

				<input type="hidden" name="RecaptchaField1" data-conditional="captcha" required>

				<button class="submit-button" type="submit">
				    Отправить
				</button>

        	</form>
        	
        </div>

        <div class="popup-feedback_callback-form-block js-form js-mail-to-us-form" style="display: none;">

        	<div class="description">
        		<p>Хотите предложить идею, задать вопрос, получить консультацию? Отправьте сообщение, мы обязательно ответим!</p>
        	</div>

        	<form id="captcha-validate-2" method="post" action="{{ asset('feedback') }}">
	       		{{ csrf_field() }}

	       		<div class="input-block">
		            <label for="client_name" class="input-title">
		                Имя
		                <span class="red-star">*</span>
		            </label>

		            <div class="input">
		                <input
		                	id="client_name"
		                	class="js-phone-mask js-phone-input"
		                	type="text"
		                	name="client_name"
		                	value="@if(Auth::check()){{ Auth::user()->name }}@endif"
		                	required
		                >
		            </div>
	       		</div>

	       		<div class="input-block">
		            <label for="phone" class="input-title">
		                Телефон
		                <span class="red-star">*</span>
		            </label>

		            <div class="input">
		                <input
		                	id="phone"
		                	class="phone"
		                	type="tel"
		                	name="client_phone"
		                	value="@if(Auth::check() && Auth::user()->phones->count()){{ Auth::user()->phones[0]->phone }}@endif"
		                	required
		                >
		            </div>
	       		</div>

	       		<div class="input-block">
		            <label for="client_email" class="input-title">
		                E-mail
		            </label>

		            <div class="input">
		                <input
		                	id="client_email"
		                	type="email"
		                	name="client_email"
		                	value="@if(Auth::check()){{ Auth::user()->email }}@endif"
		                >
		            </div>
	       		</div>

	       		<div class="input-block">
		            <label for="client_phone" class="input-title">
		                Сообщение
		            </label>

		            <div class="textarea">
		            	<textarea name="comment"></textarea>
		            </div>
	       		</div>

	       		<div class="captcha-block" id="RecaptchaField2"></div>

				<input type="hidden" name="RecaptchaField2" data-conditional="captcha" required>

				<button class="submit-button" type="submit">
				    Отправить
				</button>

        	</form>
        	
        </div>

    </div>

</div>

<script type="text/javascript">
    var CaptchaCallback1 = function() {
        grecaptcha.render('RecaptchaField1', {
        	'sitekey' : '6LdcjQ8jAAAAACyYNiHrj2lyWJEiaUP5V5RLY1N8',
        	'callback': verifyCallback1,
        });
   };

    var CaptchaCallback2 = function() {
       grecaptcha.render('RecaptchaField2', {
        	'sitekey' : '6LdcjQ8jAAAAACyYNiHrj2lyWJEiaUP5V5RLY1N8',
        	'callback': verifyCallback2,
        });
    };

    var verifyCallback1 = function (response) {
        if (response.length > 0 && response != false) {
            $('input[name=RecaptchaField1]').val(1);
        }
    };
    var verifyCallback2 = function (response) {
        if (response.length > 0 && response != false) {
            $('input[name=RecaptchaField2]').val(1);
        }
    };

</script>
<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback1&render=explicit" async defer></script>
<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback2&render=explicit" async defer></script>
