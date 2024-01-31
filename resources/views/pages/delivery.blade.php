@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/payment.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/thirdParty/jquery-3.6.4.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="payment">
        <h1 class="page__heading">{{ $title }}</h1>
        <article class="row1">
            <div class="row1__col1 row__col">
                <h2 class="row__col__heading">Оплата</h2>
                <div class="line-separator"></div>
                <div class="row__col__content">
                    <div class="row__col__block">
                        <div class="row__col__block-text">
                            <p class="row__col__paragraph">Оплата производится безналичным расчётом на сайте
                                при помощи банковских карт следующих платёжных систем: МИР, VISA
                                International, Mastercard Worldwide</p>
                            <br><br>
                            <p class="row__col__paragraph">После успешного прохождения оплаты на электронную
                                почту плательщика направляется электронная квитанция, подтверждающая
                                совершение платежа и содержащая его уникальный идентификатор.</p>
                        </div>
                        <div class="row__col__block-visual">
                            <div class="row__col__img row__col__img__creditcard">
                                <img src="/img/creditcard.png" alt="">
                            </div>
                            <p class="row__col__tip">Все вопросы, связанные с процессом оплаты можно задать
                                специалистам службы поддержки по телефону или написав письмо на почту.</p>
                        </div>
                    </div>
                    <div class="row__col__block">
                        <div class="row__col__block-text">
                            <p>Для оплаты банковской картой необходимо заполнить короткую платежную форму:
                            </p><br>
                            <p class="row__col__paragraph">1. выбрать тип платёжной системы (МИР, Visa,
                                MasterCard);
                                2. указать номер карты (16 цифр на лицевой стороне карты);
                                3. ввести CVC / CVV номер (3 цифры, которые напечатаны на обратной стороне
                                карты, на полосе с подписью);
                                4. имя и фамилию владельца карты (в точности так же, как они написаны на
                                лицевой стороне карты) и другие необходимые персональные данные;
                                5. срок действия карты, который написан на лицевой стороне карты.</p>
                        </div>
                        <div class="row__col__block-visual">
                            <div class="row__col__img">
                                <img src="/img/icons/visa.svg" alt="visa">
                            </div>
                            <div class="row__col__img">
                                <img src="/img/icons/mastercard.svg" alt="mastercard">
                            </div>
                            <div class="row__col__img">
                                <img src="/img/icons/mir.svg" alt="mir">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row1__col2 row__col">
                <h2 class="row__col__heading">Доставка</h2>
                <div class="line-separator"></div>
                <div class="row__col__content">
                    <ul class="progress-steps">
                        <li class="progress-step">
                            <h3 class="progress-step-heading">Ввод данных</h3>
                            <p class="row__col__paragraph">Вводите адрес доставки и данные получателя.
                                По умолчанию берутся данные из профиля.</p>
                        </li>
                        <li class="progress-step">
                            <h3 class="progress-step-heading">Ввод данных</h3>
                            <p class="row__col__paragraph">Вводите адрес доставки и данные получателя.
                                По умолчанию берутся данные из профиля.</p>
                        </li>
                        <li class="progress-step">
                            <h3 class="progress-step-heading">Ввод данных</h3>
                            <p class="row__col__paragraph">Вводите адрес доставки и данные получателя.
                                По умолчанию берутся данные из профиля.</p>
                        </li>
                    </ul>
                </div>
                <p class="row__col__tip">Все вопросы, связанные с процессом доставки можно задать специалистам службы поддержки по телефону или написав письмо на почту.</p>
            </div>
        </article>
    </section>
@stop
