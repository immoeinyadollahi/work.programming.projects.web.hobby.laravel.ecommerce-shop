@extends('layouts.master')
@section('page-title', $product->name)
@section('page-content')
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">خانه</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        @foreach ($product->categories as $category)
                            <li class="breadcrumb-item">
                                <a href="/shop/{{ $category->slug }}">{{ $category->fa }}</a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                        @endforeach
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="product product--layout--columnar" data-layout="columnar">
                <div class="product__content">
                    <!-- .product__gallery -->
                    <div class="product__gallery">
                        <div class="product-gallery">
                            <div class="product-gallery__featured">
                                <div class="owl-carousel" id="product-image">
                                    @foreach ($product->thumbnails as $thumbnail)
                                        <a href="{{ $thumbnail->url }}">
                                            <img src="{{ $thumbnail->url }}" alt="{{ $product->name }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="product-gallery__carousel">
                                <div class="owl-carousel" id="product-carousel">
                                    @foreach ($product->thumbnails as $thumbnail)
                                        <a href="" class="product-gallery__carousel-item">
                                            <img class="product-gallery__carousel-image" src="{{ $thumbnail->url }}"
                                                alt="{{ $product->name }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .product__gallery / end -->
                    <!-- .product__info -->
                    <div class="product__info">
                        <div class="product__wishlist-compare">
                            <a href="{{ _route('favourite.product', ['product_id' => $product->id]) }}"
                                class="btn btn-sm btn-light btn-svg-icon" {!! $product->is_user_favourite ? 'style="fill: red;"' : '' !!} data-toggle="tooltip"
                                data-placement="right" title="علاقه مندی">
                                <svg width="16px" height="16px">
                                    <use xlink:href="/public/main/images/sprite.svg#wishlist-16"></use>
                                </svg>
                            </a>
                            <a href="{{ _route('compare', ['comparable_product_1' => $product->id]) }}"
                                class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right"
                                title="مقایسه">
                                <svg width="16px" height="16px">
                                    <use xlink:href="/public/main/images/sprite.svg#compare-16"></use>
                                </svg>
                            </a>
                        </div>
                        <h1 class="product__name">{{ $product->name }}</h1>
                        <div class="d-lg-block d-flex align-items-center justify-content-between">
                            <div class="product__rating">
                                <div class="product__rating-stars">
                                    <div class="rating">
                                        <div class="rating__body">
                                            @foreach (range(1, 5) as $star)
                                                <svg class="rating__star{{ $product->final_rating >= $star ? ' rating__star--active' : '' }}"
                                                    width="13px" height="12px">
                                                    <g class="rating__fill">
                                                        <use xlink:href="/public/main/images/sprite.svg#star-normal"></use>
                                                    </g>
                                                    <g class="rating__stroke">
                                                        <use xlink:href="/public/main/images/sprite.svg#star-normal-stroke">
                                                        </use>
                                                    </g>
                                                </svg>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="product__wishlist-compare d-lg-none d-flex flex-lg-column flex-row align-items-center">
                                <a href="{{ _route('favourite.product', ['product_id' => $product->id]) }}"
                                    class="btn btn-sm btn-light btn-svg-icon" {!! $product->is_user_favourite ? 'style="fill: red;"' : '' !!}>
                                    <svg width="16px" height="16px">
                                        <use xlink:href="/public/main/images/sprite.svg#wishlist-16"></use>
                                    </svg>
                                </a>
                                <a href="{{ _route('compare', ['comparable_product_1' => $product->id]) }}"
                                    class="btn btn-sm btn-light btn-svg-icon">
                                    <svg width="16px" height="16px">
                                        <use xlink:href="/public/main/images/sprite.svg#compare-16"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <ul class="product__features mt-3">
                            <li>سرعت: 750 RPM</li>
                            <li>منبع تغزیه: برق</li>
                            <li>نوع باتری: لیتیوم</li>
                            <li>ولتاژ: 20 ولت</li>
                            <li>ظرفیت باتری: 2 ساعت</li>
                        </ul>
                        <ul class="product__meta">
                            <li class="product__meta-availability">
                                موجودی:
                                @if ($product->selectedSu->stock)
                                    <span class="text-success">موجود در انبار</span>
                                @else
                                    <span class="text-danger">ناموجود</span>
                                @endif
                            </li>
                            <li>برند: <a href="/brand/{{ $product->brand->slug }}">{{ $product->brand->fa }}</a></li>
                        </ul>
                    </div>
                    <!-- .product__info / end -->
                    <!-- .product__sidebar -->
                    <div class="product__sidebar" data-component="sidebar">

                    </div>
                    <!-- .product__end -->
                    <div class="product__footer">
                        <div class="product__tags tags">
                            <div class="tags__list">
                                @foreach ($product->tags as $tag)
                                    <a href="/search?tag={{ $tag->slug }}">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-tabs">
                <div class="product-tabs__list">
                    <a href="#tab-description" class="product-tabs__item product-tabs__item--active">توضیحات</a>
                    <a href="#tab-specification" class="product-tabs__item">مشخصات</a>
                    <a href="#tab-reviews" class="product-tabs__item">دیدگاه ها</a>
                </div>
                <div class="product-tabs__content">
                    <div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
                        <div class="typography">
                            {!! $product->description !!}
                        </div>
                    </div>
                    <div class="product-tabs__pane" id="tab-specification">
                        <div class="spec">
                            <h3 class="spec__header">مشخصات</h3>
                            <div>
                                @foreach ($product->specification_groups as $key => $group)
                                    <div class="spec__section" {{ $key > 0 ? 'data-show-more' : '' }}>
                                        <h4 class="spec__section-title">{{ $group->name }}</h4>
                                        @foreach ($group->items as $item)
                                            <div class="spec__row">
                                                <div class="spec__name">{{ $item->name }}</div>
                                                <div class="spec__value">
                                                    @if ($item->type === 'boolean')
                                                        <span
                                                            class="fas {{ $item->value ? 'fa-check text-success' : 'fa-times text-danger' }}"></span>
                                                    @else
                                                        {{ $item->value }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            @if (count($product->specification_groups) > 1)
                                <div class="mt-3 text-primary js-show-more" style="cursor: pointer">نمایش بیشتر</div>
                            @endif
                        </div>
                    </div>
                    <div class="product-tabs__pane" id="tab-reviews">
                        <div class="reviews-view">
                            <div class="reviews-view__list">
                                <h3 class="reviews-view__header">دیدگاه کاربران</h3>
                                @if ($product->comments_paginator->isEmpty())
                                    <div class="alert alert-warning text-center">دیدگاهی برای این محصول ثبت نشده است</div>
                                @else
                                    @include('shared::partials.product-comments', [
                                        'paginator' => $product->comments_paginator,
                                    ])
                                @endif
                            </div>
                            @if ($_user)
                                <form class="reviews-view__form" method="POST"
                                    action="/product/{{ $product->id }}/comment">
                                    @csrf
                                    <h3 class="reviews-view__header">یک دیدگاه بنویسید</h3>
                                    <div class="row">
                                        <div class="col-12 col-lg-9 col-xl-8">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="review-stars">تعداد ستاره</label>
                                                    <select id="review-stars" name="rating"
                                                        class="form-control{{ $errors->has('rating') ? ' is-invalid' : '' }}">
                                                        <option value="0">بدون امتیاز</option>
                                                        <option value="1">امتیاز 1 ستاره</option>
                                                        <option value="2">امتیاز 2 ستاره</option>
                                                        <option value="3">امتیاز 3 ستاره</option>
                                                        <option value="4">امتیاز 4 ستاره</option>
                                                        <option value="5">امتیاز 5 ستاره</option>
                                                    </select>
                                                    @error('rating')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="review-text">متن دیدگاه</label>
                                                <textarea class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" id="review-text" name="text"
                                                    rows="6">{{ old('text') }}</textarea>
                                                @error('text')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-primary btn-lg">ثبت</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-warning text-center mb-0 mt-3">برای ثبت دیدگاه ابتدا باید وارد شوید
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .block-products-carousel -->
    @if ($product->related_products->isNotEmpty())
        <div class="block block-products-carousel" data-layout="grid-4">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">محصولات مرتبط</h3>
                    <div class="block-header__divider"></div>
                    <div class="block-header__arrows-list">
                        <button class="block-header__arrow block-header__arrow--left" type="button">
                            <svg width="7px" height="11px">
                                <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-left-7x11"></use>
                            </svg>
                        </button>
                        <button class="block-header__arrow block-header__arrow--right" type="button">
                            <svg width="7px" height="11px">
                                <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-right-7x11"></use>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="block-products-carousel__slider">
                    <div class="block-products-carousel__preloader"></div>
                    <div class="owl-carousel">
                        @foreach ($product->related_products as $related_product)
                            <div class="block-products-carousel__column">
                                <div class="block-products-carousel__cell">
                                    @include('shared.product-card', ['product' => $related_product])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- .block-products-carousel / end -->
@endsection
@section('page-scripts')
    <script>
        __DATA__.dependencies.push("pages.product");
        Object.assign(__DATA__.pageData, {
            product: @json($product),
        })
    </script>
@endsection
