@extends('layouts.master')
@section('page-title', 'علاقه مندی ها')
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
                        <li class="breadcrumb-item active" aria-current="page">علاقه مندی ها</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>علاقه مندی ها</h1>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            @if ($products->isEmpty())
                <div class="alert alert-info mb-0 text-center">لیست علاقه مندی ها خالی است</div>
            @else
                <table class="wishlist">
                    <thead class="wishlist__head">
                        <tr class="wishlist__row">
                            <th class="wishlist__column wishlist__column--image">تصویر</th>
                            <th class="wishlist__column wishlist__column--product">محصول</th>
                            <th class="wishlist__column wishlist__column--stock">وضعیت انبار</th>
                            <th class="wishlist__column wishlist__column--price">قیمت</th>
                            <th class="wishlist__column wishlist__column--remove">حذف</th>
                        </tr>
                    </thead>
                    <tbody class="wishlist__body">
                        @foreach ($products as $product)
                            @php
                                $selected_su = $product->selectedSu;
                            @endphp
                            <tr class="wishlist__row">
                                <td class="wishlist__column wishlist__column--image">
                                    <a href="/product/{{ $product->id }}/{{ $product->slug }}"><img
                                            src="{{ $product->image->url }}" alt="{{ $product->name }}"></a>
                                </td>
                                <td class="wishlist__column wishlist__column--product">
                                    <a href="/product/{{ $product->id }}/{{ $product->slug }}"
                                        class="wishlist__product-name">{{ $product->name }}</a>
                                </td>
                                <td class="wishlist__column wishlist__column--stock">
                                    @if ($selected_su->stock)
                                        <div class="badge badge-success">موجود در انبار</div>
                                    @else
                                        <div class="badge badge-danger">ناموجود</div>
                                    @endif
                                </td>
                                <td class="wishlist__column wishlist__column--price">
                                    @if ($selected_su->stock)
                                        @if ($selected_su->discounted_price)
                                            <div class="d-flex flex-column align-items-center">
                                                <span>{{ number_format($selected_su->discounted_price) }} تومان</span>
                                                <small class="text-danger">
                                                    ({{ $selected_su->discount_percent }}%)
                                                    {{ number_format($selected_su->discount_price) }}
                                                    تومان
                                                </small>
                                            </div>
                                        @else
                                            {{ number_format($selected_su->price) }} تومان
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="wishlist__column wishlist__column--remove">
                                    <a href="/favourite/product/{{ $product->id }}"
                                        class="btn btn-light btn-sm btn-svg-icon">
                                        <svg width="12px" height="12px">
                                            <use xlink:href="/public/main/images/sprite.svg#cross-12"></use>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
