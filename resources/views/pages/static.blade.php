@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/static.css') !!}" rel="stylesheet">
@endpush


@push('styles')
    <link href="{!! asset('https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/jquery-ui.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/styles.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/profile.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/slick.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/swiper-bundle.min.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('./js/jquery-3.6.2.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/itc__slider.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/jquery-ui.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/slick.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('./js/profile.js') !!}" type="text/javascript"></script>

@endpush

@section('content')
    <section class="page" id="publicoffer">
        <h1 class="page__heading">{!! $title !!}</h1>

        <div class="row__col">
            {!! $docs->description !!}
        </div>
    </section>
@stop
