document.addEventListener("DOMContentLoaded", function () {

    Pusher.logToConsole = true;
    var pusher = new Pusher(pusherAppKey, {
        cluster: pusherAppCluster,
        forceTLS: true
    });

    var channel = pusher.subscribe(pusherChannel);
    channel.bind(pusherEvent, function (rawData) {
        var jsonData = JSON.stringify(rawData),
            objData = JSON.parse(jsonData);
        console.log('puserEvent',objData);
        var card=$('.auction__card#auction_'+objData['auction'].id),
            itempage=$('.lot__main');
        if(card){//приводим к единому виду
            card.each(function(){
                $(this).LiderInfo(objData['user'].id);
                $(this).find('.auction__card-sticker.sticker-email').detach();
                $(this).find('.auction__card-visual').append('<div class="auction__card-sticker sticker-email type2">\n' +
                    '  <p class="auction__card-sticker-p name">Лидер</p>\n' +
                    '  <p class="auction__card-sticker-p">'+objData['user'].instagram+'</p>\n' +
                    '</div>');
                $(this).find('.auction__card-cost').text(objData['auction'].price);
                $(this).find('.auction__card-placesleft .free').text(objData['auction']['free_slots']);
                if($(this).find('button').hasClass('notstarted')){
                    let btn=$(this).find('button');
                    if(!$(this).find('.auction__card-date').hasClass('is-timer')){
                        $(this).find('.auction__card-date').detach();
                        $(this).find('.auction__card-smp').after('<div class="auction__card-date  is-timer ">\n' +
                            '  <p class="auction__card-date-value">'+btn.data('dv-all')+'</p>\n' +
                            '  <p class="auction__card-date-value time_left" data-time-left="'+btn.data('time-left')+'">'+btn.data('dv-left')+'</p>\n' +
                            '</div>');
                    }
                    btn.detach();
                    $(this).find('.auction__card-text').after('<button class="auction__card-btn is-enabled started lot-first bid"' +
                        'data-id="'+objData['auction'].id+'">Участвовать</button>');
                    $(this).find('button').on('click',bidclick);
                    startTimers();
                }else if($(this).find('button').hasClass('started')){
                    $(this).find('button').detach();
                    $(this).find('.auction__card-text').after('<button class="auction__card-btn is-enabled lot-first bid"' +
                        'data-id="'+objData['auction'].id+'">' +
                        '<span>ПЕРЕБИТЬ</span>\n' +
                        '<img src="/img/buy-crypto.svg" alt="">\n' +
                        '<span>'+ $(this).data('bet-size')+' FLAMES</span>\n' +
                        '<span class="flare"></span></button>');
                    $(this).find('button').on('click',bidclick);
                }
            });
            /*var timeLeft = $(this).find('.time_left'),
                nameInterval = 'auction_' + objData.auction['id'],
                fiveMinutes = objData.auction['time_left'];
            timeLeft.attr('data-time-left', objData.auction['time_left']);*/
            //startTimer(fiveMinutes, timeLeft, nameInterval, 'start', objData.auction['time_left']);
        }
        if(itempage){
            console.log('imagepage - event');
            console.log(objData['user']);
            itempage.find('.lot__list').getAuctionBidsTable(objData['auction'].id);
            /*$(this).find('.auction__card-sticker.sticker-email').detach();
            $(this).find('.auction__card-visual').append('<div class="auction__card-sticker sticker-email type2">\n' +
                '  <p class="auction__card-sticker-p name">Лидер</p>\n' +
                '  <p class="auction__card-sticker-p">'+objData['user'].instagram+'</p>\n' +
                '</div>');*/
            itempage.find('.lot__card-cost').text(priceFormat(objData['auction'].price));
            itempage.find('.lot__card-cost_mobile').text(priceFormat(objData['auction'].price));
            itempage.find('.lot__card-placesleft .free').text(objData['auction']['free_slots']);
            var btn=itempage.find('.lot-button');
            if(btn.hasClass('notstarted')){
                /*if(!$(this).find('.auction__card-date').hasClass('is-timer')){
                    $(this).find('.auction__card-date').detach();
                    $(this).find('.auction__card-smp').after('<div class="auction__card-date  is-timer ">\n' +
                        '  <p class="auction__card-date-value">'+btn.data('dv-all')+'</p>\n' +
                        '  <p class="auction__card-date-value time_left" data-time-left="'+btn.data('time-left')+'">'+btn.data('dv-left')+'</p>\n' +
                        '</div>');
                }*/
                btn.detach();
                itempage.find('.lot__about').after('<button class="lot-button lot__button invate auction__card-btn is-enabled started lot-first bid"' +
                    'data-id="'+objData['auction'].id+'">Участвовать</button>');
                itempage.find('button').on('click',bidclick);
                startTimers();
            }else if(itempage.find('button').hasClass('started')){
                itempage.find('button').detach();
                itempage.find('.lot__about').after('<button data-id="3504" class="lot-button lot__interrupt lot-first bid is-enabled "' +
                    'data-id="'+objData['auction'].id+'">ПЕРЕБИТЬ <span></span>'+itempage.data('bet-size')+' FLAMES </button>');
                itempage.find('button').on('click',bidclick);
            }
        }
        /*if ($('.auction_item').data('id') === objData.auction['id']) {//старый вариант
            var nameInterval = 'auction_' + objData.auction['id'],
                auctionItem = document.getElementById(nameInterval);
            if (auctionItem) {
                // Если на странице лота - обновляем список ставок
                if ($('.lot__list-members')) {    //@todo в будущем этот кусок (обновление страницы если обновились ставки) нужно будет убрать
                    getAuctionBidsTable(objData.auction['id']);
                    console.log('Обновляем страницу лота');
                }
                startTimer(fiveMinutes, timeLeft, nameInterval, 'stop');
                //auctionItem.querySelector('.userInstagram').textContent = objData.user['instagram'];
                //auctionItem.querySelector('.price').textContent = priceFormat(objData.auction['price']);
                var timeLeft = auctionItem.querySelector('.time_left');
                timeLeft.setAttribute('data-time-left', objData.auction['time_left']);
                var fiveMinutes = objData.auction['time_left'],
                    auctionButton = auctionItem.querySelector('.button');
                var txtbutton='<span>ПЕРЕБИТЬ</span>\n' +
                    '<img src="/img/buy-crypto.svg" alt="">\n' +
                    '<span>'+$('.auction_item').data('bet-size')+' FLAMES</span>\n'+
                    '<span class="flare"></span>';
                if (objData.auction['status_id'] === 2 && auctionButton.textContent !== txtbutton) {
                    //@todo тут поменять текст кнопки (на перебить 20 рото)
                    auctionButton.classList.remove('notstarted');
                    auctionButton.innerHTML = txtbutton;
                }
                startTimer(fiveMinutes, timeLeft, nameInterval, 'start', objData.auction['time_left']);
            }
        }*/
    });

    // Если аукцион не запущен - запускаем
    $('.notstarted').on('click', startclick);

    // Клик по кнопке сделать ставку
    $('.auction_item .bid,.lot__main .bid').on('click', bidclick);
});

window.onload = function () {
    startTimers();
};

let nIntervId = [];

function startTimer(duration, display, name, flag, timeleft) {
    //@todo проверить корректность работы таймера, я думаю проблема в передаваемых параметрах (неверное значение сколько времени осталось)
    if (flag === 'stop') {
        clearInterval(nIntervId[name]);
    } else {
        var timer = duration, minutes, seconds;
        timer = Number(timeleft);
        nIntervId[name] = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + " : " + seconds;

            if (--timer < 0) {
                timer = duration;
            } else if (timer === 0) {
                location.reload();
            }
        }, 1000);
    }
}

function startTimers() {
    document.querySelectorAll('.auction_item').forEach(function (auctionItem) {
        var name = auctionItem.id,
            display = auctionItem.querySelector('.time_left');
        if (display) {
            var fiveMinutes = Number(display.getAttribute('data-time-left'));
            startTimer(fiveMinutes, display, name, 'start', Number(fiveMinutes));
        }
    });
}

function priceFormat(price) {
    return price.toLocaleString() + ' р.';
}

function startclick() {
    console.log('notstarted');
    var auctionId = $(this).data('id');
    // var auctionButton = $(this);
    $.ajax({
        url: urlStartAuction + auctionId,
        success: function (result) {
            console.log('result started',result);
            if (result['error']) {
                toastr.error(result['error']);
            } else {
                var card= $('.auction__card#auction_'+result['auction'].id),
                    itempage=$('.lot__main');
                $('#header__menu-link--tockens .userTokens').text(result['user']['bid']);
                if(result['deposit_value']) {
                    card.find('.auction__card-visual').find('.auction__card-sticker.sticker-deposit').detach();
                    card.find('.auction__card-visual').append('<div class="auction__card-sticker sticker-deposit type2">\n' +
                        '  <p class="auction__card-sticker-smp">Ваш депозит</p>\n' +
                        '  <p class="auction__card-sticker-bigp">'+result['deposit_value']['deposit_balance']+' FLAMES</p>\n' +
                        '</div>');
                    itempage.find('.sticker-deposit').addClass('type2');
                    itempage.find('.sticker-deposit .lot__card-sticker-smp').text('Ваш депозит');
                    itempage.find('.sticker-deposit .lot__card-sticker-bigp').text(result['deposit_value']['deposit_balance']+' FLAMES');
                }
                if(result['status']=='reservation'){
                    card.find('button').text(result['button']['text']);
                    card.find('.auction__card-placesleft .free').text(result['auction']['free_slots']);
                    toastr.success(result['message']);
                    return false;
                }
                card.find('.auction__card-visual .auction__card-sticker.sticker-email').detach();
                card.find('.auction__card-visual').append('<div class="auction__card-sticker sticker-email type2">\n' +
                    '  <p class="auction__card-sticker-p name">Лидер</p>\n' +
                    '  <p class="auction__card-sticker-p">'+result['user']['name']+'</p>\n' +
                    '</div>');
                card.find('.auction__card-date').detach();
                card.find('.auction__card-smp').after('<div class="auction__card-date  is-timer ">\n' +
                    '  <p class="auction__card-date-value">'+result['timer']['dv_all']+'</p>\n' +
                    '  <p class="auction__card-date-value time_left" data-time-left="'+result['timer']['time_left']+'">'+result['timer']['dv_left']+'</p>\n' +
                    '</div>');
                card.find('button').detach();
                card.find('.auction__card-text').after('<button class="auction__card-btn is-enabled lot-first bid" data-id="'+result['auction'].id+'">' +
                    '<span>ПЕРЕБИТЬ</span>\n' +
                    '<img src="/img/buy-crypto.svg" alt="">\n' +
                    '<span>'+card.data('bet-size')+' FLAMES</span>\n' +
                    '<span class="flare"></span></button>');
                card.find('button').on('click',bidclick);
                startTimers();
                //location.reload();
            }
        },
        statusCode: {
            401: function () {
                window.location = urlLogin;
            },
        }
    });
    return false;
}

function bidclick() {
    var auctionButton = $(this),
        auctionId = auctionButton.data('id');
    $.ajax({
        url: urlBid + auctionId,
        success: function (result) {

            if (result['error']) {
                toastr.error(result['error']);
            } else {
                var card=$('#auction_' + auctionId),
                    itempage=$('.lot__main');
                $('#auction_' + auctionId + ' .price').text(priceFormat(result['auction']['price']));
                $('.userTokens').text(result['user']['bid']);
                if(result['deposit_value']) {
                    card.find('.auction__card-visual').find('.auction__card-sticker.sticker-deposit').detach();
                    card.find('.auction__card-visual').append('<div class="auction__card-sticker sticker-deposit type2">\n' +
                        '  <p class="auction__card-sticker-smp">Ваш депозит</p>\n' +
                        '  <p class="auction__card-sticker-bigp">'+result['deposit_value']['deposit_balance']+' FLAMES</p>\n' +
                        '</div>');
                    itempage.find('.sticker-deposit').addClass('type2');
                    itempage.find('.sticker-deposit .lot__card-sticker-smp').text('Ваш депозит');
                    itempage.find('.sticker-deposit .lot__card-sticker-bigp').text(result['deposit_value']['deposit_balance']+' FLAMES');
                }
                //card.find('.auction__card-placesleft .free').text(result['auction']['free_slots']); - уже не нужно, т.к. в пушевент мы получаем эти данные
                auctionButton.removeClass('notstarted');
                /*auctionButton.html('<span>ПЕРЕБИТЬ</span>\n' +
                    '<img src="img/buy-crypto.svg" alt="">\n' +
                    '<span>20 FLAMES</span>\n' +
                    '<span class="flare"></span>');*/
                auctionButton.parent().find('.time_left').attr('data-time-left', result['auction']['interval_time']);
                var nameInterval = 'auction_' + result['auction']['id'],
                    auctionItem = document.getElementById(nameInterval);
                startTimer(fiveMinutes, timeLeft, nameInterval, 'stop');
                var timeLeft = auctionItem.querySelector('.time_left');
                timeLeft.setAttribute('data-time-left', result['auction']['time_left']);
                var fiveMinutes = result['auction']['time_left'];
                var textbutton='<span>ПЕРЕБИТЬ</span>\n' +
                    '<img src="/img/buy-crypto.svg" alt="">\n' +
                    '<span>'+result['auction']['bet_size']+' FLAMES</span>\n'+
                    '<span class="flare"></span>';
                if (result['auction']['status_id'] === 2) {
                    if (auctionButton) {
                        auctionButton.removeClass('notstarted');
                        auctionButton.html(textbutton);
                    }
                }
                startTimer(fiveMinutes, timeLeft, nameInterval, 'start', result['auction']['time_left']);
            }
        },
        statusCode: {
            401: function () {
                window.location = urlLogin;
            },
        }
    });
    return false;
}

(function($) {
    $.fn.LiderInfo=function($id){
        var card=$(this);
        $.ajax({
            url: '/user-info/'+$id,
            dataType: 'json',
            success: function(data){
                console.log(data);
                card.find('.auction__card-sticker.sticker-email').detach();
                card.find('.auction__card-visual').append('<div class="auction__card-sticker sticker-email type2">\n' +
                    '  <p class="auction__card-sticker-p name">Лидер</p>\n' +
                    '  <p class="auction__card-sticker-p">'+data.name+'</p>\n' +
                    '</div>');
                if(data.its_you)card.find('button').removeClass('disabled');
                    else card.find('button').addClass('disabled');
            }
        });
    }
    $.fn.LiderInfoPage=function(data){
        var card=$(this),
            par=$(this).parents('.lot__main');
        userdata={
            'lider':{
                'name':'',
                'photo':'',
                'fln':'',
            },'second':{
                'name':'',
                'photo':'',
                'fln':'',
            }
        };
        if(data.bid.length>0)userdata.lider=data.bid[0];
        if(data.bid.length>1)userdata.second=data.bid[1];
        if(!card.find('.lot__card-date').hasClass('type2')){
            card.find('.lot__card-date').detach();
            card.find('.lot__card-visual').after('<div class="lot__card-date type2">\n' +
                '    <div class="caption">Лидер</div>\n' +
                '    <div class="item winner auction_item">\n' +
                '        <div class="user">\n' +
                '            <div class="icon">\n' +
                '                <div class="noicon color1">'+userdata.lider.fln+'</div>\n' +
                '            </div>\n' +
                '            <div class="name">'+userdata.lider.name+'</div>\n' +
                '        </div>\n' +
                '        <div class="time time_left" data-time-left="'+par.data('timer-left')+'">'+par.data('timer-dv-left')+'</div>\n' +
                '    </div>\n' +
                '    <div class="item previous">\n' +
                '        <div class="user">\n' +
                '            <div class="icon">\n' +
                '                <div class="noicon color1">'+userdata.second.fln+'</div>\n' +
                '            </div>\n' +
                '            <div class="name">'+userdata.second.name+'</div>\n' +
                '        </div>\n' +
                '        <div class="time">'+par.data('timer-dv-all')+'</div>\n' +
                '    </div>\n' +
                '</div>');
        }else{
            card.find('.lot__card-date.type2 .item.winner .noicon').text(userdata.lider.fln);
            card.find('.lot__card-date.type2 .item.winner .name').text(userdata.lider.name);
            card.find('.lot__card-date.type2 .item.previous .noicon').text(userdata.second.fln);
            card.find('.lot__card-date.type2 .item.previous .name').text(userdata.second.name);
            card.find('.lot__card-date.type2 .item.winner .time').text(par.data('timer-dv-left'));
            card.find('.lot__card-date.type2 .item.previous .time').text(par.data('timer-dv-all'));
            card.find('.lot__card-date.type2 .item.previous .time').attr('data-time-left',par.data('timer-left'));
        }
        startTimers();
        if(data.bid.length>1)card.find('.lot__card-date.type2 .item.previous .user').show();
            else card.find('.lot__card-date.type2 .item.previous .user').hide();
    }
    $.fn.getAuctionBidsTable=function(auctionId){
        var cont=$(this),
            template = '<li class="lot__list-item">' +
            '    <div class="user-avatar-wrapper">' +
            '        <img src="/img/noavatar.svg" alt="%name%" class="user-avatar">' +
            '    </div>' +
            '    <p class="user-email">%name%</p>' +
            '    <p class="user-date">%date%</p>' +
            '</li>',
            liderData=[];
        $.ajax({
            url: urlGetAuctionBidsTable + auctionId,
            dataType: 'json',
            success: function (data) {
                var bids = '';
                liderData['bid']=data;
                $.each(data, function(index, value) {
                    bidString = template.replace('%name%', value.name);
                    bidString = bidString.replace('%name%', value.name);
                    bidString = bidString.replace('%date%', value.date);
                    bidString = bidString.replace('%photo%', value.photo);
                    bids += bidString;
                });
                cont.html(bids);
                cont.parents('.lot__main').find('.lot__card').LiderInfoPage(liderData);
            },
            statusCode: {
                401: function () {
                    // window.location = urlLogin;
                },
            }
        });
    }
})(jQuery);
