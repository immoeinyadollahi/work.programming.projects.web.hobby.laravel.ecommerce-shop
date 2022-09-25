@php
$product = $item->productSu->product;
@endphp
<tr class="cart-table__row" data-cart-item-id="{{ $item->id }}">
    <td class="cart-table__column cart-table__column--image">
        <a href="/product/{{ $product->id }}/{{ $product->slug }}"><img src="{{ $product->image->url }}"
                alt="{{ $product->name }}"></a>
    </td>
    <td class="cart-table__column cart-table__column--product">
        <a href="/product/{{ $product->id }}/{{ $product->slug }}"
            class="cart-table__product-name">{{ $product->name }}
        </a>
        @if ($product->is_variable)
            <ul class="cart-table__options">
                @foreach ($item->productSu->variableProductTypeAttributes as $attribute_value)
                    <li class="d-flex align-items-center">
                        @switch($attribute_value->attribute->en)
                            @case('color')
                                <div class="color-attribute-style"
                                    style="background-color: {{ $attribute_value->meta->code }};"></div>
                            @break

                            @case('size')
                                <span class="fas fa-ruler-combined"></span>
                            @break
                        @endswitch
                        <span class="pr-2">{{ $attribute_value->fa }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </td>
    <td class="cart-table__column cart-table__column--price" data-title="قیمت">
        @if ($item->productSu->discounted_price)
            <div class="d-flex flex-column align-items-center">
                <span>{{ number_format($item->productSu->discounted_price) }} تومان</span>
                <small class="text-danger">
                    ({{ $item->productSu->discount_percent }}%)
                    {{ number_format($item->productSu->discount_price) }}
                    تومان
                </small>
            </div>
        @else
            {{ number_format($item->productSu->price) }} تومان
        @endif
    </td>
    <td class="cart-table__column cart-table__column--quantity" data-title="تعداد">
        <div class="input-number">
            <input class="form-control input-number__input js-quantity-input" type="number" min="1"
                value="{{ $item->quantity }}">
            <div class="input-number__add"></div>
            <div class="input-number__sub"></div>
        </div>
    </td>
    <td class="cart-table__column cart-table__column--total" data-title="جمع کل">
        {{ number_format($item->productSu->sale_price * $item->quantity) }} تومان</td>
    <td class="cart-table__column cart-table__column--remove">
        <a href="/cart/remove/{{ $item->id }}" class="btn btn-light btn-sm btn-svg-icon">
            <svg width="12px" height="12px">
                <use xlink:href="/public/main/images/sprite.svg#cross-12"></use>
            </svg>
        </a>
    </td>
</tr>
