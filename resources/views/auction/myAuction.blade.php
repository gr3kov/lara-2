@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/auctions.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/swiper-bundle.min.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/thirdParty/jquery-3.6.4.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/auctions.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="auctions">
        <h1 class="page__heading">{{ $title }}</h1>
        <div class="auction">
            <section class="auction__main">

                @include('partial.auction.search')

                @include('partial.auction.pageNavigation')

                <article class="auction__content">

                    @foreach ($pageNavigation as $pageNavigationItem)
                        @include('partial.auction.cards', [
                            'auctionItems' => $pageNavigationItem['auctionItems'],
                            'slug' => $pageNavigationItem['slug'],
                            'active' => $pageNavigationItem['active']
                        ])
                    @endforeach

                </article>
            </section>


        </div>
    </section>
@stop
