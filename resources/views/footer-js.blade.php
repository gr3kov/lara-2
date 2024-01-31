<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DBSW1WV5K5"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-DBSW1WV5K5');
</script>

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
<script src="/js/jquery.dotdotdot.js"></script>
<script src="/js/jquery.fancybox.min.js"></script>
<script src="/js/slick.min.js"></script>
<script src="/js/script.js?v=c298c7f814431313d1211"></script>
<script src="/js/jquery.suggestions.min.js"></script>
@if(Request::is('register') || Request::is('login'))
    <script src="https://www.google.com/recaptcha/api.js"></script>
@endif
</body>
</html>
