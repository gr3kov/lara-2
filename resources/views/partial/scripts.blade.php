{{--<script src="{!! asset('js/thirdParty/jquery-3.6.4.min.js') !!}" type="text/javascript"></script>--}}
{{--<script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>--}}
@stack('scripts')

@if (!PH_DEBUG)
    <script src="https://7hd2-widget.happydesk.ru/widget.js" charset="utf-8"></script><script>Happydesk.initChat({clientId: 4322,server: 'https://7hd2-widget.happydesk.ru',host: 'roualauction.happydesk.ru' }, {page_url: window.location.href,user_agent: window.navigator.userAgent,language: 'ru'});</script>
@endif
