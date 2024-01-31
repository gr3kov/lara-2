@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css') !!}" rel="stylesheet">
	<link href="{!! asset('./css/jquery-ui.min.css') !!}" rel="stylesheet">
	<link href="{!! asset('./css/styles.css') !!}" rel="stylesheet">
	<link href="{!! asset('./css/referal.css') !!}" rel="stylesheet">
	<link href="{!! asset('./css/slick.css') !!}" rel="stylesheet">
	<link href="{!! asset('./css/swiper-bundle.min.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
	<script src="{!! asset('./js/jquery-3.6.2.min.js') !!}" type="text/javascript"></script>
	<script src="{!! asset('./js/itc__slider.js') !!}" type="text/javascript"></script>
	<script src="{!! asset('./js/jquery-ui.min.js') !!}" type="text/javascript"></script>
	<script src="{!! asset('./js/slick.min.js') !!}" type="text/javascript"></script>
	<script src="{!! asset('./js/script.js') !!}" type="text/javascript"></script>
	<script src="{!! asset('./js/referals.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<section class="page" id="referal">
		<h1 class="page__heading">{{ $title }}</h1>
		<nav class="page__navigation">
			<button class="page__tab-btn is-active" for="referal_main">Партнерская программа</button>
			<button class="page__tab-btn" for="referal_about">
				<img src="img/lock.svg" alt=""> О партнерской программе
			</button>
		</nav>
		<section class="page__tab" id="referal_main">
			<article class="row1">
				<div class="row1__col1 row__col">
					<div class="wrap">
						<div class="user-wrap">
							<div class="row1__col1__user-avatar-wrapper user-avatar-wrapper">
                                @if($user->photo == null)
                                    <img src="{{asset("/img/avatar.png")}}" alt="Ava" class="user-avatar">
                                @else
                                    <img src="{{asset("storage/" . $user->photo)}}" alt="Ava" class="user-avatar">
                                @endif
							</div>
							<p class="user-id">{{ $user->id }}</p>
						</div>
						<div class="status-label is-disabled">Не верифицирован</div>
					</div>
					<a href="{{ route('settings') }}" class="gray-btn">Настройки</a>
				</div>
				<div class="balance">
					<div class="balance__wrapper">
						<div class="balance__left">
							<div class="balance__icon">
								<img src="./img/icons/wallet.svg" alt="wallet">
							</div>
							<div class="balance__info">
								<p>Баланс</p>
								<p class="grey-text">{{$user->bid}} FLAMES</p>
							</div>
						</div>
						<div class="balance__right">
							<button id="balance__setting">
								<img src="./img/icons/setting.svg" alt="">
							</button>
						</div>
					</div>
					<div class="action-modal__placeSingleButton">
						<button class="gray-btn action-modal__info__btn singleButton" id="balance-action-btn">
							Вывести
						</button>
					</div>
				</div>
				<div class="row1__col2 row__col">
					<div class="row1__col2__img">
						<img src="/img/magichat.png" alt="">
					</div>
					<div class="row1__col2__text">
						<p style="font-size: 20px; line-height: 2; display: flex; align-items: start;">
							Партнёр
							<span class="tooltip">
							<span class="tooltip-text">Краткое пояснение к<br>какому-либо элементу.<br>Использовать тег br.
							</span>
							</span>
						</p>
						<p style="font-size: 12px; color: rgba(255, 255, 255, 0.4);">20% от лично приглашенных</p>
					</div>
					<div class="row1__col2__status">Статус</div>
				</div>
			</article>

			<article class="row2">
				<div class="row2__col1 row2__col row__col">
					<div class="row2__col__block1">
						<div class="row2__col__img">
							<img src="/img/icons/phone.svg" alt="">
						</div>
						<div class="row2__col__text">
							<p class="row2__col__key">Телефон</p>
							<p class="row2__col__value">{{$user->phone}}</p>
						</div>
						<div class=" status-label is-enabled">Подтвержден
						</div>
					</div>
					<div class="row2__col__block2">
						<a href="##" class="gray-btn row2__col__gray-btn">Подтвердить</a>
					</div>
				</div>
				<div class="row2__col2 row2__col row__col">
					<div class="row2__col__block1">
						<div class="row2__col__img">
							<img src="/img/icons/email.svg" alt="">
						</div>
						<div class="row2__col__text">
							<p class="row2__col__key">E-mail</p>
							<p class="row2__col__value">{{$user->email}}</p>
						</div>
						<div class="status-label is-disabled">Не подтвержден</div>
					</div>
					<div class="row2__col__block2">
						<div class="line-separator"></div>
						<p class="system-msg">Письмо для подтверждения было направлено на почту
							<span class="tooltip">
																						<span class="tooltip-text">Краткое пояснение к<br>какому-либо
																								элементу.<br>Использовать тег br.
																						</span>
																				</span>
						</p>
					</div>
				</div>
				<div class="row2__col3 row2__col row__col">
					<div class="row2__col__block1">
						<div class="row2__col__img">
							<img src="/img/icons/creditcard.svg" alt="">
						</div>
						<div class="row2__col__text">
							<p class="row2__col__key">Карта для вывода</p>
							<p class="row2__col__value"></p>
						</div>
						<div class="status-label is-disabled">Не задана</div>
					</div>
					<div class="row2__col__block2">
						<a href="##" class="gray-btn row2__col__gray-btn">Подключить</a>
					</div>
				</div>
			</article>

{{--			<article class="row3">--}}
{{--				<div class="row3__col1 row3__col row__col">--}}
{{--					<p class="row3__col__heading">PDF-презентация</p>--}}
{{--					<a href="##" class="row3__col__imglink">--}}
{{--						<img src="/img/pdf_pres.png" alt="">--}}
{{--					</a>--}}
{{--				</div>--}}
{{--				<div class="row3__col2 row3__col row__col">--}}
{{--					<p class="row3__col__heading">Видео-презентация</p>--}}
{{--					<a href="##" class="row3__col__imglink">--}}
{{--						<img src="/img/video_pres.png" alt="">--}}
{{--					</a>--}}
{{--				</div>--}}
{{--				<div class="row3__col3 row3__col row__col">--}}
{{--					<p class="row3__col__heading">Чат для партнёров</p>--}}
{{--					<a href="##" class="row3__col__imglink">--}}
{{--						<img src="/img/partners_chat.png" alt="">--}}
{{--					</a>--}}
{{--				</div>--}}
{{--			</article>--}}

			<article class="row4">
				<div class="row4__col1 row__col">
					<div class="donutchart-wrapper">
						<div class="donutchart-heading">
							<p style="font-size: 22px">Мои игроки <span
									style="font-size: 14px"><span>{{$user->all_partners_count}}</span> всего</span></p><br><br>
							<div class="line-separator"></div>
						</div>
						<div class="donutchart-content">
                            <ul class="donutchart-ul">
                                <li class="donutchart-ul-item">
                                    <div class="donutchart-ul-item-text">
                                        <p class="donutchart-ul-item-number">{{$user->referrals->count()}}</p>
                                        <p class="donutchart-ul-item-description">Число моих партнёров</p>
                                    </div>
                                </li>
                                <li class="donutchart-ul-item">
                                    <div class="donutchart-ul-item-text">
                                        <p class="donutchart-ul-item-number">{{$user->active_referrals_count}}</p>
                                        <p class="donutchart-ul-item-description">Число активных партнёров
                                        </p>
                                    </div>
                                </li>
                                <li class="donutchart-ul-item">
                                    <div class="donutchart-ul-item-text">
                                        <p class="donutchart-ul-item-number">{{$user->all_partners_count}}</p>
                                        <p class="donutchart-ul-item-description">Общее число моих игроков
                                        </p>
                                    </div>
                                </li>
                            </ul>
                            <div class="donutchart-container">
                                <div class="donutchart">
                                    <canvas id="myChart2" width="200" height="200"></canvas>
                                    <div class="donutchart-text">{{$user->all_partners_count}}</div>
                                </div>
                            </div>

                            <script>
                                window.onload = function () {
                                    // Получите контекст canvas
                                    var ctx = document.getElementById('myChart2').getContext('2d');

                                    // Создайте данные для диаграммы (например, круговая диаграмма)
                                    var data = {
                                        datasets: [{
                                            data: [{{$user->referrals->count()}}, {{$user->active_referrals_count}}, {{$user->all_partners_count}}],
                                            backgroundColor: ['#00ffa3', '#ffa01c', 'rgba(255, 255, 255, 0.1215686275)'],
                                            weight: 0.1,
                                            cutout: 67,
                                            animation: {animateRotate: true}
                                        }]
                                    };

                                    // Создайте и отобразите диаграмму
                                    var myChart = new Chart(ctx, {
                                        type: 'doughnut', // Выберите тип диаграммы (например, круговая)
                                        data: data,
                                        options: {
                                            cutoutPercentage: 50,
                                            elements: {
                                                arc: {
                                                    borderWidth: 0, // Убираем границы,
                                                }

                                            },

                                        }
                                    });
                                }
                            </script>
						</div>
					</div>
				</div>
				<div class="row4__col2 row__col">
					<div class="row4__col2__heading">
						<p style="font-size: 22px">Лидеры в команде</p><br><br>
						<div class="line-separator"></div>
					</div>
					<div class="row4__col2__list list">
						<div class="row4__col2__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">User User User</p>
							<p class="list-p"><span class="list-smp">Привел</span><br>5 игроков</p>
						</div>
						<div class="row4__col2__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">User User User</p>
							<p class="list-p"><span class="list-smp">Привел</span><br>5 игроков</p>
						</div>
						<div class="row4__col2__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">User User User</p>
							<p class="list-p"><span class="list-smp">Привел</span><br>5 игроков</p>
						</div>
					</div>
				</div>
			</article>

			<article class="row5">
				<div class="row5__cols12">
					<div class="row5__col1 row__col">
						<div class="barchart-wrapper">
							<div class="barchart-nav">
								<p class="barchart-nav-title">Прибыль</p>
								<div class="barchart-nav-radio">
									<input type="radio" name="currency" value="roto" checked
												 class="barchart-nav-radio-btn currency--roto">
									<label class="barchart-nav-radio-label">FLAMES</label>
								</div>
								<div class="barchart-nav-radio">
									<input type="radio" name="currency" value="rubble"
												 class="barchart-nav-radio-btn currency--rubble">
									<label class="barchart-nav-radio-label">Рубли</label>
								</div>
							</div>
							<div class="line-separator"></div>
							<div class="barchart-headingselect">
								<p class="barchart-heading-legend"></p>
								<select class="barchart-nav-select">
									<option value="week" class="barchart-nav-option">За последнюю неделю</option>
									<option value="month" class="barchart-nav-option">За последний месяц</option>
								</select>
							</div>
							<div class="barchart">
							</div>
							<div class="barchart-heading">
								<p class="barchart-heading-total">Всего заработано за период:
									<span class="barchart-heading-total-span"></span>
								</p>
							</div>
						</div>
					</div>
					<div class="row5__col2 row__col">
						<div class="barchart-wrapper">
							<div class="barchart-nav">
								<p class="barchart-nav-title">Прибыль</p>
								<div class="barchart-nav-radio">
									<input type="radio" name="currency" value="roto"
												 class="barchart-nav-radio-btn currency--roto">
									<label class="barchart-nav-radio-label">FLAMES</label>
								</div>
								<div class="barchart-nav-radio">
									<input type="radio" name="currency" value="rubble" checked
												 class="barchart-nav-radio-btn currency--rubble">
									<label class="barchart-nav-radio-label">Рубли</label>
								</div>
							</div>
							<div class="line-separator"></div>
							<div class="barchart-headingselect">
								<p class="barchart-heading-legend"></p>
								<select class="barchart-nav-select">
									<option value="week" class="barchart-nav-option">За последнюю неделю</option>
									<option value="month" class="barchart-nav-option">За последний месяц</option>
								</select>
							</div>
							<div class="barchart">
							</div>
							<div class="barchart-heading">
								<p class="barchart-heading-total">Всего заработано за период:
									<span class="barchart-heading-total-span"></span>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row5__col3 row__col">
					<div class="row5__col3__heading">
						<p style="font-size: 22px">Последние оплаты</p><br><br>
						<div class="line-separator"></div>
					</div>
					<div class="row5__col3__list list">
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
						<div class="row5__col3__list-item">
							<div class="user-avatar-wrapper">
								<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
							</div>
							<p class="list-p">@mur.mur</p>
							<p class="list-p">1000р.</p>
							<p class="list-smp">22/02/2023<br>23:03</p>
						</div>
					</div>
				</div>
			</article>

			<article class="row6">
				<div class="partner-table row__col">
					<table class="tg">
						<thead>
						<tr>
							<th class="partner-table-th--user">Партнёр</th>
							<th class="partner-table-th--regdate">Дата подключения</th>
							<th class="partner-table-th--lossmonth">Потрачено за месяц</th>
							<th class="partner-table-th--gainmonth">Заработано за месяц</th>
							<th class="partner-table-th--lossall">Потрачено всего</th>
							<th class="partner-table-th--gainall">Заработано всего</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="partner-table-td--user">
								<div class="user-avatar-wrapper">
									<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
								</div>
								<div class="partner-table-td--user-info">
									<p class="partner-table-td--user-name">ББ АА ВВ</p>
									<p class="partner-table-td--user-id">ID: 112454</p>
								</div>
							</td>
							<td class="partner-table-td--regdate">
								<p class="partner-table-td--regdate-date">22.01.2023</p>
								<p class="partner-table-td--regdate-days">4 дня</p>
							</td>
							<td class="partner-table-td--lossmonth">22 FLAMES</td>
							<td class="partner-table-td--gainmonth">48</td>
							<td class="partner-table-td--lossall">22 FLAMES</td>
							<td class="partner-table-td--gainall">4</td>
						</tr>
						<tr>
							<td class="partner-table-td--user">
								<div class="user-avatar-wrapper">
									<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
								</div>
								<div class="partner-table-td--user-info">
									<p class="partner-table-td--user-name">ББ АА ВВ</p>
									<p class="partner-table-td--user-id">ID: 112454</p>
								</div>
							</td>
							<td class="partner-table-td--regdate">
								<p class="partner-table-td--regdate-date">22.01.2023</p>
								<p class="partner-table-td--regdate-days">4 дня</p>
							</td>
							<td class="partner-table-td--lossmonth">22 FLAMES</td>
							<td class="partner-table-td--gainmonth">48</td>
							<td class="partner-table-td--lossall">22 FLAMES</td>
							<td class="partner-table-td--gainall">4</td>
						</tr>
						<tr>
							<td class="partner-table-td--user">
								<div class="user-avatar-wrapper">
									<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
								</div>
								<div class="partner-table-td--user-info">
									<p class="partner-table-td--user-name">ББ АА ВВ</p>
									<p class="partner-table-td--user-id">ID: 112454</p>
								</div>
							</td>
							<td class="partner-table-td--regdate">
								<p class="partner-table-td--regdate-date">22.01.2023</p>
								<p class="partner-table-td--regdate-days">4 дня</p>
							</td>
							<td class="partner-table-td--lossmonth">22 FLAMES</td>
							<td class="partner-table-td--gainmonth">48</td>
							<td class="partner-table-td--lossall">22 FLAMES</td>
							<td class="partner-table-td--gainall">4</td>
						</tr>
						<tr>
							<td class="partner-table-td--user">
								<div class="user-avatar-wrapper">
									<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
								</div>
								<div class="partner-table-td--user-info">
									<p class="partner-table-td--user-name">ББ АА ВВ</p>
									<p class="partner-table-td--user-id">ID: 112454</p>
								</div>
							</td>
							<td class="partner-table-td--regdate">
								<p class="partner-table-td--regdate-date">22.01.2023</p>
								<p class="partner-table-td--regdate-days">4 дня</p>
							</td>
							<td class="partner-table-td--lossmonth">22 FLAMES</td>
							<td class="partner-table-td--gainmonth">48</td>
							<td class="partner-table-td--lossall">22 FLAMES</td>
							<td class="partner-table-td--gainall">4</td>
						</tr>
						<tr>
							<td class="partner-table-td--user">
								<div class="user-avatar-wrapper">
									<img src="/img/noavatar.svg" alt="Ava" class="user-avatar">
								</div>
								<div class="partner-table-td--user-info">
									<p class="partner-table-td--user-name">ББ АА ВВ</p>
									<p class="partner-table-td--user-id">ID: 112454</p>
								</div>
							</td>
							<td class="partner-table-td--regdate">
								<p class="partner-table-td--regdate-date">22.01.2023</p>
								<p class="partner-table-td--regdate-days">4 дня</p>
							</td>
							<td class="partner-table-td--lossmonth">22 FLAMES</td>
							<td class="partner-table-td--gainmonth">48</td>
							<td class="partner-table-td--lossall">22 FLAMES</td>
							<td class="partner-table-td--gainall">4</td>
						</tr>
						</tbody>
					</table>
				</div>
			</article>
		</section>
		<section class="page__tab" id="referal_about">
			<div class="row7">
				<div class="row7__cols12">
					<div class="row7__col1 row__col">
						<h2 class="row7__col-heading">О партнёрской программе</h2>
						<div class="line-separator"></div>
						<p class="row7__col-paragraph">Это возможность зарабатывать на том, что просто
							делитесь
							возможностью со своими друзьями, приобретать товары и услуги за 10-20% от
							стоимости
						</p>
					</div>

				</div>

			</div>
		</section>
	</section>
@stop
