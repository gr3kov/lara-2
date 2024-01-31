@include('header')
@include('menu')
<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="oferta_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="{{ url()->previous() }}" class="go_tomain"></a>
                    <h1>Публичная оферта</h1>
                </div>
                <div class="oferta_moreinfo">
                    {!! $data['description'] !!}
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
