@include('header')
@include('menu')
<div class="overlay"></div>
<div class="wrapper">
    <div class="content">
        @include('sub-header')
        <div id="pay_mainblock" class="container">
            <div class="pad_block"></div>
            <div class="center">
                <div class="cap_line">
                    <a href="{{ url()->previous() }}" class="go_tomain"></a>
                    <h2>Купить ставки</h2>
                </div>
                <ul class="paycount_block">
                    @php
                        $count = 0;
                    @endphp
                    @foreach($data['items'] as $item)
                        @if($count < 8 || !$data['agent']->isDesktop())
                        <li class="paycount_item {{ $item->price > 29000 ? 'beige' : '' }}" data-id="{{ $item->id }}">
                            @if($item->old_price)
                                <div class="discount_value">-{{ $item->sale_percent . '%' }}</div>
                            @endif
                            <div class="paycount_icon"><img src="{{ $item->image }}" alt=""></div>
                            <div class="paycount_count">{{ $item->name }}</div>
                            @if($item->old_price)
                                <div class="paycount_price"><span>{{ $item->old_price }}</span>{{ $item->price }}</div>
                            @else
                                <div class="paycount_price">{{ $item->price }}</div>
                            @endif
                        </li>
                        @endif
                        @php
                            $count++;
                        @endphp
                    @endforeach
                </ul>
                <h2 class="payment_var_h2">Способ оплаты</h2>
                <div class="payment_list pay_active">
                    <ul class="payment_var">
                        <a href="{{ route('security') }}" target="_blank"><img src="../img/logos/Uniteller_Visa_MasterCard_MIR_1.png" alt="visa or mastercard"></a>
{{--                        <li>--}}
{{--                            <div class="payvar_logo"><img src="../img/logos/pay_apple.png" alt="Apple pay"></div>--}}
{{--                            <div class="payment_var_cap">Apple pay</div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <div class="payvar_logo"><img src="../img/logos/pay_google.png" alt="Google pay"></div>--}}
{{--                            <div class="payment_var_cap">Google pay</div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <div class="payvar_logo"><img src="../img/logos/pay_samsung.png" alt="Samsung pay"></div>--}}
{{--                            <div class="payment_var_cap">Samsung pay</div>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
@include('footer-js')
<script>
    $('.paycount_item').on('click', function() {
        var shopElementId = $(this).data('id');
        if(shopElementId === 'none') {
            var url = $(this).data('url');
            window.open(url);
        } else {
            window.location = '/buy/bid/' + shopElementId;
        }
    });
</script>
