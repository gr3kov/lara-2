@extends('layouts.auctionnsb')

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
            @if (Route::current()->getName() == 'register')
                <form action="{{ route('register') }}"
                      class="login__form{!! (Route::current()->getName() == 'register') ? ' is-active' : null !!}"
                      id="registration" method="post">
                    @csrf
                    <div class="login__form-heading">
                        <h1 class="login__form-title">Завести аккаунт</h1>

                    </div>
                    <ul class="login__form-items">
                        <li class="form-item">
                            <label for="registration--email">E-mail</label>
                            <input type="email" id="registration--email" name="email" placeholder="email@example.com"
                                   value="{{ old('email') }}" @error('email') class="is-haserror" @enderror>
                            <p class="system-msg">
                                @error('email') {{ $message }} <br> @enderror
                            </p>
                        </li>
                        <li class="form-item">
                            <label for="registration--phone">Номер телефона</label>
                            <input type="text" id="registration--phone" name="phone" placeholder="+7"
                                   value="{{ old('phone') }}"
                                   @error('phone') class="is-haserror" @enderror>
                            <p class="system-msg">
                                @error('phone') {{ $message }} <br> @enderror
                            </p>
                        </li>
                        <li class="form-item">
                            <label for="registration--password">Пароль</label>
                            <input type="password" id="registration--password" name="password" @error('password')
                            class="is-haserror" @enderror>
                            <button class="login__password-show-btn"></button>
                            <p class="system-msg">Минимум 6 символов, не менее 1 цифры, хотя бы 1 символ с
                                верхним регистром</p>
                            <p class="system-msg">
                                @error('password') {{ $message }} <br> @enderror
                            </p>
                        </li>
                        <li class="form-item">
                            <label for="registration--promo">Промокод</label>
                            <input type="text" id="registration--promo" placeholder="Необязательный">
                        </li>
                        <li class="form-item login-terms">
                            <input type="checkbox" id="registration--terms" name="agreement"
                                   {{ old('agreement') == 'on' ? 'checked' : null }} @error('agreement')
                            class="is-haserror"
                            @enderror>
                            <p class="system-msg">Я прочитал и согласен с&nbsp<a href="{!! route('agreement') !!}">Условиями
                                    и
                                    положениями Flame auction</a></p>
                            <p class="system-msg">
                                @error('agreement') {{ $message }} <br> @enderror
                                @if (isset($message))
                                    {!! $message !!}
                                @endif
                            </p>
                        </li>
                    </ul>
                    <button class="submit-btn">Зарегистрироваться</button>

                    <div style="margin-top: 79px; text-align: center">
                        <p class="login__form-subtitle">
                            Уже есть аккаунт?
                        </p>
                        <a href="{{ route('login') }}" style="color: #ffa01c; font-size: 13px;">Войти</a>
                    </div>
                </form>
            @endif
            @if (Route::current()->getName() == 'login')
                <form action="{{ route('login') }}"
                      class="login__form{!! (Route::current()->getName() == 'login') ? ' is-active' : null !!}" id="login"
                      method="post">
                    @include('partial.loginform')
                </form>
            @endif
        </div>
    </section>
@stop
