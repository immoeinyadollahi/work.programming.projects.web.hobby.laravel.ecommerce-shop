@extends('layouts.master')
@section('page-title', 'خانه')
@section('page-content')
    <!-- .block-slideshow -->
    @php
    $slideshow_slides = $_settings->slideshow['slides'];
    @endphp
    @if ($slideshow_slides)
        <div class="block-slideshow block-slideshow--layout--full block">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="block-slideshow__body">
                            <div class="owl-carousel">
                                @foreach ($slideshow_slides as $slide)
                                    <div class="block-slideshow__slide">
                                        <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop"
                                            style="background-image: url('{{ $slide['images']['desktop']['url'] }}')">
                                        </div>
                                        <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile"
                                            style="background-image: url('{{ $slide['images']['mobile']['url'] }}')">
                                        </div>
                                        <div class="block-slideshow__slide-content">
                                            <div class="block-slideshow__slide-title">{{ $slide['title'] }}</div>
                                            <div class="block-slideshow__slide-text">{{ $slide['description'] }}</div>
                                            @if ($slide['link']['title'])
                                                <div class="block-slideshow__slide-button"><a
                                                        href="{{ $slide['link']['url'] }}"
                                                        class="btn btn-primary btn-lg">{{ $slide['link']['title'] }}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- .block-slideshow / end -->
    @if ($special_offer_products->isNotEmpty())
        <!-- .block-products-carousel -->
        <div class="block block-products-carousel" data-layout="grid-4">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">پیشنهادات ویژه</h3>
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
                        @foreach ($special_offer_products as $product)
                            <div class="block-products-carousel__column">
                                <div class="block-products-carousel__cell">
                                    @include('shared.product-card', compact('product'))
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- .block-products-carousel / end -->
    @endif
    @if ($best_selling_products->isNotEmpty())
        <!-- .block-products-carousel -->
        <div class="block block-products-carousel" data-layout="grid-4">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">پرفروش ترین ها</h3>
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
                        @foreach ($best_selling_products as $product)
                            <div class="block-products-carousel__column">
                                <div class="block-products-carousel__cell">
                                    @include('shared.product-card', compact('product'))
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- .block-products-carousel / end -->
    @endif
    <!-- .block-categories -->
    @if ($popular_categories->isNotEmpty())
        <div class="block block--highlighted block-categories block-categories--layout--classic">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">دسته های محبوب</h3>
                    <div class="block-header__divider"></div>
                </div>
                <div class="block-categories__list">
                    @foreach ($popular_categories as $category)
                        <div class="block-categories__item category-card category-card--layout--classic">
                            <div class="category-card__body d-flex align-items-center">
                                <div class="category-card__image">
                                    <a href="/shop/{{ $category->slug }}"><img src="{{ $category->image->url }}"
                                            alt="{{ $category->fa }}"></a>
                                </div>
                                <div class="category-card__content">
                                    <div class="category-card__name"><a
                                            href="/shop/{{ $category->slug }}">{{ $category->fa }}</a></div>
                                    <small class="text-muted">{{ $category->products_count }} محصول</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <!-- .block-categories / end -->
    <!-- .block-products-carousel -->
    @if ($latest_products->isNotEmpty())
        <div class="block block-products-carousel" data-layout="grid-4">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">محصولات جدید</h3>
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
                        @foreach ($latest_products as $product)
                            <div class="block-products-carousel__column">
                                <div class="block-products-carousel__cell">
                                    @include('shared.product-card', compact('product'))
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- .block-products-carousel / end -->
    <!-- .block-posts -->
    @if ($latest_posts->isNotEmpty())
        <div class="block block-posts block-posts--layout--list-sm" data-layout="list-sm">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">آخرین های بلاگ</h3>
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
                <div class="block-posts__slider">
                    <div class="owl-carousel">
                        @foreach ($latest_posts as $post)
                            @php
                                $post_url = route('post', ['post_id' => $post->id, 'post_slug' => $post->slug]);
                            @endphp
                            <div class="post-card">
                                <div class="post-card__image">
                                    <a href="{{ $post_url }}">
                                        <img src="{{ $post->image->url }}" alt="{{ $post->title }}">
                                    </a>
                                </div>
                                <div class="post-card__info">
                                    <div class="post-card__name">
                                        <a href="{{ $post_url }}">{{ $post->title }}</a>
                                    </div>
                                    <div class="post-card__date">{{ _Date::formatDate($post->published_at) }}</div>
                                    <div class="post-card__content">{{ $post->short_description }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- .block-posts / end -->
    <!-- .block-brands -->
    @if ($popular_brands->isNotEmpty())
        <div class="block block-brands">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">محبوب ترین برند ها</h3>
                    <div class="block-header__divider"></div>
                </div>
                <div class="block-brands__slider">
                    <div class="owl-carousel">
                        @foreach ($popular_brands as $brand)
                            <div class="block-brands__item">
                                <a href="/brand/{{ $brand->slug }}">
                                    <img src="{{ $brand->image->url }}" alt="{{ $brand->fa }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    @endif
    </div>
    <!-- .block-brands / end -->
@endsection
@section('page-scripts')
    <script>
        __DATA__.dependencies.push("shared.quickview-btn");
    </script>
@endsection
