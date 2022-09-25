@extends('layouts.master')
@section('page-title', 'سبد خرید')
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
                        <li class="breadcrumb-item active" aria-current="page">سبد خرید</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>سبد خرید</h1>
            </div>
        </div>
    </div>
    @if ($_cart && count($_cart->items))
        <div class="cart block">
            <div class="container">
                <table class="cart__table cart-table mb-4">
                    <thead class="cart-table__head">
                        <tr class="cart-table__row">
                            <th class="cart-table__column cart-table__column--image">تصویر</th>
                            <th class="cart-table__column cart-table__column--product">محصول</th>
                            <th class="cart-table__column cart-table__column--price">قیمت محصول</th>
                            <th class="cart-table__column cart-table__column--quantity">تعداد</th>
                            <th class="cart-table__column cart-table__column--total">جمع کل</th>
                            <th class="cart-table__column cart-table__column--remove"></th>
                        </tr>
                    </thead>
                    <tbody class="cart-table__body">
                        @each('shared::partials.cart-item', $_cart->items, 'item')
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        @include('partials.coupon-form')
                    </div>
                    <div class="col-lg-6">
                        @include('shared::partials.cart-info', ['cart' => $_cart])
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="block-empty__body">
            <div class="block-empty__message">سبد خرید شما خالی است!</div>
        </div>
    @endif

@endsection
