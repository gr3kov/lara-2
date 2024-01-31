@include('header')
@include('menu')
<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="how_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="{{ url()->previous() }}" class="go_tomain"></a>
                    <h1>Как это работает</h1>
                </div>
                <div class="how_moreinfo">
                    <!-- <ol class="list">
                        <li><a href="#list_item1">Как это работает?</a></li>
                        <li><a href=""></a></li>
                        <li><a href=""></a></li>
                        <li><a href=""></a></li>
                        <li><a href=""></a></li>
                    </ol> -->
                    <div class="how_info">
                        <!-- <h3>Как это работает?</h3> -->
                        {!! $data['description'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
