<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{!! asset('css/styles.css') !!}">

<link rel="apple-touch-icon" sizes="180x180" href="{!! asset('img/icons/favicon/favicon.svg') !!}">
<link rel="icon" type="image/png" sizes="32x32" href="{!! asset('img/icons/favicon/favicon.svg') !!}">
<link rel="icon" type="image/png" sizes="16x16" href="{!! asset('img/icons/favicon/favicon.svg') !!}">
<link rel="manifest" href="{!! asset('img/icons/favicon/site.webmanifest') !!}">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#000000">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

@stack('styles')
{!! SEO::generate() !!}

<link rel="stylesheet" href="{{asset('/css/toastr.min.css')}}">
<script src="{{asset('/js/toastr.min.js')}}"></script>
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
