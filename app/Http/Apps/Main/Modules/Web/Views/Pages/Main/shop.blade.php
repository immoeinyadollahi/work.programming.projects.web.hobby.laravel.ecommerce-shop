@extends('layouts.master')
@section('page-title', $category->fa)
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
                        @if ($category->parents)
                            @foreach ($category->parents as $parent_category)
                                <li class="breadcrumb-item">
                                    <a href="/shop/{{ $parent_category->slug }}">{{ $parent_category->fa }}</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                            @endforeach
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->fa }}</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>{{ $category->fa }}</h1>
            </div>
        </div>
    </div>
    <div class="container" data-component="page-content"></div>
@endsection
@section('page-scripts')
    <script>
        __DATA__.dependencies.push("pages.shop");
        Object.assign(__DATA__.pageData, {
            productsPaginator: @json($paginator),
            category: @json($category)
        });
    </script>
@endsection
