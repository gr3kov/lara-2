@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/styles.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/tockens.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('./js/jquery-3.6.2.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="tockens">
        <h1 class="page__heading">{{ $title }}</h1>
        <div class="tockens__grid">
            @foreach ($token as $tokenItem)
                <article class="tockens__card">
                    <p class="tockens__card-roto">{{ number_format($tokenItem->value, 0, '.', ' ') }} FLAMES</p>
                    <div class="tockens__card-img">
                        <img src="{{ asset($tokenItem->image) }}" alt="">
                    </div>

                        <div class="tockens__card-bottom">
                            <p class="tockens__card-rubble">{{ number_format($tokenItem->price, 0, '.', ' ') }} $</p>
                            <button class="tockens__card-btn submit-btn is-active"
                                    onclick="window.location='{!! route('payment', ['type' => 'token', 'id' => $tokenItem->id]) !!}'">
                                Купить
                            </button>
                        </div>

                </article>
            @endforeach
        </div>
    </section>
@stop
