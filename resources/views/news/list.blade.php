@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/news.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="news">
        <h1 class="page__heading">{!! $title !!}</h1>
        <div class="news-wrapper">

            @foreach ($news as $newsItem)
            <article class="news-card-wrapper">
                <div class="news-card">
                    <div class="news-card-img">
                        <img src="@if (!empty($newsItem->image)) {{ asset($newsItem->image) }} @else /img/news.jpg @endif" alt="">
                    </div>
                    <div class="news-card-heading">
                        <p class="news-card-title">{{ $newsItem->title }}</p>
                        <p class="news-card-date">{{ date('d/m/Y H:i', strtotime($newsItem->created_at)) }}</p>
                    </div>
                    <p class="news-card-text">{!! $newsItem->text !!}</p>
                </div>
            </article>
            @endforeach

        </div>
    </section>
@stop
