<div
	class="popup-new-address js-new-address"
    data-page="{{ \Request::getPathInfo() }}"
	style="display: none;"
>
    
    <div class="popup-new-address_background js-popup-background"></div>

    <div class="popup-new-address_info-block">

        <div class="close-button js-popup-close-button">✕</div>

       	<h2>Добавление адреса</h2>

    	<form
    		method="POST"
    		action="{{ asset('cabinet/add-address') }}"
    		class="js-new-address-form"
    	>

			{{ csrf_field() }}

            <div class="data-block">
                <div class="title">
                    Получатель: (если отличается от Заказчика)
                </div>
                <div>
                    <input type="text" name="family_name" placeholder="Фамилия">
                </div>
                <div>
                    <input type="text" name="first_name" placeholder="Имя получателя">
                </div>
                <div>
                    <input type="text" name="second_name" placeholder="Отчество">
                </div>
            </div>

			<div class="data-block">

				<div class="title">
					Населенный пункт
					<span class="red-star">*</span>
				</div>

				<div class="input">
					<input type="text" name="city" required>
				</div>

			</div>

			<div class="data-block">

				<div class="title">
					Улица
					<span class="red-star">*</span>
				</div>

				<div class="input">
					<input type="text" name="street" required>
				</div>

			</div>

			<div class="data-block-wrapper">

				<div class="data-block">

					<div class="title">
						Дом
						<span class="red-star">*</span>
					</div>

					<div class="input">
						<input type="text" name="house" required>
					</div>

				</div>
				
				<div class="data-block">

					<div class="title">
						Корпус
					</div>

					<div class="input">
						<input type="text" name="corpus">
					</div>

				</div>

				<div class="data-block">

					<div class="title">
						Кв./Офис
					</div>

					<div class="input">
						<input type="text" name="flat">
					</div>

				</div>

				<div class="data-block">

					<div class="title">
						Подъезд
					</div>

					<div class="input">
						<input type="text" name="entrance">
					</div>

				</div>

				<div class="data-block">

					<div class="title">
						Этаж
					</div>

					<div class="input">
						<input type="text" name="floor">
					</div>

				</div>
				
			</div>

			@php
				if(\Request::getPathInfo() == '/cart') {
					$user_address = $user['address'];
				} else {
					$user_address = $user->address;
				}

				if($user_address->count() == 0) {
					$checkbox_val = 1;
					$checkbox_par = "checked disabled";
					$checkbox_str = "основной";
				} else {
					$checkbox_val = 0;
					$checkbox_par = "";
					$checkbox_str = "сделать основным";
				}
			@endphp

			<label class="checkbox-block js-new-address-checkbox">
				<input type="checkbox" name="main_address" {{ $checkbox_par }}>
				<input type="hidden" name="main" value="{{ $checkbox_val }}">
				<div class="checkbox-title js-checkbox-title">{{ $checkbox_str }}</div>
			</label>

            <button class="submit-button js-new-address-submit" type="submit">
                Сохранить
            </button>

    	</form>



    </div>


</div>

