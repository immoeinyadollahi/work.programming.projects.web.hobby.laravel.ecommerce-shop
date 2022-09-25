@php
$product_route = _route('product', ['product_id' => $product->id, 'product_slug' => $product->slug]);
$selected_su = $product->selectedSu;
@endphp
<div class="product-card">
    <span data-component="quickview-btn" data-component-props='{"productId":{{ $product->id }}}'></span>
    <div class="product-card__image">
        <a href="{{ $product_route }}"><img src="{{ $product->image->url }}" alt="{{ $product->name }}"></a>
    </div>
    <div class="product-card__info">
        <div class="product-card__name"><a href="{{ $product_route }}">{{ $product->name }}</a></div>
    </div>
    <div class="product-card__actions">
        <div class="product-card__prices">
            @if ($selected_su->stock)
                @if ($selected_su->discounted_price)
                    <div class="product-card__new-price">{{ number_format($selected_su->discounted_price) }}
                        تومان</div>
                    <div class="product-card__old-price">{{ number_format($selected_su->price) }} تومان</div>
                @else
                    <div>{{ number_format($selected_su->price) }} تومان</div>
                    <div class="product-card__size-placeholder"></div>
                @endif
            @else
                ناموجود
            @endif
        </div>
        <div class="product-card__buttons">
            <div className="d-flex justify-content-end m-0 w-100">
                <a href="{{ _route('favourite.product', ['product_id' => $product->id]) }}"
                    class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist"
                    {!! $product->is_user_favourite ? 'style="fill: red;"' : '' !!}>
                    <svg width="16px" height="16px">
                        <use xlink:href="/public/main/images/sprite.svg#wishlist-16">
                        </use>
                    </svg>
                    <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                </a>
                <a href="{{ _route('compare', ['comparable_product_1' => $product->id]) }}"
                    class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare">
                    <svg width="16px" height="16px">
                        <use xlink:href="/public/main/images/sprite.svg#compare-16">
                        </use>
                    </svg>
                    <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                </a>
            </div>
        </div>
    </div>
</div>
