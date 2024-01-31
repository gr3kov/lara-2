<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Главная</title>
        <link rel="stylesheet" href="{!! asset('/landing/css/style.min.css') !!}">
    </head>
    <body>

        @yield('content')

        <script src="{!! asset('/landing/js/libs.min.js') !!}"></script>
        <script src="{!! asset('/landing/js/main.js') !!}"></script>

    </body>
</html>
