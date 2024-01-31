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
                    <h1>{{ $title }}</h1>
                </div>
                <div class="how_moreinfo">
                    @if($data)
                    <ul class="item_list">
                        @php
                            $count = 0;
                        @endphp
                        @foreach($data as $category)
                            <li class="auction_item first-element">
                                <a href="/categories/{{ $category['slug'] }}" class="item_cap">{{ $category['h1'] }}</a>
                                <div class="item_pic">
                                    <a href="/categories/{{ $category['slug'] }}">
                                        <img height="100%" src="@if($category['img'] == '') /img/letter-back.png @else {{ $category['img'] }} @endif" alt="{{ $category['h1'] }}">
                                    </a>
                                </div>
                            </li>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                        @for($i = 0; 6 - ($count % 6) > $i; $i++)
                            <li style="height: 0; padding: 0;"></li>
                        @endfor
                    </ul>
                    @endif
                        <div id="archiveLinkBlock">
                            <a href="/" class="btn_makebid notstarted btn_archive">Аукцион</a>
                            <p class="label arcBtnComment">Лоты по указанной категории сейчас в архиве, посмотреть текущие лоты</p>
                        </div>
                    <div style="font-family: 'Open Sans', sans-serif;">
                        @if($name)
                            @if(file_exists(resource_path('views/seo-text/' . $name . '.blade.php')))
                                @include('seo-text.' . $name)
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
