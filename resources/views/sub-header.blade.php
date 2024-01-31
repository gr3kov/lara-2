<header id="header" class="container" @if(\Auth::check()) @if(\Auth::user()->show_notifications == 1) data-show-info="1" @endif @endif>
    <div class="center">
        <div class="logo"><a href="{{ route('home') }}"><img src="/img/imperial_logo.svg" alt="Flame Auctoin" width="120px;"></a></div>
        @if(!\Auth::check() && !Request::is('register') && !Request::is('login'))
            <a class="btn_head" id="btn_enter" href="{{ route('register') }}">Регистрация</a>
        @endif
        @if(!Request::is('register') && !Request::is('login') && Request::is('/'))
{{--            <a class="btn_head" id="btn_filter" data-fancybox data-src="#popup_filter" href="javascript:;"><img src="../img/icon_filter.svg" alt="Фильтр"></a>--}}
        @endif
        @if(\Auth::check())
            <a href="" class="btn_head btn_notif"><img src="../img/icon_notification.svg" alt="Уведомления">
                @if(\Auth::user()->notification_count > 0) <div class="notif_value">{{ \Auth::user()->notification_count }} </div>@endif
            </a>
        @endif
        <a class="btn_head btn_menu" data-fancybox data-src="#main_menu" href="javascript:;"><img src="/img/icon_menu.svg" alt="Меню"></a>
    </div>
</header>
<div id="popup_action" class="popups">
    <div class="btn_close"></div>
    <img src="/img/banner-new-year-2020.jpg" alt="Акция Новогоднее удвоение">
    <div class="btn_makebid btn_large"><a class="banner_link" href="{{ route('pay') }}">купить ставки</a></div>
</div>
