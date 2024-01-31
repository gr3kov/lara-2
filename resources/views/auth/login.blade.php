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
                    <h2>Войти</h2>
                </div>
                <div class="authorize_block">
                    <div class="authorize_data">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <label>Электронная почта *<input type="email" name="email" required></label>
                            <label>Пароль *<input type="password" name="password" required></label>
                            @if(isset($data['message']))
                                <div class="data_error">{{ $data['message'] }}</div>
                            @endif
                            <input type="submit" class="btn_makebid notstarted" value="Войти">
                        </form>
                    </div>
                    <div class="regforget_block">
                        <a href="{{ route('register') }}" class="register">Регистрация</a>
                        <a href="{{ route('password.request') }}" class="forget">Забыли пароль?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
