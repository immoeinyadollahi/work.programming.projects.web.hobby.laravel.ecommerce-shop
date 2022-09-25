<table class="checkout__totals js-checkout-info">
    <thead class="checkout__totals-header">
        <tr>
            <th>محصول</th>
            <th>جمع کل</th>
        </tr>
    </thead>
    <tbody class="checkout__totals-products">
        @foreach ($cart->items as $item)
            @php
                $product = $item->productSu->product;
                $total_price = $item->productSu->sale_price * $item->quantity;
            @endphp
            <tr>
                <td>
                    <p class="m-0">{{ $product->name }}</p>
                    <span class="text-muted">{{ $item->quantity }} عدد</span>
                </td>
                <td>
                    <p class="m-0"> {{ number_format($total_price) }}
                        تومان</p>
                    @if ($item->productSu->discounted_price)
                        <small class="text-danger">
                            {{ number_format($item->productSu->price * $item->quantity - $total_price) }}
                            تومان تخفیف
                        </small>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tbody class="checkout__totals-subtotals">
        <tr>
            <th> قیمت کالاها ({{ count($cart->items) }})</th>
            <td>{{ number_format($cart->info['items_total_price']) }} تومان</td>
        </tr>
        @if ($cart->info['coupon'])
            <tr class="text-danger">
                <th> کد تخفیف</th>
                <td>({{ $cart->info['coupon']->amount }}%)
                    {{ number_format($cart->info['coupon_price']) }}
                    تومان
                </td>
            </tr>
        @endif
    </tbody>
    <tfoot class="checkout__totals-footer">
        <tr>
            <th>قابل پرداخت</th>
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
