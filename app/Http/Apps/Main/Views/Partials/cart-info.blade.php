<div class="card js-cart-info">
    <div class="card-body">
        <h3 class="card-title">مجموع سبد</h3>
        <table class="cart__totals">
            <thead class="cart__totals-header">
                <tr>
                    <th> قیمت کالاها ({{ count($cart->items) }})</th>
                    <td>{{ number_format($cart->info['items_total_price']) }} تومان</td>
                </tr>
                @if ($cart->info['coupon'])
                    <tr class="text-danger">
                        <th> کد تخفیف</th>
                        <td>({{ $cart->info['coupon']->amount }}%) {{ number_format($cart->info['coupon_price']) }}
                            تومان
                        </td>
                    </tr>
                @endif
            </thead>
            <tfoot class="cart__totals-footer">
                <tr>
                    <th>جمع سبد خرید</th>
                    <td>{{ number_format($cart->info['payment_cost']) }} تومان</td>
                </tr>
                @if ($cart->info['total_discount_price'])
                    <tr class="text-danger" style="font-size: 15px">
                        <th>سود شما از خرید</th>
                        <td>({{ $cart->info['total_discount_percent'] }}%)
                            {{ number_format($cart->info['total_discount_price']) }}
                            تومان
                        </td>
                    </tr>
                @endif
            </tfoot>
        </table>
        <a class="btn btn-primary btn-xl btn-block cart__checkout-button" href="/checkout">پرداخت</a>
    </div>
</div>
</div>
