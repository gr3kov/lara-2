@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/notifications.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('./js/jquery-3.6.2.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/notifications.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="notifications">
        <h1 class="page__heading">{!! $title !!}</h1>
        <div class="notifications-wrapper new">
            @foreach ($notifications['new'] as $notificationsItem)
                <article class="notifications-card-wrapper">
                    <div class="notifications-card @if ($notificationsItem['unread']) is-unread @endif">
                        <div
                          class="notifications-card-img @if (isset($notificationsItem['auction'])) notifications-card-awardimg @endif">
                            @if (isset($notificationsItem['auction']))
                                <p
                                  class="notifications-card-awardimg-name">{{ $notificationsItem['auction']['title'] }}</p>
                                @if($notificationsItem['auction']['image'] != null)
                                <img src="{{ asset($notificationsItem['auction']['image']) }}" alt="">
                                @else
                                    <img src="{{asset('/img/icons/auction.svg')}}" alt="">
                                @endif
                            @else
                                <img src="{{ $notificationsItem['image'] }}" alt="">
                            @endif
                        </div>
                        <div class="notifications-card-text">
                            <p class="notifications-card-title">{{ $notificationsItem['title'] }}</p>
                            <p class="notifications-card-content">{!! $notificationsItem['text'] !!}</p>

                            @if (isset($notificationsItem['auction']))
                                <a href="{{ $notificationsItem['auction']['url'] }}" class="notifications-card-link">Перейти
                                    на страницу лота ></a>
                            @else
                                <button class="notifications-card-spoiler">Развернуть</button>
                            @endif
                        </div>
                        <p class="notifications-card-date">
                            {{ date('d/m/Y', $notificationsItem['date']) }}
                            <br>
                            {{ date('H:i', $notificationsItem['date']) }}
                        </p>
                        @if ($notificationsItem['unread'])
                            <div class="unread"></div> @endif

                        @if ($notificationsItem['unread'])
                            <div class="unread"></div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

    </section>
@stop
