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
            <form action="{{ route('password.email') }}" class="login__form is-active" method="post">
                @csrf
                <div class="login__form-heading">
                    <h1 class="login__form-title">Восстановить пароль</h1>
                    <p class="login__form-subtitle">
                        Есть аккаунт?
                        <a href="{{ route('login') }}" style="color: #ffa01c; font-size: 13px; margin-left: 15px;">Войти</a>
                    </p>
                </div>
                <ul class="login__form-items">
                    <li class="form-item">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" @error('email') class="is-haserror" @enderror>
                        <p class="system-msg">
                            @error('email') {{ $message }} <br> @enderror
                        </p>
                    </li>
                </ul>
                <button class="submit-btn">Отправить ссылку для восстановления пароля</button>

                @if (session('status'))
                    <div class="passwordrecovery-approved-text is-active">
                        <p style="margin-top: 15px; line-height: 1.2;">{{ session('status') }}</p>
                    </div>
                @endif
            </form>
        </div>
    </section>
@stop
