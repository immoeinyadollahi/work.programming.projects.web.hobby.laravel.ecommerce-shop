@extends('layouts.master')
@section('page-title', 'ویرایش محصول')
@section('page-vendor-styles')
    <link href="/public/admin/plugins/custom/persian-datepicker/persian-datepicker.css" rel="stylesheet" type="text/css">
@endsection
@section('page-toolbar-title', 'ویرایش محصول')
@section('page-toolbar-breadcrumb')
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">
        <a href="/" class="text-muted text-hover-primary">خانه</a>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">فروشگاه</li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">محصولات</li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">ویرایش محصول</li>
    <!--end::Item-->
@endsection
@section('page-content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        <div class="d-flex flex-column flex-lg-row" data-component="product-form"></div>
    </div>
    <!--end::Container-->
@endsection
@section('page-vendor-scripts')
    <script src="/public/admin/plugins/custom/persian-date/persian-date.min.js"></script>
    <script src="/public/admin/plugins/custom/persian-datepicker/persian-datepicker.js"></script>
@endsection
@section('page-custom-scripts')
    <script>
        __DATA__.dependencies.push("pages.shop.edit-product");
        Object.assign(__DATA__.pageData.redux.data, {
            product: @json($product),
        });
        Object.assign(__DATA__.pageData, {
            categories: @json($categories),
        });
    </script>
    <script src="/public/admin/js/widgets.bundle.js"></script>
    <script src="/public/admin/js/custom/widgets.js"></script>
@endsection
