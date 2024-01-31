@include('header')
@include('menu')
<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="pay_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="{{ url()->previous() }}" class="go_tomain"></a>
                    <h2>Регистрация</h2>
                    <a href="{{ route('login') }}">Вход</a>
                </div>
                <div class="register_block">
                    <div id="hint">Внимание! Во избежание блокировки вашей учётной записи указывайте ваш личный аккаунт в Instagram.</div>
                    <div class="authorize_data">
                        <form id="form-register" method="POST" action="{{ route('register') }}">
                            @csrf
                            <label>Электронная почта *<input value="{{ isset($data['email']) ? $data['email'] : old('email') }}" type="email" name="email" required placeholder="info@imperialonline.ru"></label>
                            <label>Телефон *<input value="{{ isset($data['delivery_phone']) ? $data['delivery_phone'] : old('delivery_phone') }}" type="tel" id="delivery_phone" name="delivery_phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required placeholder="79001112233"></label>
                            <label>Пароль *<input type="password" autocomplete name="password" value="{{ isset($data['password']) ? $data['password'] : old('password') }}" required></label>
                            <label>Подтверждение пароля *<input name="password_confirmation"  value="{{ isset($data['password_confirmation']) ? $data['password_confirmation'] : old('password_confirmation') }}" type="password"  required autocomplete="new-password"></label>
                            <label>Инстаграм<a href="#" class="info">i</a> *<input id="instagram" type="text" value="{{ isset($data['instagram']) ? $data['instagram'] : old('instagram') }}" name="instagram" required placeholder="imperialonline.ru"></label>
                            <div class="data_error">
                                @error('email') {{ $message }} <br> @enderror
                                @error('password') {{ $message }} <br> @enderror
                                @error('name') {{ $message }} <br> @enderror
                                @error('agreement') {{ $message }} <br> @enderror
                                @error('personal_data') {{ $message }} <br> @enderror
                                @error('delivery_phone') {{ $message }} <br> @enderror
                                @if(isset($dataErrors))
                                    {{ $dataErrors }} <br>
                                @endif
                            </div>
                            <div class="user_agreements">
                                <div class="comments">Внимательно указывайте свой никнейм Инстаграм (как в вашем профиле, латиницей)</div>
                                <input type="checkbox" checked class="checkbox" id="agreement" name="agreement"/>
                                <label for="agreement">С <a href="{{ route('agreement') }}" target="_blank">условиями</a> и <a href="{{ route('offer') }}" target="_blank">положениями оферты</a> согласен</label><br>
                                <input type="checkbox" checked class="checkbox" id="personal_data" name="personal_data"/>
                                <label for="personal_data">На обработку <a target="_blank" href="{{ route('agreement') . '#personalBefore' }}">персональных данных</a> согласен</label><br>
                                <input type="checkbox" checked class="checkbox" id="mailing" name="mailing"/>
                                <label for="mailing">Получать новости от Imperial Online</label><br>
                                <div class="comments"><b>Вам будет отправлено Email письмо со ссылкой на активацию аккаунта</b></div>
                                <div class="comments"><b>Телефон будет использоваться только для уведомлений по выигранным лотам</b></div>

                            </div>
                            <input type="submit" data-sitekey="{{ env('CAPTCHA_SITEKEY') }}"
                                    data-callback="onSubmitRegister"
                                    data-action="submit" class="btn_makebid notstarted g-recaptcha" value="Продолжить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
<script>
    function onSubmitRegister(token) {
        document.getElementById("form-register").submit();
    }
</script>
@include('footer-js')
