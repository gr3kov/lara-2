@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css/swiper-bundle.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/winners.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/thirdParty/jquery-3.6.4.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/winners.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="page" id="winners">
        <h1 class="page__heading">{{ $title }}</h1>
        <div class="winners-ribbon">

            @foreach ($auctionItems as $auctionItem)

                <article class="winner-card-wrapper">
                    <div class="winner-card">
                        <div class="winner-card-heading">
                            <p class="winner-card-nickname">{{ $auctionItem->leader->email }}</p>
                            <p class="winner-card-date">{!! date('d/m/Y H:i', strtotime($auctionItem->updated_at)) !!}</p>
                        </div>
{{--                        <div class="winner-card-video-wrapper">--}}
{{--                            <video preload="auto" class="winner-card-video" poster="/img/dodq.png">--}}
{{--                                <source src="/img/man_eating_burger.webm" type="video/webm">--}}
{{--                            </video>--}}
{{--                            <button class="winner-card-video-playbtn"></button>--}}
{{--                        </div>--}}
                        <div class="winner-card-award">
                            <div class="winner-card-award-visual">
                                @if($auctionItem->preview_image != null)
                                    <img src="{{ asset($auctionItem->preview_image) }}" alt="">
                                @else
                                    <img src="{{asset('/img/icons/auction.svg')}}" alt="">
                                @endif
                            </div>
                            <h3 class="winner-card-award-name">{{ $auctionItem->name }}</h3>
                        </div>
{{--                        <p class="winner-card-review">Lorem ipsum dolor sit amet consectetur adipisicing elit.--}}
{{--                            Mollitia numquam, eveniet odit voluptatum molestiae, natus aspernatur minima,--}}
{{--                            possimus--}}
{{--                            magni eos esse dolorum ullam aliquid fugit ut veritatis error atque? Accusamus.</p>--}}
                    </div>
                </article>

            @endforeach

        </div>
    </section>
@stop
