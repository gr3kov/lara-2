<!DOCTYPE html>
<html lang="ru">

    <head>
        @include('partial.head')
    </head>

    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>
    <body>
        <div class="body__wrapper">
            <div class="body">
                @include('partial.sidebar')

                <main class="main">
                    @include('partial.header')

                    @yield('content')

                    @include('partial.footer')
                </main>
            </div>
        </div>
    </body>

    @include('partial.scripts')

</html>
