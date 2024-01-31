@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/main.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/about.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/about.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="main">
        <h1 class="page__heading">{!! $title !!}</h1>

        <article class="row1">
            <div class="row1__cols123">
                <div class="row1__col1 row__col">
                    <div class="flex item-cener">
                        <img src="/img/main/about.svg" alt="">
                        <p class="row1__col1-paragraph">Это международный онлайн-аукцион, который предлагает
                            возможность участвовать в торгах за право приобретения товаров, услуг,
                            крипто-активов, автомобилей, недвижимости и прочего, за 15-20% от их рыночной
                            стоимости</p>
                    </div>

                </div>
                <div class="row1__col2 row__col"
                     style="background: #171a1e radial-gradient(   at right 100%,   rgba(255, 160, 28, 0.1) 0%,   rgba(0, 0, 0, 0) 70% )">
                    <h2 class="row1__col2-heading">Миссия</h2>
                    <p class="row1__col2-paragraph">100 000 счастливых людей, выигравших на торгах <span>100
                                        000</span></p>
                </div>
                <div class="row1__col3 row__col">
                    <div class="row1__col3__block1 row1__col3__block">
                        <p class="row1__col3__block-text">Сумма<br>выигрышей</p>
                        <p class="row1__col3__block-number">1 300 000 р.</p>
                    </div>
                    <div class="row1__col3__block2 row1__col3__block">
                        <p class="row1__col3__block-text">Количество участников</p>
                        <p class="row1__col3__block-number">{{ number_format($totalUsers, 0, '.', ' ') }}</p>
                    </div>
                    <div class="row1__col3__block3 row1__col3__block">
                        <p class="row1__col3__block-text">Количество стран участников</p>
                        <p class="row1__col3__block-number">7</p>
                    </div>
                    <div class="row1__col3__block4 row1__col3__block">
                        <p class="row1__col3__block-text">Аукционов ежедневно</p>
                        <p class="row1__col3__block-number">{{ $auctionsToday }}</p>
                    </div>
                    <div class="row1__col3__block5 row1__col3__block">
                        <p class="row1__col3__block-text">Выведено партнёрам</p>
                        <p class="row1__col3__block-number">944 567 р.</p>
                    </div>
                    <div class="row1__col3__block6 row1__col3__block">
                        <p class="row1__col3__block-text">Число партнёров</p>
                        <p class="row1__col3__block-number">234</p>
                    </div>
                    <div class="row1__col3__block7 row1__col3__block">
                        <p class="row1__col3__block-text">Количество победителей</p>
                        <p class="row1__col3__block-number">132</p>
                        <div class="row1__col3__block-img">
                            <img src="/img/main/goblet-new.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row1__col4 row__col">
                <h2 class="row1__col4-heading">Как это работает?</h2>
                <div class="line-separator"></div>
                <p class="row1__col4-paragraph">В разделе <a href="{{ route('auction') }}"
                                                             style="font-weight: 400; text-decoration: underline;">аукционы</a>
                    на торги выставляются различные востребованные на рынке предложения: гаджеты, электроника,
                    драгоценности, криптовалюты, автомобили и прочее.</p>
                <ul class="progress-steps">
                    <li class="progress-step is-active">
                        <p class="progress-step-heading">До начала аукциона по каждому из предложений,
                            появляется анонс с датой и временем начала торгов и открывается набор участников
                        </p>
                    </li>
                    <li class="progress-step">
                        <p class="progress-step-heading">В каждом предложении может принимать участие
                            ограниченное количество человек, установленное индивидуально по каждому
                            предложению</p>
                    </li>
                    <li class="progress-step">
                        <p class="progress-step-heading">Для участия в торгах необходимо иметь на балансе
                            внутреннюю игровую валюту FLAMES (Royal Token)</p>
                    </li>
                    <li class="progress-step">
                        <p class="progress-step-heading">Для бронирования места и подтверждения участия в
                            торгах, игрокам необходимо заморозить установленное количество токенов FLAMES до
                            начала.</p>
                    </li>
                    <li class="progress-step">
                        <p class="progress-step-heading">По окончанию таймера сразу же начинаются торги и
                            участники начинают делать клики по кнопке «купить»</p>
                    </li>
                    <li class="progress-step">
                        <p class="progress-step-heading">Каждый клик стоит заранее установленное количество
                            FLAMES на каждом из предложений.</p>
                    </li>
                    <li class="progress-step">
                        <p class="progress-step-heading">После каждого сделанного клика, право приобретения
                            предложения переходит последнему кликнувшему участнику торгов</p>
                    </li>
                    <li class="progress-step">
                        <p class="progress-step-heading">Если за установленное время с момента вашего клика
                            вас никто не перекликнул, предложение достаётся вам!</p>
                    </li>
                </ul>
                <p class="row1__col4-spoiler">Развернуть</p>
            </div>
        </article>

        <article class="row2">
            <div class="row2__cols12">
                <div class="row2__col1">
                    <div class="row2__col1__block row__col">
                        <a href="https://instagram.com/{!! env('CONTACTS_INSTAGRAM') !!}" class="row2__col1__block-img">
                            <img src="/img/icons/instagram.svg" alt="">
                        </a>
                        <p class="row2__col1__block-text">Instagram</p>
                    </div>
                    <div class="row2__col1__block row__col">
                        <a href="{!! env('CONTACTS_TELEGRAM') !!}" class="row2__col1__block-img">
                            <img src="/img/icons/telegram.svg" alt="">
                        </a>
                        <p class="row2__col1__block-text">Телеграм</p>
                    </div>
                    <div class="row2__col1__block row__col">
                        <a href="#" class="row2__col1__block-img">
                            <img src="/img/icons/tgbot.svg" alt="">
                        </a>
                        <p class="row2__col1__block-text">Телеграм-бот</p>
                    </div>
                </div>
            </div>
        </article>
        <div>
            <div class="row2__col3 row__col">
                <h3 class="row2__col3-heading">Последние регистрации</h3>
                <div class="partner-table">
                    <table class="tg">
                        <thead>
                        <tr>
                            <th class="partner-table-th--user">Пользователь</th>
                            <th class="partner-table-th--regdate">Дата подключения</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($lastUserRegistration as $lastUserRegistrationItem)
                            <tr>
                                <td class="partner-table-td--user">
                                    <div class="user-avatar-wrapper">
                                        <img
                                            src="/img/noavatar.svg"
                                            alt="Ava" class="user-avatar">
                                    </div>
                                    <div class="partner-table-td--user-info">
                                        <p class="partner-table-td--user-name">{{ $lastUserRegistrationItem->telegram }}</p>
                                        <p class="partner-table-td--user-id">ID: {{ $lastUserRegistrationItem->id }}</p>
                                    </div>
                                </td>
                                <td class="partner-table-td--regdate">
                                    <p class="partner-table-td--regdate-date">{{ date('d.m.Y', strtotime($lastUserRegistrationItem->created_at)) }}</p>
                                    <p class="partner-table-td--regdate-time">{{ date('H:i', strtotime($lastUserRegistrationItem->created_at)) }}</p>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@stop
