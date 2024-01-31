@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/settings.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/settings.js') !!}" type="text/javascript"></script>
    <script type="text/javascript">
        let urlAvatarChange = '{{ route('avatarChange') }}',
            csrfTokenAvatarChange = '{{ csrf_token() }}';
    </script>
    <script src="{!! asset('./js/jquery-3.6.2.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/itc__slider.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/jquery-ui.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/slick.min.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="settings">
        <h1 class="page__heading">{{ $title }}</h1>

        {{ $errors->first('lastname') }}

        {{--@error('code')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror--}}
        {{--@if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $kod => $error)
              <li>{{ $kod }}error - {{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif--}}

        <form action="{{ route('settings') }}" method="post" enctype="multipart/form-data">
            @csrf
            <article class="row1">
                <div class="row1__col1 row__col">
                    <h3 class="settings-heading">Личные данные</h3>
                    <div class="line-separator"></div>
                    <ul class="settings-userdata">
                        <li class="settings-userdata-row @if($errors->has('firstname')) error @endif">
                            <div class="settings-userdata-item">
                                <div class="settings-userdata-item__title">
                                    <h3 class="settings-userdata-item__label">Имя</h3>
                                </div>
                                <div class="settings-userdata-item__wrapper">
                                    <div class="settings-input_non-icon">
                                        <input
                                            class="settings-input_non-icon"
                                            type="text"
                                            id="settings-userdata--firstname"
                                            name="firstname"
                                            @if ($user->firstname) value="{{ $user->firstname }}"
                                            @else value="{{ old('firstname') }}" @endif
                                        />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="settings-userdata-row">
                            <div class="settings-userdata-item">
                                <div class="settings-userdata-item__title">
                                    <h3 class="settings-userdata-item__label">
                                        Instagram
                                    </h3>
                                    <span class="status-label is-disabled"
                                    >Не подтвержден</span
                                    >
                                </div>
                                <div class="settings-userdata-item__wrapper">
                                    <div class="settings-userdata-item__input">
                                        <img
                                            src="./img/icons/instagram_placeholder.svg"
                                            alt=""
                                        />
                                        <input
                                            class="settings-input"
                                            type="text"
                                            id="settings-userdata--instagram" placeholder=""
                                            name="instagram"
                                            @if ($user->instagram) value="{{ $user->instagram }}" @endif
                                        />
                                    </div>
                                    <button id="add-instagram-btn" type="button">
                                        Подтвердить
                                    </button>
                                </div>
                            </div>
                        </li>
                        <li class="settings-userdata-row @if($errors->has('lastname')) error @endif">
                            <div class="settings-userdata-item">
                                <div class="settings-userdata-item__title">
                                    <h3 class="settings-userdata-item__label">Фамилия</h3>
                                </div>
                                <div class="settings-userdata-item__wrapper">
                                    <div class="settings-input_non-icon">
                                        <input
                                            class="settings-input_non-icon"
                                            type="text"
                                            id="settings-userdata--lastname"
                                            name="lastname"
                                            @if ($user->lastname) value="{{ $user->lastname }}"
                                            @else value="{{ old('lastname') }}" @endif
                                        />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="settings-userdata-row @if($errors->has('phone')) error @endif">
                            <div class="settings-userdata-item">
                                <div class="settings-userdata-item__title">
                                    <h3 class="settings-userdata-item__label">Телефон</h3>
                                    <span class="status-label is-enabled">Подтвержден</span
                                    >
                                </div>
                                <div class="settings-userdata-item__wrapper">
                                    <div class="settings-userdata-item__input">
                                        <input
                                            class="settings-input"
                                            type="text"
                                            name="phone"
                                            id="settings-userdata--phone"
                                            placeholder="+7" name="phone"
                                            @if ($user->phone) value="{{ $user->phone }}"
                                            @else value="{{ old('phone') }}" @endif
                                        />
                                    </div>
                                    <button id="add-instagram-btn" type="button">
                                        Подтвердить
                                    </button>
                                </div>
                            </div>
                        </li>
                        <li class="settings-userdata-row @if($errors->has('patronymic')) error @endif">
                            <div class="settings-userdata-item">
                                <div class="settings-userdata-item__title">
                                    <h3 class="settings-userdata-item__label">
                                        Отчество
                                    </h3>
                                </div>
                                <div class="settings-userdata-item__wrapper">
                                    <div class="settings-input_non-icon">
                                        <input
                                            class="settings-input_non-icon"
                                            type="text"
                                            id="settings-userdata--middletname"
                                            name="patronymic"
                                            @if ($user->patronymic) value="{{ $user->patronymic }}"
                                            @else value="{{ old('patronymic') }}" @endif
                                        />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="settings-userdata-row">
                            <div class="settings-userdata-item">
                                <div class="settings-userdata-item__title">
                                    <h3 class="settings-userdata-item__label">E-mail</h3>
                                    @if($user->confirmed == 0)
                                        <span class="status-label is-disabled">Не подтвержден</span>
                                    @elseif($user->confirmed == 1)
                                        <span class="status-label is-enabled">Подтверждён</span>
                                    @endif
                                </div>
                                <div class="settings-userdata-item__wrapper">
                                    <div class="settings-userdata-item__input">
                                        <input
                                            class="settings-input"
                                            type="text"
                                            id="settings-userdata--email"
                                            placeholder="email@example.com"
                                            name="email"
                                            @if ($user->email) value="{{ $user->email }}" @endif
                                        />
                                    </div>
                                    @if($user->confirmed != 1)
                                        <button id="add-instagram-btn" onclick="sendVerifyEmail()" type="button">
                                            Подтвердить
                                        </button>
                                    @endif
                                </div>
{{--                                <span class="settings-userdata-item__desc">Повторно можно отправить код через: 0:47 сек</span>--}}
                            </div>
{{--                            <div class="system-msg">--}}
{{--                                Письмо для подтверждения было направлено на почту--}}
{{--                                <span class="tooltip">--}}
{{--                                    <span class="tooltip-text">Краткое пояснение к<br/>какому-либо элементу.<br/>Использовать тег br. </span>--}}
{{--                                </span>--}}
{{--                            </div>--}}
                        </li>
                    </ul>
                </div>
                <script>
                    function sendVerifyEmail() {
                        // URL where you want to send the POST request
                        const url = '{{route("sendVerifyEmail")}}';

                        // Data to be sent in the request body (adjust accordingly)
                        const data = {
                            email: 'user@example.com',
                            // add more data as needed
                        };

                        // Fetch options for the POST request
                        const options = {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json', // specify the content type as JSON
                                // add any other headers if needed
                            },
                        };

                        // Perform the fetch POST request
                        fetch(url, options)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json(); // assuming the response is in JSON format
                            })
                            .then(data => {
                                // Handle the response data here
                                if (data.status === true) {
                                    toastr.success("Вам отправлена ссылка на электронную почту", 'Успех')
                                } else {
                                    toastr.error(data.message, 'Error')
                                }
                            })
                            .catch(function (error, message) {

                                toastr.error(error, 'Error');
                            });
                    }
                </script>

                <div class="row1__cols23">
                    <div class="row1__col2 row__col">
                        <div class="row1__col2-content">
                            <div class="user-avatar-wrapper">
                                @if($user->photo == null)
                                    <img id="user-avatar" src="{{asset("/img/avatar.png")}}" alt="Ava" class="user-avatar">
                                @else
                                    <img id="user-avatar" src="{{asset("storage/" . $user->photo)}}" alt="Ava" class="user-avatar">
                                @endif
                            </div>
                            <a href="{{ route('avatarDelete') }}" class="row1__col2-text-delete">Удалить аватар</a>
                            <input type="file" name="photo" style="display: none" id="photo">
                        </div>
                        <button type="button" id="change-photo" class="gray-btn">Сменить аватар</button>
                        <script>
                            $(document).ready(function () {
                                $("#change-photo,#user-avatar").on('click', function () {
                                    $("#photo").click();
                                });

                                $("#photo").on('change', function () {
                                    // Получаем выбранный файл
                                    var input = this;
                                    var file = input.files[0];

                                    if (file) {
                                        // Читаем файл как Data URL
                                        var reader = new FileReader();
                                        reader.onload = function (e) {
                                            // Устанавливаем src изображения в Data URL
                                            $("#user-avatar").attr('src', e.target.result);
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                });
                            });
                        </script>
                    </div>
                    <div class="telegram">
                        <div class="telegram__title">
                            <h3 class="settings-heading">Telegram</h3>
                            <span class="status-label is-disabled"
                            >Не подтвержден</span
                            >
                        </div>
                        <div class="telegram__wrapper @if($errors->has('telegram')) error @endif">
                            <div class="telegram__input">
                                <img
                                    src="./img/icons/telegram_placeholder.svg"
                                    alt=""
                                />
                                <input
                                    class="settings-input"
                                    type="text"
                                    id="settings-userdata--telegram"
                                    name="telegram"
                                    @if ($user->telegram) value="{{ $user->telegram }}"
                                    @else value="{{ old('telegram') }}" @endif
                                    placeholder="Telegram не подключен"
                                />
                            </div>
                            <button id="add-telegram-btn" type="button">
                                Подключить
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            <article class="row2">
                <div class="row2__col1 row__col">
                    <h3 class="settings-heading">Адрес для доставки</h3>
                    <div class="line-separator"></div>
                    <ul class="settings-useradress">
                        <li class="settings-useradress-item form-item">
                            <label for="settings-useradress--region" class="settings-label">Регион</label>
                            <input class="settings-input" type="text" id="settings-useradress--region"
                                   name="delivery_region"
                                   @if ($user->delivery_region) value="{{ $user->delivery_region }}" @endif>
                        </li>
                        <li class="settings-useradress-item form-item">
                            <label for="settings-useradress--city" class="settings-label">Город</label>
                            <input class="settings-input" type="text" id="settings-useradress--city"
                                   name="delivery_city"
                                   @if ($user->delivery_city) value="{{ $user->delivery_city }}" @endif>
                        </li>
                        <li class="settings-useradress-item form-item">
                            <label for="settings-useradress--street" class="settings-label">Улица</label>
                            <input class="settings-input" type="text" id="settings-useradress--street"
                                   name="delivery_street"
                                   @if ($user->delivery_street) value="{{ $user->delivery_street }}" @endif>
                        </li>
                        <li class="settings-useradress-item form-item">
                            <label for="settings-useradress--house" class="settings-label">Дом</label>
                            <input class="settings-input" type="text" id="settings-useradress--house"
                                   name="delivery_house"
                                   @if ($user->delivery_house) value="{{ $user->delivery_house }}" @endif>
                        </li>
                    </ul>
                    <div class="settings-useradress-item form-item"
                         style="flex-direction: row; align-items: center; margin: 15px 0 0;">
                        <label for="settings-useradress--index" class="settings-label" style="margin: 0 15px 0 0;">Индекс:</label>
                        <p id="settings-useradress--index" style="font-size: 12px;color: rgba(255, 255, 255, 0.4);
                                ">137521287</p>
                    </div>
                </div>
                <div class="row2__col2 row__col">
                    <h3 class="settings-heading">Уведомления</h3>
                    <div class="line-separator"></div>
                    <ul class="settings-usernotifications">
                        <li class="settings-usernotifications-item form-item @if($errors->has('news_notification')) error @endif">
                            <input type="checkbox" id="settings-usernotifications--news" name="news_notification"
                                   @if($user->news_notification) checked @endif>
                            <label for="settings-usernotifications--news" class="settings-label">Уведомлять о появлении
                                новинок</label>
                        </li>
                        <li class="settings-usernotifications-item form-item @if($errors->has('mailing')) error @endif">
                            <input type="checkbox" id="settings-usernotifications--promo" name="mailing"
                                   @if($user->mailing) checked @endif>
                            <label for="settings-usernotifications--promo" class="settings-label">Получать письма о
                                промо-акциях</label>
                        </li>
                    </ul>
                </div>
            </article>
            <article class="row3">
                <div class="row3__col1 row3__col row__col">
                    <div class="row3__col__block1">
                        <div class="row3__col__img">
                            <img src="/img/icons/creditcard.svg" alt="">
                        </div>
                        <div class="row3__col__text">
                            <p class="row3__col__key">Карта для вывода</p>
                            <p class="row3__col__value"></p>
                        </div>
                        <div class="status-label is-disabled">Не задана</div>
                    </div>
                    <div class="row3__col__block2">
                        <button class="gray-btn row3__col__gray-btn" for="cardchange">Подключить</button>
                    </div>
                </div>
                <div class="row3__col2 row3__col row__col">
                    <div class="row3__col__block1">
                        <div class="row3__col__img">
                            <img src="/img/icons/country.svg" alt="">
                        </div>
                        <div class="row3__col__text">
                            <p class="row3__col__key">Страна</p>
                            <p class="row3__col__value user-country-value">Российская федерация</p>
                        </div>
                        <select class="user-country-select">
                            <option value="russia" class="user-country-option">Российская федерация</option>
                            <option value="iran" class="user-country-option">Иран</option>
                            <option value="afghanistan" class="user-country-option">Афганистан</option>
                            <option value="syria" class="user-country-option">Сирия</option>
                            <option value="serbia" class="user-country-option">Сербия</option>
                            <option value="northkorea" class="user-country-option">Северная Корея</option>
                        </select>
                    </div>
                    <div class="row3__col__block2">
                        <div class="line-separator"></div>
                        <p class="system-msg">Страна была установлена автоматически
                        </p>
                    </div>
                </div>
                <div class="row3__col3 row3__col row__col">
                    <div class="row3__col__block1">
                        <div class="row3__col__img">
                            <img src="/img/icons/password.svg" alt="">
                        </div>
                        <div class="row3__col__text">
                            <p class="row3__col__key">Пароль</p>
                            <p class="row3__col__value">******</p>
                        </div>
                    </div>
                    <div class="row3__col__block2">
                        <button class="gray-btn row3__col__gray-btn" for="passchange">Изменить</button>
                    </div>
                </div>
            </article>
            <input type="submit" class="submit-btn" style="margin-bottom: 50px" value="Сохранить">
        </form>
    </section>

    <div class="settings-passchange-modal-wrapper modal-wrapper">
        <form class="settings-passchange-modal modal" id="passchange" action="#">
            <h3 class="settings-heading">Смена пароля</h3>
            <div class="line-separator"></div>
            <ul class="settings-passchange">
                <li class="settings-passchange-item form-item">
                    <label for="settings-passchange--oldpass" class="settings-label">Старый пароль</label>
                    <input class="settings-input" type="password" id="settings-passchange--oldpass">
                </li>
                <li class="settings-passchange-item form-item">
                    <label for="settings-passchange--newpass" class="settings-label">Новый пароль</label>
                    <input class="settings-input" type="password" id="settings-passchange--newpass">
                </li>
                <li class="settings-passchange-item form-item">
                    <label for="settings-passchange--repeatpass" class="settings-label">Повтор пароля</label>
                    <input class="settings-input" type="password" id="settings-passchange--repeatpass">
                </li>
            </ul>
            <p class="system-msg">Минимум 6 символов, не менее 1 цифры, хотя бы 1 символ с верхним регистром</p>
            <input type="submit" class="submit-btn" value="Сохранить">
        </form>
    </div>
    <div class="settings-cardchange-modal-wrapper modal-wrapper">
        <form class="settings-cardchange-modal modal" id="cardchange" action="#">
            <h3 class="settings-heading">Платёжные данные</h3>
            <div class="line-separator"></div>
            <ul class="settings-cardchange">
                <li class="settings-cardchange-item form-item">
                    <label for="settings-cardchange--cardnum" class="settings-label">Номер банковской
                        карты</label>
                    <input class="settings-input" type="text" id="settings-cardchange--cardnum">
                </li>
                <li class="settings-cardchange-item form-item">
                    <label for="settings-cardchange--cardexp" class="settings-label">EXP</label>
                    <input class="settings-input" type="text" id="settings-cardchange--cardexp"
                           placeholder="MM/YY">
                </li>
                <li class="settings-cardchange-item form-item">
                    <label for="settings-cardchange--cardname" class="settings-label">Имя владельца</label>
                    <input class="settings-input" type="text" id="settings-cardchange--cardname">
                </li>
            </ul>
            <input type="submit" class="submit-btn" value="Сохранить">
        </form>
    </div>
@stop
