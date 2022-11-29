<div class="popup-view-address js-view-address" style="display: none;">
    
    <div class="popup-view-address_background js-popup-background"></div>

    <div class="popup-view-address_info-block">

        <div class="close-button js-popup-close-button">✕</div>

       	<h2>Ваши адреса</h2>

		@if(isset($user) && $user['address']->count())

			<div class="address-wrapper js-address-wrapper">

				@foreach($user['address'] as $address)

					<div
						class="address-block js-address-block"
						data-id="{{ $address->id }}"
						data-first_name="{{ $address->first_name }}"
						data-second_name="{{ $address->second_name }}"
						data-family_name="{{ $address->family_name }}"
						data-city="{{ $address->city }}"
						data-street="{{ $address->street }}"
						data-house="{{ $address->house }}"
						data-flat="{{ $address->flat }}"
						data-corpus="{{ $address->corpus }}"
						data-entrance="{{ $address->entrance }}"
						data-floor="{{ $address->floor }}"
						data-main="{{ $address->main }}"
					>

						@php
							// формируем адресную строку
							$address_str = "{$address->city}, ул. {$address->street}, дом. {$address->house}";
							if($address->corpus) {
								$address_str .= ", кор. {$address->corpus}";
							}
							if($address->flat) {
								$address_str .= ", кв. {$address->flat}";
							}
							if($address->entrance) {
								$address_str .= ", под. {$address->entrance}";
							}
							if($address->floor) {
								$address_str .= ", эт. {$address->floor}";
							}
							$address_str .= ".";

							if($address->first_name || $address->second_name || $address->family_name) {
								$address_str .= "<br><span class='recipient-title'>Получатель:</span> {$address->family_name} {$address->first_name} {$address->second_name}.";
							}

							// отображение чекбокса и кнопки Удалить
							if($address->main == 1) {
								$checkbox_disp = "flex";
								$del_butt_disp = "none";
							} else {
								$checkbox_disp = "none";
								$del_butt_disp = "block";
							}

						@endphp

						<div class="js-address-{{ $address->id }}">
							{!! $address_str !!}
						</div>

						<div class="main-address js-view_addr_checkbox" style="display: {{ $checkbox_disp }};">
							<input type="checkbox" name="main" value="1" checked disabled>
							<span class="js-view_addr_checkbox_title">основной</span>
						</div>

						<div class="manipulate-block">

							<div class="link insert-address js-insert-address" title="Вставить адрес">
								Вставить
							</div>

							<div class="link change-address js-cart-change-address" title="Изменить адрес">
								Изменить
							</div>

							<div class="link del-address js-cart-del-address" title="Удалить адрес" style="display: {{ $del_butt_disp }};">
								Удалить
							</div>

						</div>
						
					</div>

				@endforeach

			</div>

		@endif

		<div class="add-address-link js-cart-new-address">
            Добавить адрес
        </div>

    </div>

</div>

