@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/jquery-ui.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/styles.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/profile.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/slick.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/swiper-bundle.min.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('./js/jquery-3.6.2.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/itc__slider.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/jquery-ui.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/slick.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/profile.js') !!}" type="text/javascript"></script>

@endpush

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <section class="page" id="profile">
        <h1 class="page__heading">{{ $title }}</h1>

        {{--@dump($user)--}}
        {{--@dump($bids)--}}
        {{--@dump($referrals)
        @dump($refSum)
        @dump($refRegister)--}}

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
                        <p class="user-id">ID: {{ $user->id }}</p>
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
                {{--                <div class="action-modal__placeSingleButton">--}}
                {{--                    <button class="gray-btn action-modal__info__btn singleButton" id="balance-action-btn">--}}
                {{--                        Вывести--}}
                {{--                    </button>--}}
                {{--                </div>--}}
            </div>
            <div class="row1__col2 row__col">
                <div class="donutchart-wrapper">
                    <div class="donutchart-container">
                        <div class="donutchart">
                            <svg width="88" height="88" viewBox="0 0 88 88" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M85 44C85 66.6436 66.6437 85 44 85C21.3563 85 3 66.6436 3 44C3 21.3563 21.3563 3 44 3C66.6437 3 85 21.3563 85 44Z"
                                    stroke="white" stroke-opacity="0.07" stroke-width="6"></path>
                                <mask id="path-2-inside-1_250_4571" fill="white">
                                    <path
                                        d="M44 2.96389C44 1.32698 45.3288 -0.0104026 46.962 0.0997242C56.5668 0.747377 65.6982 4.52971 72.9478 10.8634C74.1805 11.9404 74.1744 13.8256 73.0169 14.9831C71.8594 16.1406 69.9898 16.1305 68.7458 15.0665C62.6233 9.82978 54.9933 6.66931 46.9611 6.04302C45.3291 5.91577 44 4.6008 44 2.96389Z"></path>
                                </mask>
                                <path
                                    d="M44 2.96389C44 1.32698 45.3288 -0.0104026 46.962 0.0997242C56.5668 0.747377 65.6982 4.52971 72.9478 10.8634C74.1805 11.9404 74.1744 13.8256 73.0169 14.9831C71.8594 16.1406 69.9898 16.1305 68.7458 15.0665C62.6233 9.82978 54.9933 6.66931 46.9611 6.04302C45.3291 5.91577 44 4.6008 44 2.96389Z"
                                    stroke="rgb(255,160, 28)" stroke-width="12"
                                    mask="url(#path-2-inside-1_250_4571)"></path>
                            </svg>
                            <div class="donutchart-text">10%</div>
                        </div>
                    </div>
                </div>
                <div class="row1__col2__user-verification" style="margin: 20px; flex: 1 1 auto">
                    <p style="line-height: 1.1; display: flex; align-items: center">
                        Уровень авторизации
                        <span class="tooltip">
                      <span class="tooltip-text" style="left: -600%">Ваш уровень авторизации слишком низкий, чтобы <br>
                        участвовать в аукционах. Дополните контактную <br>
                        информацию в настройках профиля, чтобы <br>
                        верифицировать аккаунт. <br>
                          <!-- куда ведет линка? -->
                        <a href="#" class="tooltip__link">Правила аукциона
                          <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.960938 8.29165L5.29427 4.49998L0.960938 0.708313" stroke="#ffa01c"
                                  stroke-width="1.2" stroke-miterlimit="10" stroke-linecap="round"
                                  stroke-linejoin="round"></path>
                          </svg>
                        </a>
                      </span>
                    </span>
                    </p>
                    <div class="line-separator" style="width: 50%; margin: 10px 0"></div>
                    <p style="
                      font-size: 12px;
                      font-weight: 300;
                      color: #ff0f0f;
                      white-space: nowrap;
                    ">
                        Не верифицирован!
                    </p>
                </div>
            </div>
        </article>

        <article class="row2 ">
            <div class="row2__col1">
                <div class="row2__col1__checklist-visual">
                    <p style="font-size: 20px; margin-bottom: 20px">
                        Чек-лист
                        <img src="./img/icons/arrow-right.svg" style="vertical-align: middle; margin-left: 14px">
                    </p>
                    <p style="
                      font-weight: 300;
                      font-size: 12px;
                      line-height: 16.8px;
                      margin-bottom: 2px;
                    ">
                        Прежде чем ты начнёшь учавствовать <br>
                    </p>
                    <p style="
                      font-weight: 300;
                      font-size: 12px;
                      line-height: 16.8px;
                    ">
                        в аукционе, выполни все задания:
                    </p>
                    <div class="row2__col1__checklist-img">
                        <img src="./img/checklist.png" alt="">
                    </div>
                    <div class="row2__col1__checklist-award-info">
                        <div class="row2__col1__checklist-award">+50</div>
                        <p class="row2__col1__checklist-award-text">
                            За каждое выполненное задание
                        </p>
                    </div>
                </div>
            </div>
            <div class="row2__col2 middle">
                <ul class="row2__col2__checklist">
                    <div class="profile-slide">
                        @foreach (App\Helpers\CheckListHelper::instance()->getList() as $arrayIndex => $checkListItem)

                            <li
                                class="row2__col2__checklist-item @if (isset($checkListItem['checked']) && $checkListItem['checked']) is-checked @endif">
                                <img src="{{ $checkListItem['image'] }}" class="row2__col2__checklist-item-img" alt=""/>
                                <div class="row2__col2__checklist-item-text">
                                    <p>{{ $checkListItem['text'] }}</p>
                                    <a href="{{ $checkListItem['link']['url'] }}"
                                       class="row2__col2__checklist-item-link">
                                        {{ $checkListItem['link']['title'] }}
                                    </a>
                                    @if (isset($checkListItem['additional']))
                                        <p>{{ $checkListItem['additional'] }}</p>
                                    @endif
                                </div>
                            </li>

                            @if ($arrayIndex % 5  == 0)
                    </div>
                    <div class="profile-slide">
                    @endif

                    @endforeach

                </ul>
                <div class="row2__col2__checklist_carousel swiper swiper-initialized swiper-horizontal">
                    <div class="checklist_carousel swiper-wrapper" style="transition-duration: 0ms;"
                         id="swiper-wrapper-51df297a47eb3a58" aria-live="polite">
                        <div class="profile-slide swiper-slide">
                            <li class="row2__col2__checklist-item is-checked">
                                <img src="./img/icons/checkboxes/checked.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Изучите информацию</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        о проекте
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch2.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Пройдите верификацию аккаунта</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        на странице профиля
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch3.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Подпишитесь на официальный аккаунт в</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        Instagram
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch4.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Подпишитесь на официальный</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        telegram канал
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch5.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Подключите</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        telegram bot </a><br>
                                    <p>для получения уведомлений</p>
                                </div>
                            </li>
                        </div>
                        <div class="profile-slide swiper-slide">
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch6.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Ознакомьтесь с</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        лентой победителей
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch7.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Изучите</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        тактику победы </a><br>
                                    <p>в аукционах</p>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch8.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Выберите и оплатите</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        пакет токенов </a><br>
                                    <p>для участия в аукционах</p>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch9.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Выберите</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        аукцион </a><br>
                                    <p>и примите в нем участие</p>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch10.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Вступите в</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        чат игроков
                                    </a>
                                </div>
                            </li>
                        </div>
                        <div class="profile-slide swiper-slide">
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch11.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Ознакомьтесь с условиями</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        партнерской программы
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch12.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Вступите в</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        чат партнёров
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch13.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Порекомендуйте участие в аукционе в</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        социальных сетях
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch14.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Выведите</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        партнёрские вознаграждения
                                    </a>
                                </div>
                            </li>
                        </div>
                    </div>
                    <div
                        class="checklist_carousel_pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"></div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                <div class="row2__col2__checklist_carousel2 swiper swiper-initialized swiper-horizontal">
                    <div class="checklist_carousel2 swiper-wrapper" style="transition-duration: 0ms;"
                         id="swiper-wrapper-f8abb506f81d09d3" aria-live="polite">
                        <div class="profile-slide swiper-slide">
                            <li class="row2__col2__checklist-item is-checked">
                                <img src="./img/icons/checkboxes/checked.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Изучите информацию</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        о проекте
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch2.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Пройдите верификацию аккаунта</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        на странице профиля
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch3.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Подпишитесь на официальный аккаунт в</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        Instagram
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch4.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Подпишитесь на официальный</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        telegram канал
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch5.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Подключите</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        telegram bot </a><br>
                                    <p>для получения уведомлений</p>
                                </div>
                            </li>
                        </div>
                        <div class="profile-slide swiper-slide">
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch6.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Ознакомьтесь с</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        лентой победителей
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch7.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Изучите</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        тактику победы </a><br>
                                    <p>в аукционах</p>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch8.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Выберите и оплатите</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        пакет токенов </a><br>
                                    <p>для участия в аукционах</p>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch9.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Выберите</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        аукцион </a><br>
                                    <p>и примите в нем участие</p>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch10.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Вступите в</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        чат игроков
                                    </a>
                                </div>
                            </li>
                        </div>
                        <div class="profile-slide swiper-slide">
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch11.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Ознакомьтесь с условиями</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        партнерской программы
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch12.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Вступите в</p>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        чат партнёров
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch13.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Порекомендуйте участие в аукционе в</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        социальных сетях
                                    </a>
                                </div>
                            </li>
                            <li class="row2__col2__checklist-item">
                                <img src="./img/icons/checkboxes/ch14.svg" class="row2__col2__checklist-item-img">
                                <div class="row2__col2__checklist-item-text">
                                    <p>Выведите</p>
                                    <br>
                                    <a href="##" class="row2__col2__checklist-item-link">
                                        партнёрские вознаграждения
                                    </a>
                                </div>
                            </li>
                        </div>
                    </div>
                    <div
                        class="checklist_carousel_pagination2 swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"></div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
            </div>
        </article>

        <article class="row3">
            <div class="row3__col1 row3__col row__col">
                <div class="row3__col1-top">
                    <p class="row3__white-p">Число моих аукционов <span
                            class="row3__number">{{ count($auctionList['active']) }}</span></p>
                    <br/>
                    <div class="line-separator"></div>
                </div>


                @if(count($auctionList['active']))
                    <div class="row3__col1-awards">
                        @for ($i = 0; ($i<4)and($i<count($auctionList['active'])) ; $i++)
                            <div class="row3__card" data-id="{{ $auctionList['active'][$i]->id }}">
                                <div class="row3__card-img">
                                    @if($auctionList['active'][$i]->preview_image != null)
                                        <img src="{!! asset($auctionList['active'][$i]->preview_image) !!}"
                                             alt="{{ $auctionList['active'][$i]->name }}">
                                    @else
                                        <img src="{!! asset('/img/icons/auction.svg') !!}"
                                             alt="{{ $auctionList['active'][$i]->name }}">
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                    <a href="{{ route('myAuction') }}" class="row3__gray-a">Увидеть все ></a>
                @else
                    <div class="list-is-empty activelist"><p>У вас нет активных укционов</p></div>
                @endif

            </div>
            <div class="row3__col2 row3__col row__col">
                <div class="row3__col2-text">
                    <p class="row3__white-p">
                        <span class="row3__number">{{ count($auctionList['won']) }}</span>
                        <br/><br/>
                        Выигранных аукционов
                        <br/><br/>
                    </p>
                    <a href="{{ route('myAuction') }}" class="row3__gray-a">Увидеть все ></a>
                </div>
                @if(count($auctionList['won']))
                    <div class="row3__col2-awards">
                        @for ($i = 0; ($i<4)and($i<count($auctionList['won'])); $i++)
                            <div class="row3__card" data-id="{{ $auctionList['won'][$i]->id }}">
                                <div class="row3__card-img">
                                    @if($auctionList['won'][$i]->preview_image != null)
                                        <img src="{!! asset($auctionList['won'][$i]->preview_image) !!}"
                                             alt="{{ $auctionList['won'][$i]->name }}">
                                    @else
                                        <img src="{!! asset('/img/icons/auction.svg') !!}"
                                             alt="{{ $auctionList['won'][$i]->name }}">
                                    @endif
                                </div>

                            </div>
                        @endfor
                    </div>
                @else
                    <div class="row3__col2-awards list-is-empty wonlist"><p>У вас нет выигранных укционов</p></div>
                @endif
            </div>
            <div class="row3__col3 row3__col row__col">
                <p class="row3__number">{{ $pay }}</p>
                <p class="row3__white-p">Потрачено </p>
            </div>
            <div class="row3__col4 row3__col row__col">
                <p class="row3__number">0 р.</p>
                <p class="row3__white-p">Сумма выигрышей</p>
            </div>
        </article>

        <article class="row4">
            <div class="row4__col1 row__col">
                <div class="donutchart-wrapper">
                    <div class="donutchart-heading">
                        <p>Мои игроки <span><span>{{$user->all_partners_count}}</span> всего</span></p><br><br>
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
                                <canvas id="myChart" width="185" height="185"></canvas>
                                <div class="donutchart-text">{{$user->all_partners_count}}</div>
                            </div>
                        </div>
                    </div>
                    <script>
                        // Получите контекст canvas
                        var ctx = document.getElementById('myChart').getContext('2d');

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
                    </script>

                </div>
            </div>

            <div class="row4__col2 row__col">
                <div class="barchart-wrapper">
                    <div class="barchart-nav">
                        <p class="barchart-nav-title">Прибыль</p>
                        <div class="barchart-nav-radio">
                            <input type="radio" name="currency" value="" checked
                                   class="barchart-nav-radio-btn currency--">
                            <label class="barchart-nav-radio-label"></label>
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
        </article>

        <article class="row5">
            <div class="row4__col1 row__col">
                <div class="outputHistory-wrapper">
                    <div class="outputHistory-heading">
                        <div class="outputHistory-cell outputHistory-cell-1">
                            <p>Вид операии</p>
                            <img src="./img/icons/selectArrow.svg" alt="">
                        </div>
                        <div class="outputHistory-cell outputHistory-cell-2">
                            <p>Сумма операции</p>
                            <img src="./img/icons/selectArrow.svg" alt="">
                        </div>
                        <div class="outputHistory-cell outputHistory-cell-3">
                            <p>Дата операции</p>
                            <img src="./img/icons/selectArrow.svg" alt="">
                        </div>
                        <div class="outputHistory-cell outputHistory-cell-4">
                            <p>Статус операции</p>
                            <img src="./img/icons/selectArrow.svg" alt="">
                        </div>
                        <div class="outputHistory-cell outputHistory-cell-5">
                            <p>Баланс до</p>
                            <img src="./img/icons/selectArrow.svg" alt="">
                        </div>
                        <div class="outputHistory-cell outputHistory-cell-6">
                            <p>Баланс после</p>
                            <img src="./img/icons/selectArrow.svg" alt="">
                        </div>
                    </div>
                    <br><br>
                    <div class="line-separator"></div>
                    <div class="outputHistory-content">
                        @foreach($histories as $history)
                            <div class="outputHistory-row">
                                <div class="outputHistory-row-item outputHistory-row-item-1">
                                    <p>{{$history->operation_type}}</p>
                                </div>
                                <div class="outputHistory-row-item outputHistory-row-item-2">
                                    <p>{{$history->sum}} </p>
                                </div>
                                <div class="outputHistory-row-item outputHistory-row-item-3">
                                    <p>{{$history->updated_at}}</p>
                                </div>
                                <div class="outputHistory-row-item outputHistory-row-item-4">
                                    @if($history->status == 0)
                                        <p class="in-work">В обработке</p>
                                    @elseif($history->status == 1)
                                        <p class="succes">Успешно</p>
                                    @elseif($history->status == 2)
                                        <p class="deny">Отклонено</p>
                                    @endif
                                </div>
                                <div class="outputHistory-row-item outputHistory-row-item-5">
                                    <p>{{$history->balance_start}} </p>
                                </div>
                                <div class="outputHistory-row-item outputHistory-row-item-6">
                                    <p>{{$history->balance_end}} </p>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

                <!-- мобильная версия истории -->
                <div class="outputHistory-wrapper__mobile">
                    <div class="outputHistory-heading__mobile">
                        <h3>История операций</h3>
                        <div class="outputHistory-cell__mobile">
                            <p>Вид операии</p>
                            <img src="./img/icons/selectArrow.svg" alt="">
                        </div>
                    </div>
                    <br><br>
                    <div class="line-separator"></div>
                    <div class="outputHistory-content__mobile">
                        @foreach($histories as $history)
                            <div class="outputHistory-row__mobile">
                                <br><br>
                                <div class="outputHistory-row-item__mobile">
                                    <p>{{$history->operation_type}}</p>
                                    <p>{{$history->sum}} </p>
                                </div>
                                <div class="outputHistory-row-item__mobile">
                                    <p class="grey-text">{{$history->updated_at}}</p>
                                    @if($history->status == 0)
                                        <p class="in-work">В обработке</p>
                                    @elseif($history->status == 1)
                                        <p class="succes">Успешно</p>
                                    @elseif($history->status == 2)
                                        <p class="deny">Отклонено</p>
                                    @endif
                                </div>
                                <div class="outputHistory-row-item__mobile">
                                    <div class="outputHistory-row-item__mobile-left">
                                        <p class="grey-text">Баланс до:</p>
                                        <p>{{$history->balance_start}} </p>
                                    </div>
                                    <div class="outputHistory-row-item__mobile-right">
                                        <p class="grey-text">Баланс после:</p>
                                        <p>{{$history->balance_end}} </p>
                                    </div>
                                </div>
                                <div class="outputHistory-row-item__mobile"></div>
                                <div class="line-separator"></div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </article>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var checkbox_items = document.querySelectorAll(
                ".row2__col2__checklist-item"
            );
            checkbox_items.forEach((element) => {
                if (element.classList.contains("is-checked"))
                    element.querySelector(".row2__col2__checklist-item-img").src =
                        "./img/icons/checkboxes/checked.svg";
            });
        });
    </script>
@stop
