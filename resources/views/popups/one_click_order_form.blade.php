<div class="popup-one-click-order js-one-click-order" style="display: none;">
    
    <div class="popup-one-click-order_background js-popup-background"></div>

    <div class="popup-one-click-order_info-block">

        <div class="close-button js-popup-close-button">✕</div>

       	<h2>Заказ в 1 клик</h2>

       	<div class="item-title">
       		Выбран товар:<br>
       		<span class="item-name js-item-name"></span>
       	</div>

       	<form method="post" action="{{ asset('one-click-order') }}">
       		{{ csrf_field() }}
       		<input type="hidden" name="item_id_1c" value="">
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
	                {{-- <span class="red-star">*</span> --}}
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
	                Коментарий
	            </label>

	            <div class="textarea">
	            	<textarea name="comment"></textarea>
	            </div>
       		</div>

			<button class="submit-button" type="submit">
			    Отправить заказ
			</button>
       	</form>


    </div>

</div>

