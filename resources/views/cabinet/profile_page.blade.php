@extends('layouts.base')

@section('content')

<div class="profile-page">
	<div class="container">

		@include('cabinet.includes.cabinet_menu')

		<h1>Профиль покупателя</h1>

		<div class="profile-page_wrapper">

			<div class="profile-page_personal-data-block">

				<div class="header-line">

					<h2>Персональные данные</h2>

					<div class="delimiter">|</div>

					<div class="change-link js-open-change-profile" title="Изменить личные данные">Изменить</div>
					
				</div>

				<div class="info-line">
					<div class="title">Клиент:</div>
					<div class="info">{{ $user->profile->client_type }}</div>
				</div>

				<div class="info-line">
					<div class="title">Имя:</div>
					<div class="info">{{ $user->name }}</div>
				</div>

				<div class="info-line">
					<div class="title">Пол:</div>
					<div class="info">
						@if($user->profile->gender){{ $user->profile->gender }}@else{{ '&mdash;' }}@endif
					</div>
				</div>

				<div class="info-line">
					<div class="title">Дата рождения:</div>
					<div class="info">
						@if($user->profile->birthday){{ date('d.m.Y', strtotime($user->profile->birthday)) }}@else{{ '&mdash;' }}@endif
					</div>
				</div>

				<div class="phones-block">
					<div class="title">Телефон(ы):</div>
					<div class="phones">

						@if($user->phones->count())

							@foreach($user->phones->sortByDesc('main') as $phone)

								<div class="phone">
									{{ $phone->phone }}

									@if($phone->main == 1)

										<input type="checkbox" checked disabled>

										<span class="checkbox-title">основной</span>

									@endif

								</div>

							@endforeach

						@else

							{{ '&mdash;' }}

						@endif

					</div>
				</div>

				<div class="info-line">
					<div class="title">Email:</div>
					<div class="info">{{ $user->email }}</div>
				</div>

				<div
					class="requisites-block"
					style="display: @if($user->profile->client_type == "Юридическое лицо"){{ 'block' }}@else{{ 'none' }}@endif;"
				>

					<div class="info-line">
						<div class="title">Наименование организации:</div>
						<div class="info">
							@if($user->profile->company_name){{ $user->profile->company_name }}@else{{ '&mdash;' }}@endif
						</div>
					</div>
					
					<div class="info-line">
						<div class="title">УНП:</div>
						<div class="info">
							@if($user->profile->unp){{ $user->profile->unp }}@else{{ '&mdash;' }}@endif
						</div>
					</div>

					<div class="info-line">
						<div class="title">Реквизиты:</div>
						<div class="info">
							<pre>@if($user->profile->requisites){{ $user->profile->requisites }}@else{{ '&mdash;' }}@endif</pre>
						</div>
					</div>

				</div>

			</div>

			<div class="profile-page_addresses-block">
				
				<div class="header-line">

					<h2>Адрес(а) для доставки</h2>

				</div>

				@if($user->address->count())

					@foreach($user->address->sortByDesc('main') as $address)

						<div class="address-wrapper js-address-wrapper">

							<div class="address-block">

								<div class="address">
									{{ $address->city }},
									ул. {{ $address->street }},
									дом. {{ $address->house }},
									@if($address->corpus){{ "кор. ".$address->corpus.","}}@endif
									@if($address->flat){{ "кв. ".$address->flat.","}}@endif
									@if($address->entrance){{ "под. ".$address->entrance.","}}@endif
									@if($address->floor){{ "эт. ".$address->floor.","}}@endif

									@if($address->first_name || $address->second_name || $address->family_name)

										получатель:
										{{ $address->family_name }}
										{{ $address->first_name }}
										{{ $address->second_name }}

									@endif

								</div>
								
							</div>

							<div class="manipulate-block">
								<div
									class="change-link js-open-change-address"
									title="Изменить адрес"
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
									Изменить
								</div>

								@if($address->main == 1)

									<div class="main-address">
										<input type="checkbox" name="main" value="{{ $address->id }}" checked disabled>
										<span>основной</span>
									</div>

								@endif

							</div>

							@if($address->main != 1)

								<div
									class="del-address js-del-address"
									title="Удалить адрес"
									data-id="{{ $address->id }}"
								>
									✕
								</div>

							@endif

						</div>

					@endforeach

				@endif



				<div class="add-address-link js-open-new-address">Добавить адрес</div>

			</div>

		</div>

	</div>
</div>

@include('cabinet.popups.change_profile')
@include('cabinet.popups.new_address')
@include('cabinet.popups.change_address')

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('js/cabinet.js') }}"></script>

@endsection