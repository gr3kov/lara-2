document.write(`
<header class="header">
    <div class="header-logout">
        <div class="container">
        <div class="header-logout__logo">
            <a href="index.html" class="logo-img">
                <img src="./img/new-logo.svg" alt="">
            </a>
        </div>

            <div class="bar">
                <div class="bar__item"></div>
                <div class="bar__item"></div>
            </div>

            <div class="header-logout__right">
                <nav>
                    <ul>
                        <li>
                            <a href="faq.html">Как это работает?</a>
                        </li>
                        <!-- куда ведет линка?????? -->
                        <li>
                            <a href="#">Товары</a>
                        </li>
                        <li>
                            <a href="auctions.html">Аукционы</a>
                        </li>
                        <!-- куда ведет линка?????? -->
                        <li>
                            <a href="#">О нас</a>
                        </li>
                        <!-- куда ведет линка?????? -->
                        <li>
                            <a href="#">Отзывы</a>
                        </li>
                        <li>
                            <a href="faq.html">FAQ</a>
                        </li>
                    </ul>
                </nav>
                <a href="login.html" class="header-logout__btn2">Вход / Регистрация</a>
                <div class="header-logout__social">
                <!-- куда ведет линка?????? -->
                    <a href="#" class="header-logout__social-link">Instagram</a>
                    <!-- куда ведет линка?????? -->
                    <a href="#" class="header-logout__social-link">Telegram</a>
                    <!-- куда ведет линка?????? -->
                    <a href="#" class="header-logout__social-link">{!! env('CONTACTS_EMAIL') !!}</a>
                </div>
            </div>
        </div>
    </div>
</header>
`);
