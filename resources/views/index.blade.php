@include('header')
@include('menu')

<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                @if(isset($title))
                    <div class="cap_line">
                        <h1>{{ $title }}</h1>
                    </div>
                @endif
                <ul class="item_list">
                    @php
                        $count = 0;
                    @endphp
                    @foreach($data['auctionItems'] as $auctionItem)
                        <li id="auction_{{$auctionItem->id}}" class="auction_item {{ $count == 0 ? 'first-element' : '' }}">
                            <div class="lotNum">Лот {{ $auctionItem->lot_number }}</div>
                            <div class="item_cap">{{ $auctionItem->name }}</div>
                            <div class="item_pic">
                                <a href="{{ route('item', ['id' => $auctionItem->id]) }}">
                                    <img src="{{ $auctionItem->preview_image }}" alt="{{ $auctionItem->name }}">
                                </a>
                            </div>
                            <div class="item_info">
                                <div class="timer_block">
                                    <div data-time-interval="{{ $auctionItem->interval_time }}" class="interval">
                                        <span>{{ floor($auctionItem->interval_time / 60) . ':' . ($auctionItem->interval_time % 60 < 10 ? '0' . $auctionItem->interval_time % 60 : $auctionItem->interval_time % 60) }}</span>
                                    </div>
                                    <div data-time-left="{{ $auctionItem->status->code == 'completed' ? 0 : $auctionItem->time_left }}" class="time_left">{{ (floor($auctionItem->time_left / 60) < 10 ? '0' : '') . floor($auctionItem->time_left / 60) . ':' . ($auctionItem->time_left % 60 < 10 ? '0' . $auctionItem->time_left % 60 : $auctionItem->time_left % 60) }}</div>
                                </div>
                                <div class="curprice">{{ $auctionItem->price }}</div>
                            </div>
                            <div class="cur_winner"><a target="_blank" href="https://instagram.com/{{ $auctionItem->leader }}">{!! $auctionItem->leader ? $auctionItem->leader : '&nbsp;' !!}</a></div>
                            <div data-id="{{ $auctionItem->id }}"
                                 class="btn_makebid
                                    @if($auctionItem->status->code == 'start') notstarted
                                    @elseif(isset($canPay) && $auctionItem->payed == 0 && $auctionItem->canPay) btn_pay
                                    @elseif(isset($canPay) && $auctionItem->payed == 1 && $auctionItem->canPay) finished
                                    @elseif($auctionItem->status->code == 'completed' || $auctionItem->time_left == 0) finished
                                    @else bid @endif">
                                        @if(isset($canPay) && $auctionItem->payed == 0 && $auctionItem->canPay)
                                        Оплатить
                                        @elseif(isset($canPay) && $auctionItem->payed == 1 && $auctionItem->canPay)
                                        Оплачен
                                        @elseif($auctionItem->time_left == 0 && $auctionItem->status->code !== 'start')
                                        Завершен
                                        @else {{ $auctionItem->status->name }}
                                        @endif
                            </div>
                        </li>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                    @for($i = 0; 6 - ($count % 6) > $i; $i++)
                        <li style="height: 0; padding: 0;"></li>
                    @endfor
                </ul>
                @if(\Request::url() !== route('archive'))
                    <div id="archiveLinkBlock">
                        <a href="{{ route('archive') }}" class="btn_makebid notstarted btn_archive">архив лотов</a>
                        <p class="label arcBtnComment">Завершённые лоты попадают в архив ежедневно в 03:00 по МСК</p>
                    </div>
                @endif
            </div>
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

    var channelAuctionDelete = pusher.subscribe('auction_delete');
    channelAuctionDelete.bind('auction_delete', function(data) {
        var data = JSON.stringify(data);
        data = JSON.parse(data);
        var auctionId = data.auction.id;
        var auctionElementForDelete = document.getElementById('auction_' + auctionId);
        if(auctionElementForDelete) {
            auctionElementForDelete.remove();
        }
    });

    var channel = pusher.subscribe('auction');
    channel.bind('auction', function(data) {
        var data = JSON.stringify(data);
        data = JSON.parse(data);
        if(data.notification) {
            if(data.notification['type'] === 'new-auction' && !$('#auction_' + data.notification['item_id']).length > 0) {
                $.ajax({
                    url: "/getAuctionItem/" + data.notification['item_id'],
                    success: function (result) {
                        $(result).insertBefore('.first-element');
                    },
                });
            }
        }
        if(data.user) {
            var nameInterval = 'auction_' + data.auction['id'];
            var auctionItem = document.getElementById(nameInterval);
            if(auctionItem && auctionItem.querySelector('.cur_winner')) {
                if(auctionItem.querySelector('.cur_winner').textContent === data.user['user_insta']) {

                } else {
                    startTimer(fiveMinutes, timeLeft, nameInterval, 'stop');
                    auctionItem.querySelector('.cur_winner a').textContent = data.user['user_insta'];
                    auctionItem.querySelector('.cur_winner a').href = 'https://instagram.com/' + data.user['user_insta'];
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
    // function updateAuction() {
    //     window.updateAuction = setInterval(function () {
    //         $.ajax({
    //             url: "/getNotification",
    //             success: function (result) {
    //                 $('.available_bid').text(result['user_bid']);
    //                 if(result['need_reload']) {
    //                     location.reload();
    //                 }
    //             },
    //             statusCode: {
    //                 401: function () {
    //                     // window.location = '/login';
    //                 },
    //             }
    //         });
    //         $.ajax({
    //             url: "/getAuctionLots",
    //             success: function (result) {
    //                 result.forEach(function(item){
    //                     var nameInterval = 'auction_' + item['id'];
    //                     var auctionItem = document.getElementById(nameInterval);
    //                     if(auctionItem && auctionItem.querySelector('.cur_winner')) {
    //                         if(auctionItem.querySelector('.cur_winner').textContent === item['user']) {
    //
    //                         } else {
    //                             startTimer(fiveMinutes, timeLeft, nameInterval, 'stop');
    //                             auctionItem.querySelector('.cur_winner a').textContent = item['user'];
    //                             auctionItem.querySelector('.cur_winner a').href = 'https://instagram.com/' + item['user'];
    //                             auctionItem.querySelector('.curprice').textContent = item['price'];
    //                             var timeLeft = auctionItem.querySelector('.time_left');
    //                             timeLeft.setAttribute('data-time-left', item['time_left']);
    //                             var fiveMinutes = item['time_left'];
    //                             var auctionButton = auctionItem.querySelector('.btn_makebid');
    //                             if(item['status_id'] === 2 && auctionButton.textContent !== 'Ставка') {
    //                                 auctionButton.classList.remove("notstarted");
    //                                 auctionButton.textContent = 'Ставка';
    //                             }
    //                             startTimer(fiveMinutes, timeLeft, nameInterval, 'start', item['time_left']);
    //                         }
    //                     }
    //                 });
    //             }
    //         });
    //     }, 1000);
    // }
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

    function getNotification() {
        setInterval(function () {
            $.ajax({
                url: "/getNotification",
                success: function (result) {
                    $('.available_bid').text(result['user_bid']);
                    if(result['need_reload']) {
                        location.reload();
                    }
                },
                statusCode: {
                    401: function () {
                        // window.location = '/login';
                    },
                }
            });
        }, 1000);

    }
    window.onload = function () {
        startTimers();
        // updateAuction();
    };
    $(".auction_item .notstarted").on( "click", function() {
        var auctionId = $(this).data('id');
        var auctionButton = $(this);
        $.ajax({
            url: "/startAuction/" + auctionId,
            success: function (result) {
                if(result['error']) {
                    if(result['error'] === 'Нет доступных ставок') {
                        document.getElementById('popup_urempty').style.display = 'flex';
                    } else {
                        alert(result['error']);
                    }
                } else {
                    auctionButton.removeClass('notstarted');
                    auctionButton.text('Ставка');
                    auctionButton.parent().find('.cur_winner a').text(result['user']);
                    auctionButton.parent().find('.cur_winner a').attr('href', 'https://instagram.com/' + result['user']);
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
        var auctionButton = $(this);
        $.ajax({
            url: "/bid/" + auctionId,
            success: function (result) {
                if(result['error']) {
                    if(result['error'] === 'Нет доступных ставок') {
                        document.getElementById('popup_urempty').style.display = 'flex';
                    } else {
                        alert(result['error']);
                    }
                } else {
                    document.querySelector('.available_bid').textContent = result['user_bid'];
                    auctionButton.removeClass('notstarted');
                    auctionButton.text('Ставка');
                    auctionButton.parent().find('.cur_winner').text(result['user']);
                    auctionButton.parent().find('.curprice').text(result['auction']['price']);
                    auctionButton.parent().find('.time_left').attr('data-time-left', result['auction']['interval_time']);

                    var nameInterval = 'auction_' + result['auction']['id'];
                    var auctionItem = document.getElementById(nameInterval);

                    startTimer(fiveMinutes, timeLeft, nameInterval, 'stop');
                    auctionItem.querySelector('.cur_winner').textContent = result['user'];
                    auctionItem.querySelector('.curprice').textContent = result['auction']['price'];
                    var timeLeft = auctionItem.querySelector('.time_left');
                    timeLeft.setAttribute('data-time-left', result['auction']['time_left']);
                    var fiveMinutes = result['auction']['time_left'];
                    var auctionButton = auctionItem.querySelector('.btn_makebid');
                    if(result['auction']['status_id'] === 2 && auctionButton.textContent !== 'Ставка') {
                        auctionButton.classList.remove("notstarted");
                        auctionButton.textContent = 'Ставка';
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
    $('.btn_pay').on('click', function() {
        var auctionId = $(this).data('id');
            window.location = '/buy/auction/' + auctionId;
    });
</script>
