<script type="text/javascript">

	// открываем окно редактирования адреса
	$('.js-cart-change-address').on('click', function(){

		// скрываем всплывающее окно списка адресов
		$('.js-view-address').fadeOut();

		// открываем окно редактирования адреса
		var popup = $('.js-change-address');
		popup.fadeIn();

		// почистим кэш
		$(this).parents('.js-address-block').removeData();

		// берем блок с адресом
		var address_block = $(this).parents('.js-address-block');
		// берем данные для вставки
		var address_id = address_block.data('id');
		var first_name = address_block.data('first_name');
		var second_name = address_block.data('second_name');
		var family_name = address_block.data('family_name');
		var city = address_block.data('city');
		var street = address_block.data('street');
		var house = address_block.data('house');
		var flat = address_block.data('flat');
		var corpus = address_block.data('corpus');
		var entrance = address_block.data('entrance');
		var floor = address_block.data('floor');
		var main = address_block.data('main');

		// заполняем value инпутов
		popup.find('input[name=address_id]').val(address_id);
		popup.find('input[name=first_name]').val(first_name);
		popup.find('input[name=second_name]').val(second_name);
		popup.find('input[name=family_name]').val(family_name);
		popup.find('input[name=city]').val(city);
		popup.find('input[name=street]').val(street);
		popup.find('input[name=house]').val(house);
		popup.find('input[name=flat]').val(flat);
		popup.find('input[name=corpus]').val(corpus);
		popup.find('input[name=entrance]').val(entrance);
		popup.find('input[name=floor]').val(floor);

		if(main == 1) {
			popup.find('input[name=main_address]').attr('checked', true).attr('disabled', 'disabled');
			popup.find('input[name=main]').val('1');
			popup.find('.js-checkbox-title').text('основной');
		} else {
			popup.find('input[name=main_address]').attr('checked', false).removeAttr('disabled');
			popup.find('input[name=main]').val('0');
			popup.find('.js-checkbox-title').text('сделать основным');
		}
	});

	// обработка кнопки Вставить
	$('.js-insert-address').on('click', function(){

		// почистим кэш
		$(this).parents('.js-address-block').removeData();

		// берем блок с адресом
		var address_block = $(this).parents('.js-address-block');

		// берем данные для вставки
		var first_name = address_block.data('first_name');
		var second_name = address_block.data('second_name');
		var family_name = address_block.data('family_name');
		var city = address_block.data('city');
		var street = address_block.data('street');
		var house = address_block.data('house');
		var flat = address_block.data('flat');
		var corpus = address_block.data('corpus');
		var entrance = address_block.data('entrance');
		var floor = address_block.data('floor');

		// вставляем в инпуты
		$('input[name=first_name]').val(first_name);
		$('input[name=second_name]').val(second_name);
		$('input[name=family_name]').val(family_name);
		$('input[name=city]').val(city);
		$('input[name=street]').val(street);
		$('input[name=house]').val(house);
		$('input[name=flat]').val(flat);
		$('input[name=corpus]').val(corpus);
		$('input[name=entrance]').val(entrance);
		$('input[name=floor]').val(floor);

		// скрываем всплывающее окно
		$('.js-view-address').fadeOut();
	});

	// удаляем адрес
	$('.js-cart-del-address').on('click', function(){

		// берем блок с адресом
		var address_block = $(this).parents('.js-address-block');

		// берем id адреса
		var address_id = address_block.data('id');

		// берем статус адреса
		var address_main = address_block.data('main');

		// если адрес не главный
		if(address_main != 1) {
			// берем токен
			var token = $('input[name=_token]').val();

			// запрос на удаление
	        $.ajax({
	            type: 'post',
	            url: "/cabinet/del-address",
	            data: {
	                'address_id': address_id,
	                '_token': token,
	            },
	            success: function(data){
	            	if(data == true) {
	            		// удаляем блок с адресом
	            		address_block.remove();

						// почистим кэш
						address_block.removeData();

	            	} else {
	            		console.log('не удалил');
	            	}
	            },
	        });
		}

	});

</script>

@foreach($addresses as $address)

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
