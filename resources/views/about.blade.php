@include('header')
@include('menu')
<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="about_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="{{ url()->previous() }}" class="go_tomain"></a>
                    <h1>О нас</h1>
                </div>
                <div class="about_moreinfo">
                    <div class="about_indexes">
                        <!-- <div class="about_mainindex">
                            <div class="main_indexdigit">1305 пользователей</div>
                            <div class="label">зарегистрировано на сайте</div>
                        </div>
                        <hr>-->
                        <div class="about_indexlist">
                            <ul>
                                <li>
                                    <div class="index_icon"><img src="../img/about_icons_users.jpg" alt="Наши пользователи"></div>
                                    <div class="index_label"><span>{{ $data['users'] }}</span>пользователей участвуют в аукционе</div>
                                </li>
                                <li>
                                    <div class="index_icon"><img src="../img/about_icons_items.jpg" alt="Наши товары"></div>
                                    <div class="index_label"><span>{{ $data['goods'] }}</span>товар{{ $data['goods_word'] }} выставлено на продажу</div>
                                </li>
                                <li>
                                    <div class="index_icon"><img src="../img/about_icons_deliver.jpg" alt="Доставка"></div>
                                    <div class="index_label"><span>16</span>стран география доставки</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="about_info">
                        <h3>История создания компании</h3>
                        <p>Наша команда постоянно работает над поиском свежих идей, чтобы создавать сервисы, помогающие не только делать мир ярче и интереснее, но и приносящие реальную пользу людям. Так, изучив опыт популярных онлайн-аукционов, работающих в США и Европе, в декабре 2019 года мы запустили свой собственный проект для России и стран СНГ — онлайн-аукцион Imperial. </p>
                        <p>Участвуя в наших аукционах, пользователи получают возможность приобретать понравившиеся товары со скидками до 99%. Концепция нашего аукциона позволяет продавать товары буквально за копейки, получая при этом прибыль. За счёт продажи пакетов ставок, необходимых пользователям для участия в аукционах, мы компенсируем большую часть от стоимости товара и имеем возможность зарабатывать. Именно поэтому мы заинтересованы в том, чтобы участники аукционов выигрывали и покупали товары с максимальной скидкой.</p>
                    </div>
                    <div class="partner_list">
                        <h3>Наши партнеры</h3>
                        <ul>
                            <li><img src="../img/logos/sberbank.png" alt="Сбербанк"></li>
                            <li><img src="../img/logos/tinkoff.png" alt="Тинькофф"></li>
                            <li><img src="../img/logos/visa.png" alt="Visa"></li>
                            <li><img src="../img/logos/mastercard.png" alt="Master Card"></li>
                            <li><img src="../img/logos/dns.png" alt="DNS"></li>
                            <li><img src="../img/logos/mvideo.png" alt="М-Видео"></li>
                            <li><img src="../img/logos/eldorado.png" alt="Эльдорадо"></li>
                            <li><img src="../img/logos/anex-tour.png" alt="AnexTour"></li>
                            <li><img src="../img/logos/pegas.png" alt="PegasTouristik"></li>
                            <li><img src="../img/logos/coral-travel.png" alt="Coral Travel"></li>
                            <li><img src="../img/logos/deliver_cdek.png" alt="CDEK"></li>
                            <li><img src="../img/logos/ems.png" alt="EMS"></li>
                            <li><img src="../img/logos/deliver_dhl.png" alt="DHL"></li>
                            <li><img src="../img/logos/russia-post.png" alt="Почта России"></li>
                        </ul>
                    </div>
                    <div class="jurinfo">
                        <h3>Юридическая информация</h3>
                        <table>
                            <tr>
                                <td colspan="2">ИП Слободянюк Данил Андреевич</td>
                            </tr>
                            <tr>
                                <td>ОГРНИП:</td>
                                <td>319272400058541</td>
                            </tr>
                            <tr>
                                <td>ИНН:</td>
                                <td>2531022200449</td>
                            </tr>
                            <tr>
                                <td>Адрес:</td>
                                <td>680054, Хабаровский край, г. Хабаровск, ул. Штормовая, д. 10</td>
                            </tr>
                        </table>
                        <a href="{{ route('agreement') }}" target="_blank">Пользовательское соглашение</a>
                        <a href="{{ route('offer') }}" target="_blank">Публичная оферта</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
