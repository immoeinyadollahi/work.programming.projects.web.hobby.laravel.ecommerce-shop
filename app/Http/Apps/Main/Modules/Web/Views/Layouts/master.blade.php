@php
$has_any_cart_item = $_cart && count($_cart->items);
$user_pages = [
    [
        'name' => 'users.dashboard',
        'title' => 'داشبورد',
    ],
    [
        'name' => 'users.profile',
        'title' => 'ویرایش پروفایل',
    ],
    [
        'name' => 'users.orders',
        'title' => 'سفارش ها',
    ],
    [
        'name' => 'users.addresses',
        'title' => 'آدرس ها',
    ],
    [
        'name' => 'users.change-password',
        'title' => 'تغییر رمز عبور',
    ],
];
@endphp
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title>@yield('page-title')</title>
    <link rel="icon" type="image/png" href="/public/main/images/favicon.ico">
    <!-- css -->
    <link rel="stylesheet" href="/public/main/vendor/fontawesome-5.6.3/css/all.min.css">
    <link rel="stylesheet" href="/public/main/vendor/bootstrap-4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/main/vendor/owl-carousel-2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/public/main/vendor/lightgallery-1.6.12/css/lightgallery.min.css">
    <link rel="stylesheet" href="/public/main/fonts/stroyka/stroyka.css">
    <link rel="stylesheet" href="/public/main/css/style.css">
    <link rel="stylesheet" href="/public/main/css/custom.css">
    <link rel="stylesheet" href="{{ _mix('/css/style.css') }}">
</head>

<body>
    <!-- mobilemenu -->
    <div class="mobilemenu">
        <div class="mobilemenu__backdrop"></div>
        <div class="mobilemenu__body">
            <div class="mobilemenu__header">
                <div class="mobilemenu__title">منو</div>
                <button type="button" class="mobilemenu__close">
                    <svg width="20px" height="20px">
                        <use xlink:href="/public/main/images/sprite.svg#cross-20"></use>
                    </svg>
                </button>
            </div>
            <div class="mobilemenu__content">
                <ul class="mobile-links mobile-links--level--0" data-collapse
                    data-collapse-opened-class="mobile-links__item--open">
                    <li class="mobile-links__item">
                        <div class="mobile-links__item-title"><a href="index.html"
                                class="mobile-links__item-link">خانه</a>
                        </div>
                    </li>
                    <li class="mobile-links__item">
                        <div class="mobile-links__item-title"><a href="index.html"
                                class="mobile-links__item-link">بلاگ</a>
                        </div>
                    </li>
                    <li class="mobile-links__item" data-collapse-item>
                        <div class="mobile-links__item-title"><a href="" class="mobile-links__item-link">
                                دسته بندی ها</a>
                            <button class="mobile-links__item-toggle" type="button" data-collapse-trigger>
                                <svg class="mobile-links__item-arrow" width="12px" height="7px">
                                    <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-down-12x7">
                                    </use>
                                </svg>
                            </button>
                        </div>
                        <div class="mobile-links__item-sub-links" data-collapse-content>
                            <ul class="mobile-links mobile-links--level--1">
                                @foreach ($_categories as $cat_1)
                                    <li class="mobile-links__item" data-collapse-item>
                                        <div class="mobile-links__item-title">
                                            <a href="/shop/{{ $cat_1->slug }}"
                                                class="mobile-links__item-link">{{ $cat_1->fa }}</a>
                                            <button class="mobile-links__item-toggle" type="button"
                                                data-collapse-trigger>
                                                <svg class="mobile-links__item-arrow" width="12px" height="7px">
                                                    <use
                                                        xlink:href="/public/main/images/sprite.svg#arrow-rounded-down-12x7">
                                                    </use>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="mobile-links__item-sub-links" data-collapse-content>
                                            <ul class="mobile-links mobile-links--level--2">
                                                @foreach ($cat_1->children as $cat_2)
                                                    <li class="mobile-links__item" data-collapse-item>
                                                        <div class="mobile-links__item-title">
                                                            <a href="/shop/{{ $cat_2->slug }}"
                                                                class="mobile-links__item-link">{{ $cat_2->fa }}</a>
                                                            @if ($cat_2->children)
                                                                <button class="mobile-links__item-toggle" type="button"
                                                                    data-collapse-trigger>
                                                                    <svg class="mobile-links__item-arrow" width="12px"
                                                                        height="7px">
                                                                        <use
                                                                            xlink:href="/public/main/images/sprite.svg#arrow-rounded-down-12x7">
                                                                        </use>
                                                                    </svg>
                                                                </button>
                                                            @endif
                                                        </div>
                                                        @if ($cat_2->children)
                                                            <div class="mobile-links__item-sub-links"
                                                                data-collapse-content>
                                                                <ul class="mobile-links mobile-links--level--3">
                                                                    @foreach ($cat_2->children as $cat_3)
                                                                        <li class="mobile-links__item"
                                                                            data-collapse-item>
                                                                            <div class="mobile-links__item-title">
                                                                                <a href="/shop/{{ $cat_3->slug }}"
                                                                                    class="mobile-links__item-link">
                                                                                    {{ $cat_3->fa }}
                                                                                </a>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="mobile-links__item" data-collapse-item>
                        <div class="mobile-links__item-title"><a href="account-login.html"
                                class="mobile-links__item-link">حساب کاربری</a>
                            <button class="mobile-links__item-toggle" type="button" data-collapse-trigger>
                                <svg class="mobile-links__item-arrow" width="12px" height="7px">
                                    <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-down-12x7">
                                    </use>
                                </svg>
                            </button>
                        </div>
                        <div class="mobile-links__item-sub-links" data-collapse-content>
                            <ul class="mobile-links mobile-links--level--1">
                                @if ($_user)
                                    @foreach ($user_pages as $page)
                                        <li class="mobile-links__item" data-collapse-item>
                                            <div class="mobile-links__item-title"><a
                                                    href="{{ _route($page['name']) }}"
                                                    class="mobile-links__item-link">{{ $page['title'] }}</a></div>
                                        </li>
                                    @endforeach
                                    <li class="mobile-links__item" data-collapse-item>
                                        <div class="mobile-links__item-title"><a href="/logout"
                                                class="mobile-links__item-link">خروج</a></div>
                                    </li>
                                @else
                                    <li class="mobile-links__item" data-collapse-item>
                                        <div class="mobile-links__item-title"><a href="/login"
                                                class="mobile-links__item-link">ورود</a></div>
                                    </li>
                                    <li class="mobile-links__item" data-collapse-item>
                                        <div class="mobile-links__item-title"><a href="/register"
                                                class="mobile-links__item-link">ثبت نام</a></div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- mobilemenu / end -->
    <!-- site -->
    <div class="site">
        <!-- mobile site__header -->
        <header class="site__header d-lg-none">
            <div class="mobile-header mobile-header--sticky mobile-header--stuck">
                <div class="mobile-header__panel">
                    <div class="container">
                        <div class="mobile-header__body">
                            <button class="mobile-header__menu-button">
                                <svg width="18px" height="14px">
                                    <use xlink:href="/public/main/images/sprite.svg#menu-18x14"></use>
                                </svg>
                            </button>
                            <a class="mobile-header__logo" href="/">
                                <img src="{{ $_settings->logo['url'] }}" alt="logo"
                                    style="width:120px; height:20px;">
                            </a>
                            <div class="mobile-header__search">
                                <form class="mobile-header__search-form" action="/search">
                                    <input class="mobile-header__search-input" name="q"
                                        value="{{ _is_route('search', 'shop') && isset($search_term) && is_string($search_term) ? $search_term : '' }}"
                                        placeholder="جستجو کالا ها" aria-label="Site search" type="text"
                                        autocomplete="off">
                                    <button class="mobile-header__search-button mobile-header__search-button--submit"
                                        type="submit">
                                        <svg width="20px" height="20px">
                                            <use xlink:href="/public/main/images/sprite.svg#search-20">
                                            </use>
                                        </svg>
                                    </button>
                                    <button class="mobile-header__search-button mobile-header__search-button--close"
                                        type="button">
                                        <svg width="20px" height="20px">
                                            <use xlink:href="/public/main/images/sprite.svg#cross-20"></use>
                                        </svg>
                                    </button>
                                    <div class="mobile-header__search-body"></div>
                                </form>
                            </div>
                            <div class="mobile-header__indicators">
                                <div class="indicator indicator--mobile-search indicator--mobile d-sm-none">
                                    <button class="indicator__button"><span class="indicator__area"><svg
                                                width="20px" height="20px">
                                                <use xlink:href="/public/main/images/sprite.svg#search-20">
                                                </use>
                                            </svg></span></button>
                                </div>
                                <div class="indicator indicator--mobile d-sm-flex d-none"><a href="/wishlist"
                                        class="indicator__button"><span class="indicator__area"><svg width="20px"
                                                height="20px">
                                                <use xlink:href="/public/main/images/sprite.svg#heart-20">
                                                </use>
                                            </svg>
                                            @if ($_user && $_user->favourite_products_count)
                                                <span
                                                    class="indicator__value">{{ $_user->favourite_products_count }}</span>
                                            @endif
                                        </span></a></div>
                                <div class="indicator indicator--mobile"><a href="/cart"
                                        class="indicator__button"><span class="indicator__area"><svg width="20px"
                                                height="20px">
                                                <use xlink:href="/public/main/images/sprite.svg#cart-20">
                                                </use>
                                            </svg>
                                            @if ($has_any_cart_item)
                                                <span class="indicator__value">{{ count($_cart->items) }}</span>
                                            @endif
                                        </span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- mobile site__header / end -->
        <!-- desktop site__header -->
        <header class="site__header d-lg-block d-none">
            <div class="site-header">
                <!-- .topbar -->
                <div class="site-header__topbar topbar">
                    <div class="topbar__container container">
                        <div class="topbar__row">
                            <div class="topbar__item topbar__item--link"><a class="topbar-link"
                                    href="about-us.html">درباره ما</a></div>
                            <div class="topbar__item topbar__item--link"><a class="topbar-link"
                                    href="contact-us.html">تماس با ما</a></div>
                            <div class="topbar__spring"></div>
                            <div class="topbar__item">
                                <div class="topbar-dropdown">
                                    <button class="topbar-dropdown__btn" type="button">حساب کاربری
                                        <svg width="7px" height="5px">
                                            <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-down-7x5">
                                            </use>
                                        </svg>
                                    </button>
                                    <div class="topbar-dropdown__body">
                                        <!-- .menu -->
                                        <ul class="menu menu--layout--topbar">
                                            @if ($_user)
                                                @foreach ($user_pages as $page)
                                                    <li>
                                                        <a href="{{ _route($page['name']) }}">
                                                            {{ $page['title'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                                <li><a href="/logout">خروج</a></li>
                                            @else
                                                <li><a href="/login">ورود</a></li>
                                                <li><a href="/register">ثبت نام</a></li>
                                            @endif
                                        </ul>
                                        <!-- .menu / end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .topbar / end -->
                <div class="site-header__middle container">
                    <div class="site-header__logo">
                        <a href="/">
                            <img src="{{ $_settings->logo['url'] }}" alt="logo"
                                style="width:196px; height:40px;">
                        </a>
                    </div>
                    <div class="site-header__search">
                        <div class="search">
                            <form class="search__form" action="/search">
                                <input class="search__input" name="q"
                                    value="{{ _is_route('search') && isset($search_term) ? $search_term : '' }}"
                                    placeholder="جستجو کالا ها" aria-label="Site search" type="text"
                                    autocomplete="off">
                                <button class="search__button" type="submit">
                                    <svg width="20px" height="20px">
                                        <use xlink:href="/public/main/images/sprite.svg#search-20"></use>
                                    </svg>
                                </button>
                                <div class="search__border"></div>
                            </form>
                        </div>
                    </div>
                    @if ($_settings->phone)
                        <div class="site-header__phone">
                            <div class="site-header__phone-title">شماره تماس</div>
                            <div class="site-header__phone-number"><span
                                    class="ltr_text">{{ $_settings->phone }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="site-header__nav-panel">
                    <div class="nav-panel">
                        <div class="nav-panel__container container">
                            <div class="nav-panel__row">
                                <div class="nav-panel__departments">
                                    <!-- .departments -->
                                    <div class="departments" data-departments-fixed-by="">
                                        <div class="departments__body">
                                            <div class="departments__links-wrapper">
                                                <ul class="departments__links">
                                                    @foreach ($_categories as $cat_1)
                                                        <li class="departments__item">
                                                            <a href="/shop/{{ $cat_1->slug }}">
                                                                {{ $cat_1->fa }}
                                                                <svg class="departments__link-arrow" width="6px"
                                                                    height="9px">
                                                                    <use
                                                                        xlink:href="/public/main/images/sprite.svg#arrow-rounded-right-6x9">
                                                                    </use>
                                                                </svg>
                                                            </a>
                                                            <div
                                                                class="departments__megamenu departments__megamenu--xl">
                                                                <!-- .megamenu -->
                                                                <div
                                                                    class="megamenu megamenu--departments c-megamenu--departments">
                                                                    <ul class="c-megamenu__links">
                                                                        @foreach ($cat_1->children as $cat_2)
                                                                            <li class="c-megamenu__item">
                                                                                <a href="/shop/{{ $cat_2->slug }}"
                                                                                    class="c-megamenu__item--link title">
                                                                                    {{ $cat_2->fa }}
                                                                                </a>
                                                                            </li>
                                                                            @if ($cat_2->children)
                                                                                @foreach ($cat_2->children as $cat_3)
                                                                                    <li class="c-megamenu__item">
                                                                                        <a href="/shop/{{ $cat_3->slug }}"
                                                                                            class="c-megamenu__item--link">
                                                                                            {{ $cat_3->fa }}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>


                                                                </div>
                                                                <!-- .megamenu / end -->
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <button class="departments__button">
                                            <svg class="departments__button-icon" width="18px" height="14px">
                                                <use xlink:href="/public/main/images/sprite.svg#menu-18x14">
                                                </use>
                                            </svg> دسته‌بندی‌ ها
                                            <svg class="departments__button-arrow" width="9px" height="6px">
                                                <use
                                                    xlink:href="/public/main/images/sprite.svg#arrow-rounded-down-9x6">
                                                </use>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- .departments / end -->
                                </div>
                                <!-- .nav-links -->
                                <div class="nav-panel__nav-links nav-links">
                                    <ul class="nav-links__list">
                                        <li class="nav-links__item"><a href="/"><span>خانه</span></a></li>
                                        <li class="nav-links__item"><a href="/blog"><span>بلاگ</span></a></li>
                                    </ul>
                                </div>
                                <!-- .nav-links / end -->
                                <div class="nav-panel__indicators">
                                    <div class="indicator">
                                        <a href="/wishlist" class="indicator__button">
                                            <span class="indicator__area">
                                                <svg width="20px" height="20px">
                                                    <use xlink:href="/public/main/images/sprite.svg#heart-20">
                                                    </use>
                                                </svg>
                                                @if ($_user && $_user->favourite_products_count)
                                                    <span
                                                        class="indicator__value">{{ $_user->favourite_products_count }}</span>
                                                @endif
                                            </span>
                                        </a>
                                    </div>
                                    <div class="indicator indicator--trigger--click"><a href="#"
                                            class="indicator__button"><span class="indicator__area"><svg
                                                    width="20px" height="20px">
                                                    <use xlink:href="/public/main/images/sprite.svg#cart-20">
                                                    </use>
                                                </svg>
                                                @if ($has_any_cart_item)
                                                    <span class="indicator__value">{{ count($_cart->items) }}</span>
                                                @endif
                                            </span></a>
                                        <div class="indicator__dropdown">
                                            <!-- .dropcart -->
                                            <div class="dropcart">
                                                @if ($has_any_cart_item)
                                                    <div class="dropcart__products-list">
                                                        @foreach ($_cart->items as $item)
                                                            @php
                                                                $product = $item->productSu->product;
                                                                $total_price = $item->productSu->sale_price * $item->quantity;
                                                            @endphp
                                                            <div class="dropcart__product">
                                                                <div class="dropcart__product-image">
                                                                    <a
                                                                        href="/product/{{ $product->id }}/{{ $product->slug }}"><img
                                                                            src="{{ $product->image->url }}"
                                                                            alt="{{ $product->name }}"></a>
                                                                    <span
                                                                        class="d-flex justify-content-center">{{ $item->quantity }}
                                                                        عدد</span>
                                                                </div>
                                                                <div class="dropcart__product-info">
                                                                    <div class="dropcart__product-name"><a
                                                                            href="/product/{{ $product->id }}/{{ $product->slug }}">{{ $product->name }}</a>
                                                                    </div>
                                                                    <div class="dropcart__product-meta">
                                                                        @if ($product->is_variable)
                                                                            <ul class="dropcart__item_attributes">
                                                                                @foreach ($item->productSu->variableProductTypeAttributes as $attribute_value)
                                                                                    <li
                                                                                        class="d-flex align-items-center">
                                                                                        @switch($attribute_value->attribute->en)
                                                                                            @case('color')
                                                                                                <div class="color-attribute-style"
                                                                                                    style="background-color: {{ $attribute_value->meta->code }};">
                                                                                                </div>
                                                                                            @break

                                                                                            @case('size')
                                                                                                <span
                                                                                                    class="fas fa-ruler-combined"></span>
                                                                                            @break
                                                                                        @endswitch
                                                                                        <span
                                                                                            class="pr-2">{{ $attribute_value->fa }}</span>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                        <div style="line-height: 1.3">
                                                                            <span
                                                                                class="dropcart__product-price d-block">
                                                                                {{ number_format($total_price) }}
                                                                                تومان
                                                                            </span>
                                                                            @if ($item->productSu->discounted_price)
                                                                                <small class="text-danger"
                                                                                    style="font-size: 12px">
                                                                                    {{ number_format($item->productSu->price * $item->quantity - $total_price) }}
                                                                                    تومان تخفیف
                                                                                </small>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="/cart/remove/{{ $item->id }}"
                                                                    class="dropcart__product-remove btn btn-light btn-sm btn-svg-icon">
                                                                    <svg width="10px" height="10px">
                                                                        <use
                                                                            xlink:href="/public/main/images/sprite.svg#cross-10">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="dropcart__totals">
                                                        <table>
                                                            <tr>
                                                                <th>مبلغ قابل پرداخت</th>
                                                                <td>{{ number_format($_cart->info['payment_cost']) }}
                                                                    تومان</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="dropcart__buttons">
                                                        <a class="btn btn-secondary" href="/cart">مشاهده سبد</a>
                                                        <a class="btn btn-primary" href="/checkout">پرداخت</a>
                                                    </div>
                                                @else
                                                    <div class="dropcart__empty">سبد خرید شما خالی است</div>
                                                @endif
                                            </div>
                                            <!-- .dropcart / end -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- desktop site__header / end -->
        <!-- site__body -->
        <div class="site__body">
            <div class="container alert-container js-alert-container mt-3"
                style="{{ session()->has('messages') ? '' : 'display:none;' }}">
                @if (session()->has('messages'))
                    @foreach (session()->get('messages') as $item)
                        <div class="alert alert-{{ $item['level'] }} alert-dismissible fade show">
                            {{ $item['message'] }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
            @yield('page-content')
        </div>
        <!-- site__body / end -->
        <!-- site__footer -->
        <footer class="site__footer">
            <div class="site-footer">
                <div class="container">
                    <div class="site-footer__widgets">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="site-footer__widget footer-contacts">
                                    <h5 class="footer-contacts__title">تماس با ما</h5>
                                    <div class="footer-contacts__text">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                        صنعت چاپ و با استفاده از طراحان گرافیک است.</div>
                                    <ul class="footer-contacts__contacts">
                                        @if ($_settings->address)
                                            <li><i class="footer-contacts__icon fas fa-globe-americas"></i>
                                                {{ $_settings->address }}
                                            </li>
                                        @endif
                                        <li><i class="footer-contacts__icon far fa-envelope"></i> stroyka@example.com
                                        </li>
                                        @if ($_settings->phone)
                                            <li><i class="footer-contacts__icon fas fa-mobile-alt"></i>
                                                <span class="ltr_text">{{ $_settings->phone }}</span>

                                            </li>
                                        @endif
                                        <li><i class="footer-contacts__icon far fa-clock"></i> شنبه - پنجشنبه : 10 صبح
                                            -
                                            7 عصر</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="site-footer__widget footer-links">
                                    <h5 class="footer-links__title">اطلاعات</h5>
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">درباره
                                                ما</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">نحوه
                                                ارسال</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">حریم
                                                خصوصی</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">برند
                                                ها</a>
                                        </li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">تماس با
                                                ما</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">بازگشت
                                                ها</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">نقشه
                                                سایت</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="site-footer__widget footer-links">
                                    <h5 class="footer-links__title">حساب کاربری</h5>
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">مکان
                                                فروشگاه</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">سابقه
                                                خرید</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">علاقه‌مندی‌ها</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">خبرنامه</a>
                                        </li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">محصولات
                                                ویژه</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">کارت های
                                                هدیه</a></li>
                                        <li class="footer-links__item"><a href=""
                                                class="footer-links__link">نمایندگی
                                                ها</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="site-footer__widget footer-newsletter">
                                    <h5 class="footer-newsletter__title">خبرنامه</h5>
                                    <div class="footer-newsletter__text">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم
                                        از صنعت چاپ و با استفاده از طراحان گرافیک</div>
                                    <form action="" class="footer-newsletter__form">
                                        <label class="sr-only" for="footer-newsletter-address">آدرس
                                            ایمیل</label>
                                        <input type="text" class="footer-newsletter__form-input form-control"
                                            id="footer-newsletter-address" placeholder="... آدرس ایمیل"
                                            dir="ltr">
                                        <button class="footer-newsletter__form-button btn btn-primary">اشتراک</button>
                                    </form>
                                    @if (!collect($_settings->social_media)->values()->every(fn($value) => $value === ''))
                                        <div class="footer-newsletter__text footer-newsletter__text--social">
                                            ما را در شبکه های اجتماعی دنبال کنید
                                        </div>
                                        <ul class="footer-newsletter__social-links">
                                            @foreach ($_settings->social_media as $key => $value)
                                                @if ($value)
                                                    <li
                                                        class="footer-newsletter__social-link footer-newsletter__social-link--{{ $key }} rounded-circle">
                                                        <a href="{{ $value }}" target="_blank">
                                                            <i class="fab fa-{{ $key }}"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- site__footer / end -->
    </div>
    <!-- site / end -->
    <div class="page-loader js-page-loader">
        <div class="loader-inner">
            <div class="spinner-border"></div>
        </div>
    </div>
    <!-- js -->
    <script src="/public/main/vendor/jquery-3.3.1/jquery.min.js"></script>
    <script src="/public/main/vendor/bootstrap-4.2.1/js/bootstrap.bundle.min.js"></script>
    <script src="/public/main/vendor/owl-carousel-2.3.4/owl.carousel.min.js"></script>
    <script src="/public/main/vendor/nouislider-12.1.0/nouislider.min.js"></script>
    <script src="/public/main/vendor/lightgallery-1.6.12/js/lightgallery.min.js"></script>
    <script src="/public/main/vendor/lightgallery-1.6.12/js/lg-thumbnail.min.js"></script>
    <script src="/public/main/vendor/lightgallery-1.6.12/js/lg-zoom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
    <script src="/public/main/js/main.js"></script>
    <script src="/public/main/vendor/svg4everybody-2.1.9/svg4everybody.min.js"></script>
    <script src="/public/main/js/custom/script.js" defer></script>
    <script>
        svg4everybody();
    </script>
    <script src="{{ _mix('/js/manifest.js') }}" defer></script>
    <script src="{{ _mix('/js/vendor.js') }}" defer></script>
    <script src="{{ _mix('/js/app.js') }}" defer></script>
    <script>
        const __DATA__ = {
            pageData: {
                redux: {
                    user: null,
                    data: {},
                }
            },
            dependencies: []
        };
    </script>
    @yield('page-scripts')
</body>

</html>
