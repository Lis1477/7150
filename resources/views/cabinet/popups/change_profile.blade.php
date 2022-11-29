<div class="popup-change-profile js-change-profile" style="display: none;">
    
    <div class="popup-change-profile_background js-popup-background"></div>

    <div class="popup-change-profile_info-block">

        <div class="close-button js-popup-close-button">✕</div>

       	<h2>Персональные данные</h2>

    	<form method="POST" action="{{ asset('cabinet/profile-edit') }}">

			{{ csrf_field() }}

			<div class="client-type-block">

				@php

					if($user->profile->client_type == "Юридическое лицо") {
						$individual_style = "none";
						$individual_input = "";
						$company_style = "block";
						$company_input = "checked";

					} else {
						$individual_style = "block";
						$individual_input = "checked";
						$company_style = "none";
						$company_input = "";
					}
				
				@endphp

				<label class="js-client">

					<div class="round-block">
						<div class="inner-round js-round" style="display: {{ $individual_style  }};"></div>
					</div>

					<input type="radio" name="client_type" value="individual" {{ $individual_input }}>

					<span class="title">Физическое лицо</span>

				</label>
				
				<label class="js-client">

					<div class="round-block">
						<div class="inner-round js-round" style="display: {{ $company_style }};"></div>
					</div>

					<input type="radio" name="client_type" value="company" {{ $company_input }}>

					<span class="title">Юридическое лицо</span>

				</label>

			</div>

			<div class="name-block data-block">
				<div class="title">
					Имя на сайте:
					<span class="red-star">*</span>
				</div>
				<input type="text" name="name" value="{{ \Auth::user()->name }}" required>
			</div>

			<div class="gender-block data-block">

				@php

					if($user->profile->gender == "Мужской") {
						$man_style = "block";
						$man_input = "checked";
						$woman_style = "none";
						$woman_input = "";
					} elseif($user->profile->gender == "Женский") {
						$man_style = "none";
						$man_input = "";
						$woman_style = "block";
						$woman_input = "checked";
					} else {
						$man_style = "none";
						$man_input = "";
						$woman_style = "none";
						$woman_input = "";
					}
				
				@endphp

				<div class="title">Пол:</div>

				<label class="js-gender">

					<div class="round-block">
						<div class="inner-round js-gender-round" style="display: {{ $man_style }};"></div>
					</div>

					<input type="radio" name="gender_type" value="man" {{ $man_input }}>

					<span class="title">Мужской</span>

				</label>
				
				<label class="js-gender">

					<div class="round-block">
						<div class="inner-round js-gender-round" style="display: {{ $woman_style }};"></div>
					</div>

					<input type="radio" name="gender_type" value="woman" {{ $woman_input }}>

					<span class="title">Женский</span>

				</label>

			</div>

			<div class="date-block data-block">
				<div class="title">Дата рождения:</div>
				<input type="date" name="birthday" value="{{ $user->profile->birthday }}">
			</div>

			<div class="phone-block data-block">
				<div class="title">Телефон(ы):</div>
				<div class="phones js-phones">

					@if($user->phones->count())

						@foreach($user->phones->sortByDesc('main') as $phone)

							@php
								if($user->phones->count() == 1 || $phone->main == 1) {
									$checkbox_input = "checked";
									$checkbox_title = "основной";
								} else {
									$checkbox_input = "";
									$checkbox_title = "сделать основным";
								}

							@endphp

							<div class="phone js-phone">

								<input type="tel" name="phone[]" value="{{ $phone->phone }}" class="phone-input js-phone-mask js-phone-input">

								<div class="checkbox-input-block">

									<input type="radio" name="main" value="{{ $phone->phone }}" class="js-main-phone" {{ $checkbox_input }}>

									<span class="checkbox-title js-checkbox-title">{{ $checkbox_title }}</span>

									<div class="phone-close-wrapper">
								        <div class="phone-close-button js-phone-close-button" title="Удалить телефон">✕</div>
								    </div>

								</div>

							</div>

						@endforeach

					@else

						<div class="phone js-phone">

							<input type="tel" name="phone[]" value="" class="phone-input js-phone-mask js-phone-input">

							<div class="checkbox-input-block">

								<input type="radio" name="main" class="js-main-phone" checked>

								<span class="checkbox-title js-checkbox-title">основной</span>

								<div class="phone-close-wrapper">
							        <div class="phone-close-button js-phone-close-button" title="Удалить телефон">✕</div>
								</div>

							</div>

						</div>

					@endif

				</div>

				<div class="add-phone js-add-phone">добавить номер</div>

			</div>

			<div class="email-block data-block">
				<div class="title">
					Email:
					<span class="red-star">*</span>
				</div>
				<input type="email" name="email" value="{{ \Auth::user()->email }}" required>
			</div>

			<div class="requisites-block js-requisites" style="display: {{ $company_style }};">

				<div class="company-name-block data-block">
					<div class="title">Наименование организации:</div>
					<input type="text" name="company_name" value="{{ $user->profile->company_name }}">
				</div>
				
				<div class="unp-block data-block">
					<div class="title">УНП:</div>
					<input type="text" name="company_unp" value="{{ $user->profile->unp }}">
				</div>

				<div class="requisites-block data-block">
					<div class="title">Реквизиты:</div>

					@php
						if($user->profile->requisites){
							$requisites = $user->profile->requisites;
						} else {
							$requisites = "Расчетный счет: 
Банк: 
Код банка: 
Адрес банка: 
ФИО руководителя: 
Должность руководителя: 
Действует на основании: ";
						}
					@endphp

					<textarea name="requisites">{{ $requisites }}</textarea>

				</div>

			</div>

			<div class="password-block">

				<div class="password-first data-block">

					<div class="title">Смена пароля (минимум 6 знаков):</div>

					<input type="password" name="password">

	                <div class="eye-toggler js-eye-toggler">

	                    <div class="eye-closed js-eye-closed">
	                        @include('svg.eye_closed')
	                    </div>

	                    <div class="eye-opened js-eye-opened toggled">
	                        @include('svg.eye_opened')
	                    </div>

	                </div>
					
				</div>

				<div class="password-second data-block js-password-second" style="display: none;">

					<div class="title js-confirm-string">
						Подтвердите пароль:
					</div>

					<input type="password" name="password_confirm">

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

            <button class="submit-button js-personal-submit" type="submit">
                Сохранить
            </button>

    	</form>



    </div>


</div>

