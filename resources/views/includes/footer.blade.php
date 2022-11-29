<footer>

{{-- 	<div class="footer_subscribe-block">
		
		<div class="container">
			
			<div class="footer_subscribe-header">
				Лучшие предложения у вас в почте
			</div>

			<form class="footer_subscribe-form">
				<input type="email" name="email" placeholder="Ваш E-mail" required>
				<input type="submit" name="subscribe" value="ПОДПИСАТЬСЯ">
			</form>
		</div>

	</div> --}}

	<div class="footer_links-block">
		
		<div class="container">

			<div class="footer_links-element about">

				<h3>Каталог</h3>

				<a href="{{ asset('/category/7024/stroitelnoe-oborudovanie') }}">Строительное оборудование</a>
				<a href="{{ asset('/category/4585/sadovaya-tekhnika') }}">Садовая техника</a>
				<a href="{{ asset('/category/4667/svarochnoe-oborudovanie-i-materialy') }}">Сварочное оборудование</a>
				<a href="{{ asset('/category/2202/pnevmooborudovanie') }}">Пневмооборудование</a>
				<a href="{{ asset('/category/6032/elektroinstrument-i-prinadlezhnosti') }}">Электроинструмент</a>
				<a href="{{ asset('/category/16305/sredstva-individualnoy-zashchity-i-spetsodezhda') }}">Средства индивидуальной защиты</a>
				<a href="{{ asset('/category/12710/raskhodnye-materialy') }}">Расходные материалы</a>
				<a href="{{ asset('/category/16188/khoztovary') }}">Хозтовары</a>
				<a href="{{ asset('/category/16821/bytovaya-khimiya') }}" class="last">Бытовая Химия</a>



			</div>
			
			<div class="footer_links-element garant">

				<h3>О магазине</h3>

				<a href="{{ asset('page/o-nas') }}">О нас</a>
				<a href="{{ asset('brands') }}">Бренды</a>
				<a href="{{ asset('novosty') }}">Новости</a>
				<a href="https://www.youtube.com/c/SkiperALFA" target="_blank">Видеообзоры</a>
				<a href="{{ asset('page/kontakty') }}">Контакты</a>
				<a href="{{ asset('page/dostavka') }}">Доставка</a>
				<a href="{{ asset('page/dogovor-publichnoy-oferty') }}" class="last">Договор публичной оферты</a>

			</div>

			<div class="footer_links-element delivery">

				<h3>Гарантия и сервис</h3>

				<a href="{{ asset('page/garantiya') }}">Гарантийные обязательства</a>
				<a href="{{ asset('page/servisniye-tsentry') }}" class="last">Сервисные центры</a>

				<h3>Оплата</h3>

				<a href="{{ asset('page/oplata') }}">Способы оплаты</a>
				<a href="{{ asset('page/oplata-dlia-yur-lits') }}" class="last">Для юридических лиц</a>

			</div>

			<div class="footer_links-element">

				<div class="footer_commone-phone">
					Единый мобильный номер -
					<a href="tel:7150">7150</a>
					<div>*бесплатный для всех операторов</div>
				</div>

				<div class="footer_orders-accepting">Заказы через сайт принимаются круглосуточно <span>24/7</span></div>

				<div class="footer_working-time"><strong>Режим работы</strong><br>
					Пн-Пт: 9.00-17.30<br>
					Сб-Вс: выходной
				</div>

				<div class="footer_contact-header"><strong>Контакты</strong></div>

				<div class="footer_phone">
					<img src="{{ asset('img/a1_ico.png') }}" alt="a1 ico">
					<a href="tel:+375296867150">+375 29 686 71 50</a>
				</div>

				<div class="footer_phone">
					<img src="{{ asset('img/mts_ico_2.png') }}" alt="mts ico">
					<a href="tel:+375336867150">+375 33 686 71 50</a>
				</div>

				<div class="footer_phone">
					<img src="{{ asset('img/life_ico.png') }}" alt="beltelecom ico">
					<a href="tel:+375256667150">+375 25 666 71 50</a>
				</div>


			</div>

			<div class="footer_links-element">
				
				<div class="footer_call-order">
					@include('svg.phone')
					<a href="#" class="js-feedback-button">Заказать звонок</a>
				</div>

				<div class="footer_mailing">
					@include('svg.mail')
					<a href="#" class="js-feedback-button">Написать сообщение</a>
				</div>

				<div class="footer_social-links-header">Присоединяйтесь к нам в социальных сетях</div>

				<div class="footer_social-links">

					<a href="https://www.instagram.com/katana.by/" target="_blank">
						<img src="{{ asset('img/insta_ico.png') }}" alt="ok ico" title="Мы в Instagram">
					</a>

					<a href="https://ok.ru/alfabelarus" target="_blank">
						<img src="{{ asset('img/ok_ico.png') }}" alt="ok ico" title="Мы в Одноклассниках">
					</a>

					<a href="https://vk.com/alfabelarus" target="_blank">
						<img src="{{ asset('img/vk_ico.png') }}" alt="vk ico" title="Мы ВКонтакте">
					</a>

					<a href="https://www.facebook.com/AlfaBelarus/" target="_blank">
						<img src="{{ asset('img/facebook_ico.png') }}" alt="facebook ico" title="Мы в Facebook">
					</a>

					<a href="https://www.youtube.com/c/SkiperALFA" target="_blank">
						<img src="{{ asset('img/youtube_ico.png') }}" alt="youtube ico" title="Мы в Youtube">
					</a>

					<a href="https://twitter.com/alfabelarus" title="_blank">
						<img src="{{ asset('img/twitter_ico.png') }}" alt="twitter ico" title="Мы в Twitter">
					</a>

				</div>

				<div class="footer_pay-systems-bl-1">

					<img src="{{ asset('img/verified_by_visa.png') }}" alt="verified_by_visa">
					<img src="{{ asset('img/master_card_secure_code.png') }}" alt="master_card_secure_code">
					
				</div>

				<div class="footer_pay-systems-bl-2">

					<img src="{{ asset('img/mastercard.png') }}" alt="mastercard">
					<img src="{{ asset('img/maestro.png') }}" alt="maestro">
					<img src="{{ asset('img/belkart.png') }}" alt="belkart">
					<img src="{{ asset('img/bepaid.png') }}" alt="bepaid">
					
				</div>

			</div>

		</div>

	</div>

	<div class="footer_info-block">
		
		<div class="container">

			<div class="footer_info-block_line-1">
				
				<div class="footer_info-block_requisites">
					<p>Общество с ограниченной ответственностью "Альфасад", УНП 192987077</p>
					<p>Свидетельство о регистрации от 24.10.2017 Минским Горисполкомом</p>
					<p>Магазин зарегистрирован в Торговом реестре Республики Беларусь от 15.01.2018 №402553</p>
				</div>

				<div class="footer_info-block_notice">
					Продолжая работу с сайтом, вы даете согласие на использование сайтом cookies и <a href="#">обработку персональных данных</a> в целях функционирования сайта, проведения ретаргетинга, статистических исследований, улучшения сервиса и предоставления релевантной рекламной информации на основе ваших предпочтений и интересов.
				</div>

			</div>

			<div class="footer_info-block_line-2">

				<div>
					<div class="footer_info-block_permission">
						Частичное или полное копирование любых материалов сайта возможно только с указанием ссылки на первоисточник
					</div>

					<div class="footer_info-block_mail-to">
						E-mail:
						<a href="mailto:{{ config('email')['common_email'] }}">
							{{ config('email')['common_email'] }}
						</a>
					</div>
				</div>

				<div class="footer_info-block_copyright">
					© ООО "Альфасад" {{ date('Y') }}
				</div>

			</div>
		</div>

	</div>

</footer>
