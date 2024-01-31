@auth

    @push('scripts')
        <script type="text/javascript">
            let urlGetNotification = '{{ route('getNotification') }}';
        </script>
        <script src="{!! asset('js/notification_mechanic.js') !!}" type="text/javascript"></script>
    @endpush

    <header class="header">
        <nav>
            <ul class="header__menu">
                <li class="header__menu-item-wrapper header__menu-item-tockens-wrapper">
                    <a href="{{ route('tokens') }}" class="header__menu-item" id="header__menu-link--tockens">
                        <div class="header__menu-item-img" style="margin-right: 7px">
                            <img style="max-height: 50px; max-width: 60px" src="{{asset("/img/money.png")}}" alt="">
                        </div>
                        <span class="userTokens">{{ \Auth::user()->bid }}</span>
                    </a>
                </li>
                <li class="header__menu-item-wrapper">
                    <button class="header__menu-item" id="header__menu-link--language"
                            style="background: url(&quot;/img/icons/languages/ru-RU.svg&quot;) center center / contain no-repeat;"></button>
                </li>
                <li class="header__menu-item-wrapper">
                    <a href="#" class="header__menu-item tooltip"
                       id="header__menu-link--notifications">
                        <div class="tooltip-text">
                            <div class="tooltip-content"></div>
                        </div>
                        <div class="header__menu-item-img">
                            <img src="/img/icons/nav/notifications.svg" alt="">
                        </div>
                        <div class="header-notification-unread unread"></div>
                    </a>
                </li>
                <li class="header__menu-item-wrapper header__menu-item-profile-wrapper">
                    <a href="https://t.me/flameauction" target="_blank" class="header__menu-item" id="header__menu-link--profile">
                        Telegram
                        <div class="header__menu-item-img user-avatar-wrapper">
                            @if($user->photo == null)
                                <img src="{{asset("/img/avatar.png")}}" alt="Ava" class="user-avatar">
                            @else
                                <img src="{{asset("storage/" . $user->photo)}}" alt="Ava" class="user-avatar">
                            @endif
                        </div>
                    </a>
                </li>
                <li class="header__menu-item-wrapper">
                    <a href="{{ route('logout') }}" class="header__menu-item" id="header__menu-link--logout">
                        <div class="header__menu-item-img">
                            <img src="/img/icons/nav/logout.svg" alt="">
                        </div>
                    </a>
                </li>
                <li class="header__menu-item-wrapper">
                    <a href="##" class="header__menu-item" id="header__menu-link--burger"></a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="general-banner">
        <a href="{{route('referral')}}">
            <img style="width: 100%" src="{{asset('/img/banner.svg')}}">
        </a>
        <span id="close-banner" onclick="closeBanner()">✖</span>
    </div>
    <style>
        .general-banner {
            position: relative;

        }
        #close-banner {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
    <script>
        function closeBanner() {
            // Здесь можно добавить код для скрытия баннера
            document.getElementsByClassName('general-banner')[0].style.display = 'none';

            // Установка cookie на 24 часа для отслеживания закрытия баннера
            var now = new Date();
            var expires = new Date();
            expires.setTime(now.getTime() + 24 * 60 * 60 * 1000); // 24 часа
            document.cookie = 'bannerClosed=true; expires=' + expires.toUTCString() + '; path=/';
        }

        // Проверка, был ли баннер закрыт ранее

            if (document.cookie.indexOf('bannerClosed=true') !== -1) {
                document.getElementsByClassName('general-banner')[0].style.display = 'none';
            }

    </script>

@else
    <header class="header">
        <div class="header-logout">
            <div class="container">
                <div class="header-logout__logo">
                    <a href="{!! route('home') !!}" class="logo-img">
                        <img src="/img/new-logo.svg" alt="">
                    </a>
                </div>

                <div class="bar">
                    <div class="bar__item"></div>
                    <div class="bar__item"></div>
                </div>

                <div class="header-logout__right">
                    @include('partial.topmenu')
                    <a href="{!! route('home') !!}" class="header-logout__btn2">Вход / Регистрация</a>
                    <div class="header-logout__social">
                        <!-- @todo куда ведет линка?????? -->
                        <a href="#" class="header-logout__social-link">Instagram</a>
                        <!-- @todo куда ведет линка?????? -->
                        <a href="#" class="header-logout__social-link">Telegram</a>
                        <!-- @todo куда ведет линка?????? -->
                        <a href="#" class="header-logout__social-link">{!! env('CONTACTS_EMAIL') !!}</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endauth
