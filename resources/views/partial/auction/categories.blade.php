<div class="auction__categories-wrapper swiper">
    <h3 class="auction__title">Категории</h3>
    <div class="auction__categories swiper-wrapper">
        @foreach ($categories as $category)
            <div class="auction__category swiper-slide">
                <ul class="auction__category-top">
                    @foreach ($category['auctionItems'] as $auctionItems)


                        <a href="{{route('item', ['id' => $auctionItems->id])}}">
                            <li class="auction__category-top-item">


                                    @if($auctionItems->preview_image != null)
                                        <img style="max-width: 94px;" src="{!! asset($auctionItems->preview_image) !!}"
                                             alt="{{ $auctionItems->name }}"/>
                                    @else
                                    <img style="max-width: 94px; max-height: 66px;" src="{{ asset('/img/icons/auction.svg') }}" alt="{{ $auctionItems->name }}">

                                @endif


                            </li>
                        </a>
                    @endforeach
                </ul>
                <div class="auction__category-bot">
                    <p>{{ $category['auctionCategory']->headline }}</p>
                    <a href="{{ route('category', $category['auctionCategory']->slug) }}"
                       class="auction__category-change-btn">Перейти</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="auction__categories-pagination"></div>
</div>
