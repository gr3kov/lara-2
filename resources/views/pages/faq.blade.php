@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/faq.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/thirdParty/jquery-3.6.4.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/faq.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="faq">
        <h1 class="page__heading">{!! $title !!}</h1>

        <div class="row__col">
            <ul class="faq-list">

                @foreach ($array as $item)
                    <li class="faq-item">
                        <div class="faq-item-heading">
                            <h4 class="faq-item-title">{!! $item['question'] !!}</h4>
                            <button class="faq-item-spoiler"></button>
                        </div>
                        <p class="faq-item-text">{!! $item['answer'] !!}</p>
                    </li>
                @endforeach

            </ul>
        </div>
    </section>
@stop
