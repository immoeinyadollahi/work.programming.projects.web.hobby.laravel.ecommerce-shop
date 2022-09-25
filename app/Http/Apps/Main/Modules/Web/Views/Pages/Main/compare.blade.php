@extends('layouts.master')
@section('page-title', 'مقایسه')
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
                        <li class="breadcrumb-item active" aria-current="page">مقایسه</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>مقایسه</h1>
            </div>
        </div>
    </div>
    <div class="cart block">
        <div class="container">
            <div class="d-flex align-items-center mb-4 position-relative compare-search-wrap js-compare-search-wrap">
                <input type="text" class="form-control" placeholder="جستجو نام کالا ...">
                <button class="btn btn-outline-primary d-flex align-items-center mr-3">
                    <span class="fas fa-search"></span>
                </button>
                <div class="search-result">

                </div>
            </div>
            <div class="table-responsive">
                <table class="compare-table">
                    <tbody>
                        <tr>
                            <th>محصول</th>
                            @foreach ($comparable_products as $product)
                                @php
                                    $selected_su = $product->selectedSu;
                                @endphp
                                <td>
                                    <a class="compare-table__product-link"
                                        href="{{ _route('product', ['product_id' => $product->id, 'product_slug' => $product->slug]) }}">
                                        <div class="compare-table__product-image"><img src="{{ $product->image->url }}"
                                                alt="{{ $product->name }}"></div>
                                        <div class="compare-table__product-name">{{ $product->name }}</div>
                                        <div>
                                            @if ($selected_su->stock)
                                                @if ($selected_su->discounted_price)
                                                    <span
                                                        class="product-card__new-price">{{ number_format($selected_su->discounted_price) }}
                                                        تومان</span>
                                                    <span
                                                        class="product-card__old-price mr-1">{{ number_format($selected_su->price) }}
                                                        تومان</span>
                                                @else
                                                    {{ number_format($selected_su->price) }} تومان
                                                @endif
                                            @else
                                                <span class="text-danger">ناموجود</span>
                                            @endif
                                        </div>
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                        @foreach ($comparable_properties as $property)
                            <tr>
                                <th>{{ $property->name }}</th>
                                @foreach ($comparable_products as $product)
                                    <td>
                                        {{ $product->properties->first(fn($property_value) => $property_value->property_id === $property->id)->value }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        @if (count($comparable_products) > 1)
                            <tr>
                                <th></th>
                                @foreach ($comparable_products as $product)
                                    <td>
                                        <button class="btn btn-secondary btn-sm js-remove-btn"
                                            data-product-id="{{ $product->id }}">حذف</button>
                                    </td>
                                @endforeach
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script>
        __DATA__.pageData.products = @json($comparable_products->pluck('id'));
    </script>
@endsection
