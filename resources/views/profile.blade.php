@include('header')
@include('menu')
<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="profile_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="{{ url()->previous() }}" class="go_tomain"></a>
                    <h2>Профиль</h2>
                </div>
                <div class="profile_moreinfo">
                    <div class="user_block">
                        <div class="user_photo"><img src="{{ $user->photo }}"></div>
                        <div class="user_info">
                            <div class="user_name">{{ $user->user_insta }}</div>
                            <div class="user_mail">{{ $user->email }}</div>
                            <div class="user_insta">{{ $user->user_insta }}</div>
                            <a href="#" class="change_pass">Сменить пароль</a>
                        </div>
                    </div>
                    <div id="change_pass_block">
                        <form method="GET" id="change_pass_form" action="{{ route('password-change') }}">
                            <label for="old_password">Старый пароль:<input type="password" required name="old_password"></label>
                            <label for="new_password">Новый пароль:<input type="password" required name="password"></label>
                            <label for="password_repeat">Повторите новый пароль:<input type="password" name="password_repeat"></label>
                            <div class="data_error"></div>
                            <input type="submit" value="Сменить пароль" class="btn_makebid notstarted">
                        </form>
                    </div>
                    <div class="my_bids">
                        <h3>Мои ставки</h3>
                        <div class="bid_block">
                            <div class="bid_left">{{ $user->bid }}<a href="{{ route('pay') }}" class="btn_makebid">+</a><div class="label">доступно</div></div>
                            <div class="bit_whole">{{ $pay }}<div class="label">приобретено</div></div>
                        </div>
                        <table>
                            @foreach($bids as $bid)
                                @if(isset($bid->auction))
                                <tr>
                                    <td>{{ date('d.m.Y', strtotime($bid->updated_at)) }}</td>
                                    <td>{{ date('H:s:i', strtotime($bid->updated_at)) }}</td>
                                    <td><a href="{{ route('item', ['id' => $bid->auction->id]) }}" target="_blank">{{ $bid->auction->name }}</a></td>
                                    <td><img src="@if($bid->is_leader) ../img/golden_crown.svg @elseif($bid->is_last) ../img/bid_icon-02.svg @else ../img/bid_icon-03.svg @endif" alt="перебита"></td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                        <div class="pic_comments">
                            <img src="../img/bid_icon-02.svg" alt="сделана"> - ставка сделана,
                            <img src="../img/bid_icon-03.svg" alt="перебита"> - перебита,
                            <img src="../img/golden_crown.svg" alt="победила"> - выиграла
                        </div>
                    </div>
                    <div class="referal my_bids">
                        <h3>Ваша реферальная ссылка</h3>
                        <input id="_hiddenCopyText_" value="{{ env('APP_URL') . '/ref/' . $user->ref_code }}" type="text">
                        <div class="ref_link" id="ref_link">
                            <a id="ref_link_text" title="Скопировать ссылку">{{ env('APP_URL') . '/ref/' . $user->ref_code }}</a>
                        </div>
                        <br>
                        <div class="bid_block">
                            <div class="ref_center">{{ $refRegister }}<div class="label">Всего</div></div>
                            <div class="ref_center">{{ $refSum }}<div class="label">Сумма</div></div>
                        </div>
                        <table>
                            @foreach($referrals as $referral)
                                <tr>
                                    <td>{{ \App\User::where('id', $referral->user_id_ref)->first()->user_insta }}</td>
                                    <td>{{ $referral->first_sum }}</td>
                                    <td>{{ date('H:i d.m.Y', strtotime($referral->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="notif_settings">
                        <h3>Настройка уведомлений</h3>
                        <div><input type="checkbox" class="checkbox" @if($user->news_notification) checked @endif id="news_notification" name="news_notification"/>
                            <label for="news_notification">Уведомлять о появлении новинок</label></div>
                        <div><input type="checkbox" @if($user->autobid_notification) checked @endif class="checkbox" id="autobid_notification" name="autobid_notification"/>
                            <label for="autobid_notification">Автоставки (лот выигран, закончились ставки)</label></div>
                        <div><input type="checkbox" class="checkbox" @if($user->mailing) checked @endif id="mailing" name="mailing"/>
                            <label for="mailing">Получать письма о промо-акциях</label></div>
                    </div>
                    <div class="deliver_address">
                        <h3>Данные для доставки</h3>
                        <form method="GET" action="{{ route('delivery-change') }}" id="profile_data">
                            <div>
                                <p>ФИО получателя:</p>
                                <input type="text" disabled @if($user->delivery_name) value="{{ $user->delivery_name }}" @endif name="userName" class="profileFormInput" required placeholder="Пример: Петров Иван Сергеевич">
                            </div>
                            <div>
                                <p>Почтовый индекс:</p>
                                <input type="number" disabled @if($user->delivery_post_index) value="{{ $user->delivery_post_index }}" @endif name="postIndex" class="profileFormInput" required placeholder="Пример: 680000">
                            </div>
                            <div>
                                <p>Город:</p>
                                <input type="text" disabled @if($user->delivery_city) value="{{ $user->delivery_city }}" @endif name="userTown" class="profileFormInput" required placeholder="Пример: Хабаровск">
                            </div>
                            <div>
                                <p>Улица:</p>
                                <input type="text" disabled @if($user->delivery_street) value="{{ $user->delivery_street }}" @endif name="userStreet" class="profileFormInput" required placeholder="Пример: Ленинградская">
                            </div>
                            <div>
                                <p>Дом/строение/корпус:</p>
                                <input type="text" disabled @if($user->delivery_house) value="{{ $user->delivery_house }}" @endif name="userHouse" class="profileFormInput" required placeholder="Пример: 98/А">
                            </div>
                            <div>
                                <p>Квартира:</p>
                                <input type="text" disabled @if($user->delivery_apartment) value="{{ $user->delivery_apartment }}" @endif name="userFlat" class="profileFormInput" placeholder="Пример: 241">
                            </div>
                            <div>
                                <p>Телефон:</p>
                                <input type="text" disabled @if($user->delivery_phone) value="{{ $user->delivery_phone }}" @endif name="phone" class="profileFormInput" required placeholder="Пример: +7 (924) 200-9999">
                            </div>
                            <div>
                                <p>Эл. почта:</p>
                                <input type="email" disabled @if($user->delivery_email) value="{{ $user->delivery_email }}" @endif name="email" class="profileFormInput" required placeholder="Пример: petrov.is1975@gmail.com">
                            </div>
                            <input type="submit" value="Редактировать" class="delivery_submit btn_makebid">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
<script>
    $('#change_pass_form').submit(function( event ) {
        event.preventDefault();
        $.ajax({
            data: $('#change_pass_form').serialize(),
            url: '/password/change/',
            success: function (result) {
                if(result['status'] === 'error') {
                    $('#change_pass_form .data_error').html(result['message']);
                } else {
                    window.location = result['redirectUrl'];
                }
            },
            statusCode: {
                401: function () {
                    window.location = '/login';
                },
            }
        });
    });
    $('#profile_data').submit(function( event ) {
        event.preventDefault();
        if($('.delivery_submit').val() === 'Сохранить') {
            $.ajax({
                data: $('#profile_data').serialize(),
                url: '/delivery/change/',
                success: function (result) {
                    $('.delivery_submit').val('Редактировать')
                    $('#profile_data input[type=text], #profile_data input[type=number], #profile_data input[type=email]').prop('disabled', true);

                },
                statusCode: {
                    401: function () {
                        window.location = '/login';
                    },
                }
            });
        } else {
            $('#profile_data input[type=text], #profile_data input[type=number], #profile_data input[type=email]').prop('disabled', false);
            $('.delivery_submit').val('Сохранить');
        }
    });

    $("#news_notification, #autobid_notification, #mailing").change(function() {
        $.ajax({
            data: {
                'news_notification': $('#news_notification').prop('checked'),
                'autobid_notification': $('#autobid_notification').prop('checked'),
                'mailing': $('#mailing').prop('checked'),
            },
            url: '/notifications/change/',
            success: function (result) {

            },
            statusCode: {
                401: function () {
                    window.location = '/login';
                },
            }
        });
    });

    document.getElementById('ref_link').addEventListener('click', function() {
        console.log(123);
        copyToClipboard(document.getElementById('ref_link_text'));
    });

    function copyToClipboard(elem) {
        // create hidden text element, if it doesn't already exist
        let targetId = "_hiddenCopyText_";
        let isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        let origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        let currentFocus = document.activeElement;
        target.focus();
        console.log(target);
        target.setSelectionRange(0, target.value.length);

        // copy the selection
        let succeed;
        try {
            succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }

</script>
