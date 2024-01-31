@include('header')
@include('menu')
<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="paystatus_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="/" class="go_tomain"></a>
                    <h2>Активация аккаунта</h2>
                </div>
                <div class="paystatus_moreinfo">
                    <div class="status_pic"><img src="../img/notification.jpg" alt="Инфо"></div>
{{--                    <div class="status_cap">Изменение пароля</div>--}}
                    <div class="status_info">Ссылка на активацию отправлена на почту<br><br><p style="color: #fc7892;">Активируйте аккаунт и получите 10 бесплатных ставок на победу прямо сейчас</p></div>
                    <p class="status_back"><a href="/">назад</a></p>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
