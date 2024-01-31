document.write(`
<footer class="footer-logout">
    <div class="container">
        <div class="footer-logout__top">
            <div class="logo">
                <a href="index.html" class="logo-img">
                    <img src="./img/new-logo.svg" alt="">
                </a>
            </div>

            <ul class="footer-logout__spisok">
                <li><a href="https://instagram.com/{!! env('CONTACTS_INSTAGRAM') !!}">Instagram</a></li>
                <li><a href="{!! env('CONTACTS_TELEGRAM') !!}">Telegram</a></li>
                <li><a href="mailto:{!! env('CONTACTS_EMAIL') !!}">{!! env('CONTACTS_EMAIL') !!}</a></li>
            </ul>
        </div>
        <div class="footer-logout__bottom">
            <div class="footer-logout__bottom-block">
                <ul>
                    <li><a class="footer__menu-link" href="{!! route('delivery') !!}">Доставка и оплата</a></li>
                    <li><a class="footer__menu-link" href="{!! route('winners') !!}">Лента победителей</a></li>
                    <li><a class="footer__menu-link" href="{!! route('referral') !!}">Партнёрская программа</a></li>
                </ul>
            </div>

            <div class="footer-logout__bottom-block">
                <ul>
                    <li><a class="footer__menu-link" href="{!! route('offer') !!}">Публичная оферта</a></li>
                    <li><a class="footer__menu-link" href="{!! route('security') !!}">Гарантия безопасности</a></li>
                    <li><a class="footer__menu-link" href="{!! route('agreement') !!}">Пользовательское соглашение</a></li>
                </ul>
            </div>

            <div class="footer-logout__bottom-block footer-logout__bottom-tactik">
                <ul>
                    <li><a class="footer__menu-link" href="{!! route('tactics') !!}">Тактика победы</a></li>
                </ul>
            </div>

            <div class="footer-logout__bottom-copy">
                Flame auction© {{ date('Y') }}. All rights reserved
            </div>
        </div>
    </div>
</footer>
`);
