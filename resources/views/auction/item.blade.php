@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/swiper-bundle.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/styles.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/lot.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/swiper-bundle.min.css') !!}" rel="stylesheet">

@endpush

@push('scripts')
    <script type="text/javascript">
        let urlLogin = '{{ route('login') }}',
            urlStartAuction = '/startAuction/',
            urlBid = '/bid/',
            urlGetAuctionBidsTable = '/getAuctionBidsTable/',
            pusherAppKey = '{{ env('PUSHER_APP_KEY') }}',
            pusherAppCluster = '{{ env('PUSHER_APP_CLUSTER') }}',
            pusherChannel = '{{ env('PUSHER_CHANNEL') }}',
            pusherEvent = '{{ env('PUSHER_EVENT') }}';
    </script>
    <script src="{!! asset('js/thirdParty/jquery-3.6.4.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/lot.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/auction_mechanic.js') !!}" type="text/javascript"></script>
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
@endpush

@section('content')
    <section class="page" id="lot">
        <h1 class="page__heading">Лот №{{ $item->lot_number }}</h1>
        <a href="{{ url()->previous() }}" class="lot__back-link go-back-btn">Назад</a>
        <div class="lot__main"
             data-id="{{ $item->id }}"
             data-bet-size="{{ $item->bet_size }}"
             data-timer-dv-all="{{ $item->timer['dv_all'] }}"
             data-timer-dv-left="{{ $item->timer['dv_left'] }}"
             data-timer-left="{{ $item->timer['time_left'] }}"
        >
            <div class="lot__col1 row__col">
                <div class="lot__card status-{{ $item->status_id }}">
                    <span class="lot__card-cost_mobile"><span
                            class="value">{{ number_format($item->price, 0, '.', ' ') }}</span> р.</span>
                    <div class="lot__card-visual">

                        <div class="lot__card-img">
                            @if(count($item->images) > 0)
                                <img src="{!! asset($item->images[0]) !!}" alt="">
                            @else
                                <img src="{!! asset('/img/icons/auction.svg') !!}" alt="">
                            @endif
                        </div>


                        @if($item->status_id<3)
                            @if ($item->deposit_value)
                                <div class="lot__card-sticker sticker-deposit type2">
                                    <p class="lot__card-sticker-smp">Ваш депозит</p>
                                    <p class="lot__card-sticker-bigp">{{$item->deposit_value->deposit_balance}}
                                        FLAMES</p>
                                </div>
                            @elseif($item->deposit > 0)
                                <div class="lot__card-sticker sticker-deposit">
                                    <p class="lot__card-sticker-smp">Депозит</p>
                                    <p class="lot__card-sticker-bigp">{{$item->deposit}} FLAMES</p>
                                </div>
                            @endif
                        @else
                            <div class="lot__card-sticker sticker-win">
                                <p class="lot__card-sticker-p">победа!</p>
                            </div>
                            <p class="lot-victory-text">Победил:</p>

                            <div class="lot__card_img-wrapper">
                                <div class="lot__card-letter-icon-wrapper fs">
                                    <span class="lot__card-letter-icon">{{ $leader->first_letter_name ?? null }}</span>
                                </div>
                                <p class="lot__card-sticker-p lot__card_img-wrapper-p">
                                    {{ $leader->name ?? null }}
                                </p>
                            </div>
                        @endif
                        @if ($isFavorite)
                            <div class="fav_button active" data-id="{{ $item->id }}">
                                <div class="text">Убрать из избранного</div>
                            </div>
                        @else
                            <div class="fav_button" data-id="{{ $item->id }}">
                                <div class="text">Добавить в избранное</div>
                            </div>
                        @endif
                        @if ($item->bet_size > 1)
                            <div class="auction__card-sticker sticker-payment is-disabled">
                                <p class="auction__card-sticker-p">{{$item->bet_size}} FLAMES</p>
                                <p class="auction__card-sticker-p">Стоимость клика</p>
                            </div>
                        @endif
                    </div>
                    {{--<div class="lot__card-date">
                        <p class="lot__card-date-smp">
                            @if ($item->status->code == 'start') Начало
                            @elseif ($item->status->code == 'completed' || $item->time_left == 0)
                                Завершен
                            @else {{ $item->status->name }} @endif</p>
                        <p class="lot__card-date-value time_left"
                           data-time-left="{{ $item->status->code == 'completed' ? 0 : $item->time_left }}">{{ (floor($item->time_left / 60) < 10 ? '0' : '') . floor($item->time_left / 60) . ':' . ($item->time_left % 60 < 10 ? '0' . $item->time_left % 60 : $item->time_left % 60) }}</p>
                    </div>--}}
                    @if($item->status_id==1)
                        <div class="lot__card-date">
                            <p class="lot__card-date-smp">Начало</p>
                            <p class="lot__card-date-value">{{ date('d/m/y H:i', strtotime($item->time_to_start)) }}</p>
                        </div>
                    @elseif($item->status_id==2)
                        <div class="lot__card-date type2">
                            <div class="caption">Лидер</div>
                            <div
                                class="item winner auction_item"> {{--auction_item - для того что бы работал таймер (вот такой кривой скрипт)--}}
                                <div class="user">
                                    <div class="icon">
                                        <div class="noicon color1">{{$leader->first_letter_name}}</div>
                                    </div>
                                    <div class="name">{{$leader->name}}</div>
                                </div>
                                <div class="time time_left"
                                     data-time-left="{{ $item->timer['time_left'] }}">{{ $item->timer['dv_left'] }}</div>
                            </div>

                        </div>
                    @endif
                </div>
                <div class="lot__card-text">
                    <div class="lot__button-mobile-wrapper">
                        <button class="lot__button lot__button-mobile invate">Вступить</button>
                        {{--<div class="victory-error-wrapper lot__button-mobile-wrapper">
                            <button class="lot__button lot__button-mobile victory-lot-status__error">
                                Не оплачен
                            </button>
                            <p class="grey-text lot__button-mobile-wrapper__text">
                                Лот не был оплачен своевременно. По правилам платформы,
                                сумму выигрыша мы отправляем в благотворительный фонд
                            </p>
                        </div>--}}
                    </div>

                    <div class="lot__card-heading">
                        <h6 class="lot__card-heading-title">
                            <span class="lot__card-name">{{ $item->name }}</span>
                            <span class="lot__card-cost"><span
                                    class="value">{{ number_format($item->price, 0, '.', ' ') }}</span> р.</span>
                        </h6>
                        @if (!is_null($item->all_slots))
                            <p class="lot__card-heading-places">
                                Свободно мест:
                                <br>
                                <span class="lot__card-placesleft"><span class="free">{{ $item->free_slots }}</span>
                            из <span class="all">{{ $item->all_slots }}</span></span>
                            </p>
                        @endif
                    </div>
                    @if ($item->bet_size > 1)
                        <p class="lot__card-click-pay">Стоимость клика - {{$item->bet_size}} FLAMES</p>
                    @endif
                    <p class="lot__card-description">
                        {!! $item->description !!}
                    </p>
                    <button class="lot__card-spoiler">Подробнее о товаре</button>
                    <div class="lot__about">
                        {!! $item->characteristic !!}
                        @if ($additionalDescription)
                            @foreach ($additionalDescription as $additionalDescriptionItem)
                                <div class="item">
                                    <div class="title">{!! $additionalDescriptionItem->title !!}</div>
                                    <div class="description">{!! $additionalDescriptionItem->description !!}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button data-id="{{ $item->id }}"
                            class="lot-button
                            @if(($item->status->code == 'bid')&&($item->is_member))lot__interrupt
                                @else lot__button invate
                            @endif
                            @if($item->status->code == 'start') notstarted is-enabled
                                @elseif($item->status->code == 'bid' || $item->time_left > 0)
                                    @if(isset($item->is_member))
                                        @if(!$item->is_member) started bid is-enabled @endif
                                    @endif
                                lot-first bid is-enabled
                                @elseif($item->status->code == 'completed' || $item->time_left == 0) victory-in-active
                                    @else bid is-enabled @endif"
                            @if($item->status->code == 'start')
                                data-dv-all="{{ $item->timer['dv_all'] }}"
                            data-time-left="{{ $item->timer['time_left'] }}"
                            data-dv-left="{{ $item->timer['dv_left'] }}"
                        @endif >
                        @if (isset($canPay) && $item->payed == 0 && $item->canPay)
                            Оплатить
                        @elseif (isset($canPay) && $item->payed == 1 && $item->canPay)
                            Оплачен
                        @elseif ($item->time_left == 0 && $item->status->code !== 'start')
                            Завершен
                        @else
                            @if(($item->status->code == 'bid')&&($item->is_member))
                                ПЕРЕБИТЬ <span></span>{{$item->bet_size}} FLAMES
                            @elseif (($item->status->code=='start')&&($item->deposit_value))
                                Вы участвуете
                            @else
                                {{ $item->status->name }}
                            @endif
                        @endif
                    </button>
                    {{--<button class="lot__interrupt">ПЕРЕБИТЬ <span></span>20 FLAMES</button>--}}
                    {{--<button class="lot__button victory-active">
                        Спасибо за ваш отзыв!
                    </button>
                    <button class="lot__button victory-in-active">
                        Завершен
                    </button>
                    <button class="lot__button victory-pay">Оплатить</button>
                    <button class="lot__button victory-in-active">
                        Оплачено
                    </button>
                    <button class="lot__button victory-btn-eyllow">
                        Оставить отзыв
                    </button>
                    <div class="victory-error-wrapper">
                        <button class="lot__button victory-lot-status__error">
                            Не оплачен
                        </button>
                        <p class="grey-text">
                            Лот не был оплачен своевременно. По правилам платформы,
                            сумму выигрыша мы отправляем в благотворительный фонд
                        </p>
                    </div>--}}
                </div>
            </div>
            <div class="lot__col2 row__col">
                <div class="lot__col2-wrapper">
                    <div class="lot__col2-heading-wrapper">
                        <h3 class="lot__col2-heading">Список участников:</h3>
                        <button class="lot__filterbar-heading-showbtn"></button>
                    </div>

                    <div class="line-separator"></div>
                    <ul class="lot__list lot__list-members is-active">
                        @foreach ($bids as $bid)
                            @php
                                $bidUser = App\User::find($bid->user_id);
                            @endphp
                            <li class="lot__list-item">
                                <div class="user-avatar-wrapper">
                                    <img
                                        src="/img/noavatar.svg"
                                        alt="Ava" class="user-avatar">
                                </div>
                                <p class="user-email">{{ $bidUser->email }}</p>
                                <p class="user-date">{{ date('H:i', strtotime($bid->created_at)) }}</p>
                            </li>

                        @endforeach
                    </ul>
                    <div class="lot__list lot__progress-steps-wrapper ">
                        <ul class="progress-steps">
                            <li class="lot__progress-steps-row">
                                <div class="lot__progress-step lot__progress-step-error">
                                    <span>1</span>
                                </div>
                                <div>
                                    <h3 class="grey-text">Оплата</h3>
                                    <p class="lot__progress-steps__smp grey-text">
                                        Заказ ожидает оплаты
                                    </p>
                                </div>
                            </li>
                            <li class="lot__progress-steps-row">
                                <div class="lot__progress-step lot__progress-step-done">
                                    <span>2</span>
                                </div>
                                <div>
                                    <h3>Контактные данные</h3>
                                    <p class="lot__progress-steps__smp grey-text">
                                        Заполните данные для доставки
                                    </p>
                                    <a class="lot__progress-steps__btn submit-btn is-active" href="settings.html">Настройки</a>
                                </div>
                            </li>
                            <li class="lot__progress-steps-row">
                                <div class="lot__progress-step lot__progress-step-active">
                                    <span>3</span>
                                </div>
                                <div>
                                    <h3>Звонок менеджера</h3>
                                    <p class="lot__progress-steps__smp grey-text">
                                        Подтвердите данные для доставки менеджеру
                                    </p>
                                </div>
                            </li>
                            <li class="lot__progress-steps-row">
                                <div class="lot__progress-step lot__progress-step-disable">
                                    <span>4</span>
                                </div>
                                <div>
                                    <h3>Заказ отправлен</h3>
                                    <p class="lot__progress-steps__smp grey-text">
                                        Трек-номер для отслеживания
                                    </p>
                                    <span class="lot__progress-steps__tracknum tooltip grey-text"
                                          value="5679-5636-5683">5679-5636-5683
                                    <span class="tooltip-text">
                                      Скопировано в буфер обмена
                                    </span>
                                  </span>
                                </div>
                            </li>
                            <li class="lot__progress-steps-row">
                                <div class="lot__progress-step lot__progress-step-disable">
                                    <span>5</span>
                                </div>
                                <div>
                                    <h3>Заказ доставлен</h3>
                                    <p class="lot__progress-steps__smp grey-text">
                                        Поздравляем!
                                    </p>
                                    <button class="lot__progress-steps__btn submit-btn is-active">
                                        Оставить отзыв
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="lot__nav">
            <div class="lot__tags-wrapper">
                <p class="lot__tags-p">Категория:</p>
                <ul class="lot__tags">
                    <li class="lot__tag">Гаджеты</li>
                </ul>
            </div>
            {{--<div class="lot__autoclick">
                <input type="checkbox" id="lot--autoclick" name="lot--autoclick">
                <label for="lot--autoclick">Автоклик</label>
                <button class="lot__autoclick-settings">
                    <img src="./img/icons/gear.svg" alt="">
                </button>
            </div>--}}
        </div>
        {{--        <div class="lot__review row__col">--}}
        {{--                <h2 class="lot__review-title">Отзыв победителя</h2>--}}
        {{--                <p class="lot__review-date">22/02/2023 23:34</p>--}}
        {{--                <p class="lot__review-description desctop">--}}
        {{--                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.--}}
        {{--                    Dolorum eveniet placeat blanditiis consequuntur maiores rerum--}}
        {{--                    beatae quia dolores sed ullam, unde at quibusdam labore--}}
        {{--                    perspiciatis tempora? Vitae labore minus dolorum.--}}
        {{--                </p>--}}
        {{--                <p class="lot__review-email">example@email.com</p>--}}
        {{--            </div>--}}

        {{--            <div class="lot__review-video-wrapper">--}}
        {{--                <video preload="auto" class="lot__review-video" poster="./img/dodq.png">--}}
        {{--                    <source src="./img/man_eating_burger.webm" type="video/webm">--}}
        {{--                </video>--}}
        {{--                <button class="lot__review-video-playbtn"></button>--}}
        {{--            </div>--}}
        {{--            <p class="lot__review-description mobile">--}}
        {{--                Lorem ipsum dolor, sit amet consectetur adipisicing elit.--}}
        {{--                Dolorum eveniet placeat blanditiis consequuntur maiores rerum--}}
        {{--                beatae quia dolores sed ullam, unde at quibusdam labore--}}
        {{--                perspiciatis tempora? Vitae labore minus dolorum.--}}
        {{--            </p>--}}
        {{--        </div>--}}
    </section>
@stop
