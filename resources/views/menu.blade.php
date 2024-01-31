@if(!\Auth::check())
    <div id="main_menu">
        <!-- <div class="btn_back"></div> -->
        <div class="menu_content">
            <a href="{{ route('login') }}" class="btn_makebid">купить ставки</a>
            <ul>
                <li class="menu_how">
                    @if(Request::is('register'))
                        <a href="{{ route('login') }}">Вход</a>
                    @elseif(!Request::is('register') && !Request::is('login'))
                        <a href="{{ route('login') }}">Вход</a> /
                        <a href="{{ route('register') }}">Регистрация</a>
                    @else
                        <a href="{{ route('register') }}">Регистрация</a>
                    @endif
                </li>
                <hr>
                <li class="menu_how"><a href="{{ route('how') }}">Как это работает</a></li>
                <li class="menu_deliver"><a href="{{ route('delivery') }}">Доставка</a></li>
                <li class="menu_qa"><a href="{{ route('faq') }}">Вопросы и ответы</a></li>
                <li class="menu_tactics"><a href="{{ route('tactics') }}">Тактика победы</a></li>
                <li class="menu_winners"><a href="{{ route('archive') }}">Победители аукционов</a></li>
{{--                <li class="menu_partners"><a href="{{ route('partners') }}">Партнерская программа</a></li>--}}
{{--                <li class="menu_payvar"><a href="{{ route('pay-methods') }}">Способы пополнения счета</a></li>--}}
                <li class="menu_favorite"><a href="{{ route('categories') }}">Категории</a></li>
                <li class="menu_about"><a href="{{ route('about') }}">О нас</a></li>
                <hr>
{{--                <li class="menu_support">Техподдержка</li>--}}

                <li>
                    <div class="label">
                        <a href="mailto:info@imperialonline.ru">info@imperialonline.ru</a>
                    </div>
                </li>
                <li class="menu_insta"><a target="_blank" href="https://instagram.com/imperialonline.ru">imperialonline.ru</a></li>
                <li class="menu_telegram"><a target="_blank" href="https://tlgg.ru/joinchat/AAAAAEk0YG_O5g9ylgRR7w">Телеграм канал</a></li>

                <hr>
                <li class="menu_doclist"><a href="{{ route('agreement') }}">Пользовательское соглашение</a></li>
                <li class="menu_doclist"><a href="{{ route('agreement') . '#personalBefore' }}">Политика конфиденциальности</a></li>
                <li class="menu_doclist"><a href="{{ route('offer') }}">Публичная оферта</a></li>
                <li class="menu_doclist"><a href="{{ route('security') }}">Гарантия безопасности</a></li>
            </ul>
            <a class="pay_method_image" href="{{ route('security') }}" target="_blank">
                <img src="../img/logos/Uniteller_Visa_MasterCard_MIR_1.png" alt="visa or mastercard">
            </a>
        </div>
    </div>
@else
    <div id="main_menu">
        <!-- <div class="btn_back"></div> -->
        <div class="menu_content">
            <div class="user_profile">

                <div class="user_photo"><img src="/img/default_photo.jpg"></div>
                <div class="user_info">
                    <div class="user_name"><a href="https://instagram.com/{{ \Auth::user()->user_insta }}" target="_blank">{{ '@' . \Auth::user()->user_insta }}</a></div>
                    <div class="bets_aval">Доступно ставок: <span class="available_bid">{{ \Auth::user()->bid }}</span></div>
                </div>
            </div>
            <ul>
                <li class="menu_profile"><a href="{{ route('profile') }}">Профиль</a></li>
                <li class="menu_favorite"><a href="{{ route('my-auction') }}">Мои аукционы</a></li>
                <li class="menu_mybid"><a href="{{ route('my-bids') }}">Мои ставки</a></li>
            </ul>
            <a href="{{ route('pay') }}" class="btn_makebid">купить ставки</a>
            <ul>
                <li class="menu_logout"><a href="{{ route('logout') }}">Выход</a></li>
                <hr>
                <li class="menu_how"><a href="{{ route('how') }}">Как это работает</a></li>
                <li class="menu_deliver"><a href="{{ route('delivery') }}">Доставка</a></li>
                <li class="menu_qa"><a href="{{ route('faq') }}">Вопросы и ответы</a></li>
                <li class="menu_tactics"><a href="{{ route('tactics') }}">Тактика победы</a></li>

                <li class="menu_winners"><a href="{{ route('winners') }}">Победители аукционов</a></li>
{{--                <li class="menu_partners"><a href="{{ route('partners') }}">Партнерская программа</a></li>--}}
{{--                <li class="menu_about"><a href="{{ route('pay-methods') }}">Способы пополнения счета</a></li>--}}
                <li class="menu_favorite"><a href="{{ route('category') }}">Категории</a></li>
                <li class="menu_about"><a href="{{ route('about') }}">О нас</a></li>
                <hr>
{{--                <li class="menu_support">Техподдержка</li>--}}

                <li>
                    <div class="label">
                        <a href="mailto:info@imperialonline.ru">info@imperialonline.ru</a>
                    </div>
                </li>
                <li class="menu_insta"><a target="_blank" href="https://instagram.com/imperialonline.ru">imperialonline.ru</a></li>
                <li class="menu_telegram"><a target="_blank" href="https://tlgg.ru/joinchat/AAAAAEk0YG_O5g9ylgRR7w">Телеграм канал</a></li>

                <hr>
                <li class="menu_doclist"><a href="{{ route('agreement') }}">Пользовательское соглашение</a></li>
                <li class="menu_doclist"><a href="{{ route('agreement') . '#personalBefore' }}">Политика конфиденциальности</a></li>
                <li class="menu_doclist"><a href="{{ route('offer') }}">Публичная оферта</a></li>
                <li class="menu_doclist"><a href="{{ route('security') }}">Гарантия безопасности</a></li>
            </ul>
            <a class="pay_method_image" href="{{ route('security') }}" target="_blank">
                <img src="../img/logos/Uniteller_Visa_MasterCard_MIR_1.png" alt="visa or mastercard">
            </a>
        </div>
    </div>
@endif
