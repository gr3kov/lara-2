@include('header')
@include('menu')
<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="deliver_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="{{ url()->previous() }}" class="go_tomain"></a>
                    <h1>Доставка товара</h1>
                </div>
                <div class="deliver_moreinfo">
                    <table class="deliver_table">
                        <tr>
                            <td><img src="../img/icon_personaldata.jpg" alt="Данные получателя"></td>
                            <td>Вводите адрес доставки и данные получателя. По умолчанию берутся данные из <a href="">профиля</a></td>
                        </tr>
                        <tr>
                            <td><img src="../img/icon_deliverdata.jpg" alt="Способ доставки"></td>
                            <td>Выбираете скорость, способ и стоимость доставки.<br>Наши партнеры:
                                <ul class="deliver_companies">
                                    <li><img src="../img/logos/deliver_cdek.png" alt="CDEK"></li>
                                    <li><img src="../img/logos/deliver_dhl.png" alt="DHL"></li>
                                    <li><img src="../img/logos/deliver_pek.png" alt="ПЭК"></li>
                                    <li><img src="../img/logos/deliver_dl.png" alt="Деловые линии"></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="../img/icon_manager.jpg" alt="Менеджер"></td>
                            <td>Наш менеджер связывается с вами, уточняет все данные и отправляет товар.</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
