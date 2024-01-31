@extends('layouts.auction')

@push('styles')
    <link href="{!! asset('css//login.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/swiper-bundle.min.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/login.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
@endpush

@section('content')
    <section class="login__page">
        @include('partial.auth.slider')
        <div class="login__form-wrapper">
            <form action="{{ route('password.update') }}" class="login__form is-active" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="login__form-heading">
                    <h1 class="login__form-title">Восстановить пароль</h1>
                    <p class="login__form-subtitle">
                        Есть аккаунт?
                        <a href="{{ route('login') }}" style="color: #ffa01c; font-size: 13px; margin-left: 15px;">Войти</a>
                    </p>
                </div>
                <ul class="login__form-items">
                    <li class="form-item">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" @error('email') class="is-haserror" @enderror>
                        <p class="system-msg">
                            @error('email') {{ $message }} <br> @enderror
                        </p>
                    </li>
                    <li class="form-item">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" id="password" name="password" @error('password') class="is-haserror" @enderror>
                        <p class="system-msg">
                            @error('password') {{ $message }} <br> @enderror
                        </p>
                    </li>
                    <li class="form-item">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input type="password" id="password-confirm" name="password_confirmation">
                    </li>
                </ul>
                <button class="submit-btn">Reset Password</button>
                <div class="passwordrecovery-approved-text">
                    <h3>Письмо отправлено</h3>
                    <br>
                    <p>На адрес <span class="passwordrecovery-approved-email">email@example.com</span> выслана ссылка для восстановления пароля. Перейдите по ссылке и установите новый пароль.</p>
                </div>
            </form>
        </div>
    </section>
@stop
