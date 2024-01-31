@csrf
<div class="login__form-heading">
    <h1 class="login__form-title">Вход</h1>

</div>
<ul class="login__form-items">
    <li class="form-item">
        <label for="login--email">E-mail</label>
        <input type="email" id="login--email"
               name="email"{!! !empty($message) ? ' class="is-haserror"' : null !!}>
        <p class="system-msg"></p>
    </li>
    <li class="form-item">
        <label for="login--password">Пароль</label>
        <input type="password" id="login--password"
               name="password"{!! !empty($message) ? ' class="is-haserror"' : null !!}>
        <button class="login__password-show-btn"></button>
        <p class="system-msg">
            @if (isset($message))
                {!! $message !!}
            @endif
        </p>
    </li>
</ul>
<button class="submit-btn">Войти</button>
<div style="text-align: center;">
    <a href="{{ route('password.request') }}"
       style="color: #ffa01c; font-size: 13px; display: block; margin: 10px auto 0;">Забыли пароль?</a>
</div>
<div style="margin-top: 79px; text-align: center">
    <p class="login__form-subtitle">
        Нет аккаунта?
    </p>
    <a href="{{ route('register') }}" style="color: #ffa01c; font-size: 13px;">Создать
        аккаунт</a>
</div>
