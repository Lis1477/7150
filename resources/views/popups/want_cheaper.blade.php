<div class="popup-want-cheaper js-want-cheaper" style="display: none;">
    
    <div class="popup-want-cheaper_background js-want-cheaper-background"></div>

    <div class="popup-want-cheaper_info-block">

        <div class="close-button js-popup-close-button">✕</div>

       	<h2>Хочу дешевле</h2>

        <div class="popup-want-cheaper_form-block">

        	<div class="description">
        		<p>Вы нашли такой же товар дешевле, но хотите приобрести его именно у нас? Оставьте контактные данные и наш специалист всё с Вами обсудит. Также Вы можете указать ссылку с ожидаемой ценой.</p>
        		<p>Рабочее время Отдела Продаж пн-пт с 09:00 до 17:30, сб-вс выходной.</p>
        	</div>

        	<form id="captcha-validate-3" method="post" action="{{ asset('want-cheaper') }}">
	       		{{ csrf_field() }}
	       		<input type="hidden" name="item_name" value="">

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
		            	></textarea>
		            </div>
	       		</div>

	       		<div class="captcha-block" id="RecaptchaField3"></div>

				<input type="hidden" name="RecaptchaField3" data-conditional="captcha" required>

				<button class="submit-button" type="submit">
				    Отправить
				</button>

        	</form>
        	
        </div>

    </div>

</div>

<script type="text/javascript">
    var CaptchaCallback3 = function() {
        grecaptcha.render('RecaptchaField3', {
        	'sitekey' : '6LdcjQ8jAAAAACyYNiHrj2lyWJEiaUP5V5RLY1N8',
        	'callback': verifyCallback3,
        });
   };

    var verifyCallback3 = function (response) {
        if (response.length > 0 && response != false) {
            $('input[name=RecaptchaField3]').val(1);
        }
    };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback3&render=explicit" async defer></script>
