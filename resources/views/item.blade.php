@include('header')

@include('menu')

<div class="overlay"></div>

<div class="wrapper">
    <div class="content auction_item" data-id="{{ $data['item']->id }}" id="auction_{{$data['item']->id}}" >
        @include('sub-header')
        <div id="item_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="{{ url()->previous() }}" class="go_tomain"></a>
                    <h2>{{ $data['item']->name }}</h2>
                </div>
                <div class="item_maininfo">
                    <ul class="item_slider">
                        @foreach($data['item']['images'] as $image)
                            <li><img src="{{ '../' . $image }}" alt=""></li>
                        @endforeach
                    </ul>
                    <div class="item_maindescr">
                        <h3>Основные характеристики:</h3>
                        {!! $data['item']->characteristic !!}
                        <div class="btn_itemmoreinfo">Подробнее смотрите ниже</div>
                    </div>
                </div>
                <div class="item_block">
                    <div class="item_buyblock">
                        <div class="item_bid_aval">
                            <div class="item_buydata">
                                <div class="available_bid">
                                @if(!empty($data['user']))
                                    {{ $data['user']->bid ? $data['user']->bid : 0 }}
                                @else
                                    0
                                @endif
                                </div>
                                <a href="{{ route('pay') }}" class="btn_add">+</a>
                            </div>
                            <div class="label">ставок</div>
                        </div>
                        <div class="item_current_price">
                            <div class="curprice item_buydata">{{ $data['item']->price }}</div>
                            <div class="label">стоимость</div>
                        </div>
                        <div class="item_time_left">
                            <div data-time-left="{{ $data['item']->status->code == 'completed' ? 0 : $data['item']->time_left }}" class="item_buydata time_left">{{ (floor($data['item']->time_left / 60) < 10 ? '0' : '') . floor($data['item']->time_left / 60) . ':' . ($data['item']->time_left % 60 < 10 ? '0' . $data['item']->time_left % 60 : $data['item']->time_left % 60) }}</div>
                            <div class="label">осталось</div>
                        </div>
                       <div data-id="{{ $data['item']['id'] }}" class="mybids @if($data['isFavorite']) mybids_active @endif"></div>
                    </div>
                    <hr>
                    @if($data['item']->status->code !== 'start' &&  $data['leader'])
                        <div class="curwinner_block">
                            <div class="curwinner_photo"><img class="curwinner_photo_img" src="{{ $data['item']->status->code !== 'start' ?  '/img/default_photo.jpg' : ""}}" alt=""></div>
                            <a target="_blank" href="https://instagram.com/{{ $data['item']->status->code !== 'start' && isset($data['leader']) ? $data['leader']->user_insta : ""}}" class="curwinner_name">{{ $data['item']->status->code !== 'start' && isset($data['leader']) ? $data['leader']->user_insta : ""}}</a>
                        </div>
                    @endif
                    <table class="bidlist">
                        @foreach($data['bids'] as $bid)
                            <tr>
                                <td>{{ $bid->created_at }}</td>
                                @php
                                    $user_insta = '';
                                    if (!empty(App\User::find($bid->user_id)['user_insta'])) {
                                        $user_insta = App\User::find($bid->user_id)['user_insta'];
                                    }
                                @endphp
                                <td><a target="_blank" href="https://instagram.com/{{ $user_insta }}">{{ '@' . $user_insta }}</a></td>
                                <td>{{ $bid->new_price }}</td>
                            </tr>
                        @endforeach

                    </table>
                    @if($data['item']->status->code !== 'start')

                    @endif
                    <div class="item_moreinfo">
                        <ul>
                            @foreach($data['item']->accordions as $item)
                                <li>
                                    <h3 class="accord">{{ $item->title }}</h3>
                                    <div class="accdata">
                                        {!! $item->description !!}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="item_makebidmain">
            <div  data-id="{{ $data['item']->id }}" class="btn_makebid @if($data['item']->status->code == 'start') notstarted @elseif($data['item']->status->code == 'completed' || $data['item']->time_left == 0) finished @else bid @endif">@if($data['item']->time_left == 0 && $data['item']->status->code !== 'start') Завершен @else {{ $data['item']->status->name }} @endif</div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')

<script>
    var nIntervId = [];
    var nIntervTimeLeft = [];
    function startTimer(duration, display, name, flag, timeleft) {
        if(flag === 'stop') {
            clearInterval(nIntervId[name]);
        } else {
            var timer = duration, minutes, seconds;
            timer = Number(timeleft);
            nIntervId[name]= setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    timer = duration;
                } else if(timer === 0) {
                    location.reload();
                }
            }, 1000);
        }
    }
    var pusher = new Pusher('e9c11497de160230d181', {
        cluster: 'eu',
        forceTLS: true
    });

    var channel = pusher.subscribe('auction');
    channel.bind('auction', function(data) {
        var data = JSON.stringify(data);
        data = JSON.parse(data);

        if($('.auction_item').data('id') === data.auction['id']) {
            var nameInterval = 'auction_' + data.auction['id'];
            var auctionItem = document.getElementById(nameInterval);
            if(auctionItem && auctionItem.querySelector('.curwinner_name')) {
                getAuctionBidsTable(data.auction['id'], auctionItem.querySelector('.bidlist'));
                if(auctionItem.querySelector('.curwinner_name').textContent === data.user['user_insta']) {

                } else {
                    startTimer(fiveMinutes, timeLeft, nameInterval, 'stop');
                    auctionItem.querySelector('.curwinner_name').textContent = data.user['user_insta'];
                    auctionItem.querySelector('.curwinner_name').href = 'https://instagram.com/' + data.user['user_insta'];
                    auctionItem.querySelector('.curwinner_photo_img').src = '/img/default_photo.jpg';
                    auctionItem.querySelector('.curprice').textContent = data.auction['price'];

                    var timeLeft = auctionItem.querySelector('.time_left');
                    timeLeft.setAttribute('data-time-left', data.auction['time_left']);
                    var fiveMinutes = data.auction['time_left'];
                    var auctionButton = auctionItem.querySelector('.btn_makebid');
                    if(data.auction['status_id'] === 2 && auctionButton.textContent !== 'Ставка') {
                        auctionButton.classList.remove("notstarted");
                        auctionButton.textContent = 'Ставка';
                    }
                    startTimer(fiveMinutes, timeLeft, nameInterval, 'start', data.auction['time_left']);
                }
            }
        }
    });

    function startTimers() {
        var auction_items = document.querySelectorAll('.auction_item');
        auction_items.forEach(function(auctionItem){
            var name = auctionItem.id;
            var display = auctionItem.querySelector('.time_left');
            if(display) {
                var fiveMinutes = Number(display.getAttribute('data-time-left'));
                startTimer(fiveMinutes, display, name, 'start', Number(fiveMinutes));
            }
        });
    }

    function getAuctionBidsTable(id, selector) {
        $.ajax({
            url: "/getAuctionBidsTable/" + id,
            success: function (result) {
                selector.innerHTML = result;
            },
            statusCode: {
                401: function () {
                    // window.location = '/login';
                },
            }
        });
    }

    window.onload = function () {
        startTimers();
    };
    $(".auction_item .notstarted").on( "click", function() {
        var auctionId = $(this).data('id');
        var auctionButton = $(this);
        $.ajax({
            url: "/startAuction/" + auctionId,
            success: function (result) {
                if(result['error']) {
                    alert(result['error']);
                } else {
                    auctionButton.removeClass('notstarted');
                    auctionButton.text('Ставка');
                    auctionButton.parent().find('.curwinner_name').text(result['user']);
                    auctionButton.parent().find('.curprice').text(result['auction']['price']);
                    auctionButton.parent().find('.time_left').attr('data-time-left', result['auction']['interval_time']);
                    location.reload();

                }
            },
            statusCode: {
                401: function () {
                    window.location = '/login';
                },
            }
        });
    });

    $(".auction_item .bid").on( "click", function() {
        var auctionId = $(this).data('id');
        var auctionButton = $('.auction_item .bid');
        $.ajax({
            url: "/bid/" + auctionId,
            success: function (result) {
                if(result['error']) {
                    alert(result['error']);
                } else {
                    document.querySelector('.item_buydata .available_bid').textContent = result['user_bid'];
                    document.querySelector('.bets_aval .available_bid').textContent = result['user_bid'];
                    if(auctionButton) {
                        auctionButton.removeClass('notstarted');
                        auctionButton.text('Ставка');
                        auctionButton.parent().find('.curwinner_name').text(result['user']);
                        auctionButton.parent().find('.curprice').text(result['auction']['price']);
                        auctionButton.parent().find('.time_left').attr('data-time-left', result['auction']['interval_time']);
                    }
                    var nameInterval = 'auction_' + result['auction']['id'];
                    var auctionItem = document.getElementById(nameInterval);

                    startTimer(fiveMinutes, timeLeft, nameInterval, 'stop');
                    auctionItem.querySelector('.curwinner_name').textContent = result['user'];
                    auctionItem.querySelector('.curwinner_photo_img').src = '/img/default_photo.jpg';
                    auctionItem.querySelector('.curprice').textContent = result['auction']['price'];
                    var timeLeft = auctionItem.querySelector('.time_left');
                    timeLeft.setAttribute('data-time-left', result['auction']['time_left']);
                    var fiveMinutes = result['auction']['time_left'];
                    var auctionButton = auctionItem.querySelector('.btn_makebid');
                    if(result['auction']['status_id'] === 2) {
                        if(auctionButton) {
                            auctionButton.classList.remove("notstarted");
                            auctionButton.textContent = 'Ставка';
                        }
                    }
                    startTimer(fiveMinutes, timeLeft, nameInterval, 'start', result['auction']['time_left']);
                }
            },
            statusCode: {
                401: function () {
                    window.location = '/login';
                },
            }
        });
    });
</script>
