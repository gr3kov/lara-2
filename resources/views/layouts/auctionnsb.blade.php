<!DOCTYPE html>
<html lang="ru">

    <head>
        @include('partial.head')
    </head>

    <body>
        <div class="body__wrapper">
            <div class="body">
                <main class="login">
                    <header class="login__header">
                        <div class="logo">
                            <a href="https://project8209146.tilda.ws" class="logo-img">
                                <img src="./img/new-logo.svg" alt="">
                            </a>
                        </div>
                        <button id="login--language"></button>
                    </header>
                    @yield('content')
                </main>
            </div>
        </div>
    </body>

    @include('partial.scripts')

</html>
