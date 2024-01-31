<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    {!! \SEO::generate() !!}
    <meta name="yandex-verification" content="18d0abfd96894850" />
    <meta name="verification" content="71bf8c07ff1e929f0fbbc6cf496af4" />
    <link rel="preload" href="/css/style.css?v=c298c7f814431313d12112" as="style">
    <link rel="stylesheet" href="/css/style.css?v=c298c7f814431313d12112">
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap&subset=cyrillic" as="style">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap&subset=cyrillic" rel="stylesheet">
    <link rel="preload" href="/css/jquery.fancybox.min.css" as="style">
    <link rel="stylesheet" href="/css/jquery.fancybox.min.css">
    <link rel="preload" href="/css/animate.css" as="style">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="preload" href="/fonts/font.css" as="style">
    <link rel="stylesheet" href="/fonts/font.css">
    <link rel="preload" href="/css/slick.css" as="style">
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="preload" href="/css/slick-theme.css" as="style">
    <link rel="stylesheet" href="/css/slick-theme.css">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" as="style">
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(56674138, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/56674138" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<body>
@if(!Request::is('register') &&  !Request::is('login'))
    @if(Request::is('/'))
        <div id="popup_filter">
            <!-- <div class="btn_close"></div> -->
            <h2 class="popup_cap">Фильтр</h2>
            <input type="checkbox" class="checkbox" id="digital" />
            <label for="digital">Цифровая техника</label><br>
            <input type="checkbox" class="checkbox" id="tour" />
            <label for="tour">Туристические путевки</label><br>
            <input type="checkbox" class="checkbox" id="car" disabled/>
            <label for="car" class="disabled">Автомобили (скоро)</label>
        </div>
    @endif
    <div id="popup_urempty">
        <div id="bid_empty_close_button" class="btn_close"></div>
        <div class="buy_bid_img"><img src="/img/buy_bid.jpg" alt="купить ставки"></div>
        <div class="urempty_text">У вас закончились ставки.<br>Приобрести их можно<br>на странице покупки<br>пакета ставок</div>
        <a id="buy_bid_popup" class="btn_makebid notstarted">купить ставки</a>
    </div>
@endif

