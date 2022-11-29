<div class="cabinet-menu_links-block">

	<a
		href="{{ asset('cabinet/profile') }}"
		class="@if(\Route::currentRouteName() == 'view-profile'){{ 'active' }}@endif"
	>
		Профиль
	</a>

	<a
		href="{{ asset('cabinet/history') }}"
		class="@if(\Route::currentRouteName() == 'view-history'){{ 'active' }}@endif"
	>
		История покупок
	</a>

</div>