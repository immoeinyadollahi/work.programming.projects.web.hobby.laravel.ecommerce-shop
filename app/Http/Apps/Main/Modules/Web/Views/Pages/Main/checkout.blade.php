@extends('layouts.master')
@section('page-title', 'پرداخت')
@section('page-content')
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">خانه</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">پرداخت</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>پرداخت</h1>
            </div>
        </div>
    </div>
    <div class="checkout block">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h5 class="card-title mb-0">آدرس تحویل سفارش</h5>
                                <a class="px-2" href="{{ _route('users.addresses.add') }}">افزودن جدید</a>
                            </div>
                            <div>
                                @if ($_user->addresses->isEmpty())
                                    <div class="alert alert-info m-0">
                                        در حال حاظر آدرسی برای شما ثبت نشده است
                                    </div>
                                @else
                                    @foreach ($_user->addresses as $key => $address)
                                        <div class="address-list-item card">
                                            <div class="address-card__body position-relative">
                                                <div class="address-radio-wrap">
                                                    <input type="radio" name="address" form="checkout-form"
                                                        id="address-{{ $key }}" value="{{ $address->id }}">
                                                    <label for="address-{{ $key }}"></label>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    {{ $address->postal_address }}
                                                    <div class="dropdown">
                                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                                            <span class="fas fa-ellipsis-v"></span>
                                                        </div>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-warning"
                                                                href="{{ _route('users.addresses.edit', ['address_id' => $address->id]) }}">ویرایش</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="text-muted">
                                                    {{ $address->recipient_fullname }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="card-divider"></div>
                        <div class="card-body">
                            @include('partials.coupon-form')
                            <div class="form-group mt-3">
                                <label>توضیحات سفارش <span class="text-muted">(اختیاری)</span></label>
                                <textarea class="form-control" name="description" form="checkout-form" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
                    <form class="card mb-0" id="checkout-form" method="POST">
                        @csrf
                        <div class="card-body">
                            <h3 class="card-title">سفارش شما</h3>
                            @include('shared::partials.checkout-info', ['cart' => $_cart])
                            <div class="payment-methods">
                                <ul class="payment-methods__list">
                                    <li class="payment-methods__item payment-methods__item--active">
                                        <label class="payment-methods__item-header"><span
                                                class="payment-methods__item-radio input-radio"><span
                                                    class="input-radio__body"><input class="input-radio__input"
                                                        name="checkout_payment_method" type="radio" checked> <span
                                                        class="input-radio__circle"></span> </span>
                                            </span><span class="payment-methods__item-title">فیش بانکی</span></label>
                                        <div class="payment-methods__item-container">
                                            <div class="payment-methods__item-description text-muted">لورم ایپسوم متن ساختگی
                                                با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                                چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای
                                                شرایط فعلی</div>
                                        </div>
                                    </li>
                                    <li class="payment-methods__item">
                                        <label class="payment-methods__item-header"><span
                                                class="payment-methods__item-radio input-radio"><span
                                                    class="input-radio__body"><input class="input-radio__input"
                                                        name="checkout_payment_method" type="radio"> <span
                                                        class="input-radio__circle"></span> </span>
                                            </span><span class="payment-methods__item-title">پرداخت با چک</span></label>
                                        <div class="payment-methods__item-container">
                                            <div class="payment-methods__item-description text-muted">لورم ایپسوم متن ساختگی
                                                با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                                چاپگرها</div>
                                        </div>
                                    </li>
                                    <li class="payment-methods__item">
                                        <label class="payment-methods__item-header"><span
                                                class="payment-methods__item-radio input-radio"><span
                                                    class="input-radio__body"><input class="input-radio__input"
                                                        name="checkout_payment_method" type="radio"> <span
                                                        class="input-radio__circle"></span> </span>
                                            </span><span class="payment-methods__item-title">پرداخت در محل</span></label>
                                        <div class="payment-methods__item-container">
                                            <div class="payment-methods__item-description text-muted">لورم ایپسوم متن
                                                ساختگی
                                                با تولید</div>
                                        </div>
                                    </li>
                                    <li class="payment-methods__item">
                                        <label class="payment-methods__item-header"><span
                                                class="payment-methods__item-radio input-radio"><span
                                                    class="input-radio__body"><input class="input-radio__input"
                                                        name="checkout_payment_method" type="radio"> <span
                                                        class="input-radio__circle"></span> </span>
                                            </span><span class="payment-methods__item-title">پرداخت آنلاین</span></label>
                                        <div class="payment-methods__item-container">
                                            <div class="payment-methods__item-description text-muted">لورم ایپسوم متن
                                                ساختگی
                                                با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <button class="btn btn-primary btn-xl btn-block">پرداخت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
