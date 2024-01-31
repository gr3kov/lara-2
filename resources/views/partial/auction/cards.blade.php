@push('scripts')
    <script type="text/javascript">
        let urlLogin = '{{ route('login') }}',
            urlStartAuction = '/startAuction/',
            urlBid = '/bid/',
            urlGetAuctionBidsTable = '/getAuctionBidsTable/',
            pusherAppKey = '{{ env('PUSHER_APP_KEY') }}',
            pusherAppCluster = '{{ env('PUSHER_APP_CLUSTER') }}',
            pusherChannel = '{{ env('PUSHER_CHANNEL') }}',
            pusherEvent = '{{ env('PUSHER_EVENT') }}';
    </script>
    <script src="{!! asset('js/auction_mechanic.js') !!}" type="text/javascript"></script>
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
@endpush

<div class="auction__cards @if ($active) is-active @endif" @if (isset($slug) && $slug) id="{{ $slug }}" @endif>

    @foreach ($auctionItems as $auctionItem)
        <div class="auction__card goto auction_item"
             data-id="{{ $auctionItem->id }}"
             data-bet-size="{{ $auctionItem->bet_size }}"
             id="auction_{{ $auctionItem->id }}"
             target="{{ route('item', ['id' => $auctionItem->id]) }}">
            <div class="auction__card-visual">
                <div class="auction__card-img">
                    @if($auctionItem->preview_image != null)
                        <img src="{!! asset($auctionItem->preview_image) !!}" alt="">
                    @else
                        <img src="{{asset('/img/icons/auction.svg')}}" alt="{{$auctionItem->name}}">
                    @endif
                </div>
                @if($auctionItem->status_id<3)
                    @if ($auctionItem->deposit_value)
                        <div class="auction__card-sticker sticker-deposit type2">
                            <p class="auction__card-sticker-smp">Ваш депозит</p>
                            <p class="auction__card-sticker-bigp">{{$auctionItem->deposit_value->deposit_balance}}
                                FLAMES</p>
                        </div>
                    @elseif($auctionItem->deposit > 0)
                        <div class="auction__card-sticker sticker-deposit">
                            <p class="auction__card-sticker-smp">Депозит</p>
                            <p class="auction__card-sticker-bigp">{{$auctionItem->deposit}} FLAMES</p>
                        </div>
                    @endif
                @endif
                <div class="fav_button @if($auctionItem->is_favorite) active @endif">
                    <div class="text">Добавить в избранное</div>
                </div>
                @if ($auctionItem->bet_size > 1)
                    <div class="auction__card-sticker sticker-payment is-disabled">
                        <p class="auction__card-sticker-p">{{$auctionItem->bet_size}} FLAMES</p>
                        <p class="auction__card-sticker-p">Стоимость клика</p>
                    </div>
                @endif
                @if (isset($canPay) && $auctionItem->payed == 1 && $auctionItem->canPay)
                    <div class="auction__card-sticker sticker-payment is-disabled">
                        <p class="auction__card-sticker-p">Оплачено</p>
                    </div>
                @endif
                @if (!empty($auctionItem->leader))
                    <div class="auction__card-sticker sticker-email type2">
                        <p class="auction__card-sticker-p name">@if($auctionItem->status_id==3)
                                Победитель
                            @else
                                Лидер
                            @endif</p>
                        <p class="auction__card-sticker-p">{!! $auctionItem->leader->name !!}</p>
                    </div>
                @endif
            </div>
            <div class="auction__card-text">
                <h6 class="auction__card-heading">
                    <span class="auction__card-name">{{ $auctionItem->name }}</span><span class="auction__card-cost">{{ number_format($auctionItem->price, 0, '.', ' ') }}
                        р.</span>
                </h6>
                @if (!is_null($auctionItem->all_slots))
                    <p class="auction__card-smp">
                        Свободно мест:
                        <span class="auction__card-placesleft"><span class="free">{{ $auctionItem->free_slots }}</span>
                            из <span class="all">{{ $auctionItem->all_slots }}</span></span>
                    </p>
                @endif
                @if ($auctionItem->time_left == 'bid' || $auctionItem->status->code != 'completed')
                    <div class="auction__card-date @if ($auctionItem->status->code != 'start') is-timer @endif">
                        @if ($auctionItem->status->code == 'start')
                            <p>Начало</p>
                            <p
                                class="auction__card-date-value">{{ date('d/m/y H:i', strtotime($auctionItem->time_to_start)) }}</p>
                        @elseif (($auctionItem->status->code != 'completed') || ($auctionItem->time_left > 0))
                            <p
                                class="auction__card-date-value">{{ $auctionItem->timer['dv_all'] }}</p>
                            <p class="auction__card-date-value time_left"
                               data-time-left="{{ $auctionItem->timer['time_left'] }}">{{ $auctionItem->timer['dv_left'] }}</p>
                        @endif
                    </div>
                @endif
            </div>
            {{--<a href="lot.html" class="auction__card-btn is-enabled">Участвовать</a>--}}
            <button data-id="{{ $auctionItem->id }}"
                    class="auction__card-btn button
                    @if($auctionItem->status->code == 'start') notstarted is-enabled
                    @elseif($auctionItem->status->code == 'bid' || $auctionItem->time_left > 0)
                    @if(isset($auctionItem->is_member))
                    @if(!$auctionItem->is_member) started bid is-enabled @endif
                    @endif
                      lot-first bid is-enabled
@elseif($auctionItem->status->code == 'completed' || $auctionItem->time_left == 0) finished is-disabled
                    @else bid is-enabled @endif"
                    @if($auctionItem->status->code == 'start')
                        data-dv-all="{{ $auctionItem->timer['dv_all'] }}"
                    data-time-left="{{ $auctionItem->timer['time_left'] }}"
                    data-dv-left="{{ $auctionItem->timer['dv_left'] }}"
                @endif >
                @if (isset($canPay) && $auctionItem->payed == 0 && $auctionItem->canPay)
                    Оплатить
                @elseif (isset($canPay) && $auctionItem->payed == 1 && $auctionItem->canPay)
                    Оплачен
                @elseif ($auctionItem->time_left == 0 && $auctionItem->status->code !== 'start')
                    Завершен
                @else
                    @if(isset($auctionItem->is_member))
                        @if(($auctionItem->status->code == 'bid')&&($auctionItem->is_member))
                            <span>ПЕРЕБИТЬ</span>
                            <img src="/img/buy-crypto.svg" alt="">
                            <span>{{$auctionItem->bet_size}} FLAMES</span>
                            <span class="flare"></span>
                        @elseif (($auctionItem->status->code=='start')&&($auctionItem->deposit_value))
                            Вы участвуете
                        @else
                            {{ $auctionItem->status->name }}
                        @endif
                    @endif
                @endif
            </button>
        </div>

    @endforeach

</div>
