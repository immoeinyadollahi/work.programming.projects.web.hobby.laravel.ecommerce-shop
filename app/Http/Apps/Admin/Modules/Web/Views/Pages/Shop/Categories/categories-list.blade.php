@extends('layouts.master')
@section('page-title', 'لیست دسته بندی ها')
@section('page-toolbar-title', 'لیست دسته بندی ها')
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
    <li class="breadcrumb-item text-muted">دسته بندی ها</li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">لیست دسته بندی ها</li>
    <!--end::Item-->
@endsection
@section('page-content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::دسته بندی-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::جستجو-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-ecommerce-category-filter="search"
                            class="form-control form-control-solid w-250px ps-14" placeholder="جستجو دسته بندی">
                    </div>
                    <!--end::جستجو-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Add customer-->
                    <a href="add-category.html" class="btn btn-primary">افزودن دسته بندی</a>
                    <!--end::Add customer-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                @if ($paginator->isEmpty())
                    <div class="alert alert-primary m-0">در حال حاظر دسته بندی ثبت نشده است</div>
                @else
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_ecommerce_category_table .form-check-input"
                                                value="1">
                                        </div>
                                    </th>
                                    <th class="min-w-70px">تصویر</th>
                                    <th class="min-w-150px">نام</th>
                                    <th class="min-w-150px">دسته بندی مادر</th>
                                    <th class="min-w-150px">سطح</th>
                                    <th class="min-w-150px">تعداد محصولات</th>
                                    <th class="min-w-70px">عملیات</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                                @foreach ($paginator->items() as $category)
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1">
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->
                                        <!--begin::تصویر=-->
                                        <td>
                                            <a href="/shop/category/{{ $category->id }}/edit" class="symbol symbol-50px">
                                                <span class="symbol-label"
                                                    style="background-image:url({{ $category->image->url }});"></span>
                                            </a>
                                        </td>
                                        <!--end::تصویر=-->
                                        <!--begin::نام=-->
                                        <td>
                                            <a href="/shop/category/{{ $category->id }}/edit"
                                                class="text-gray-800 text-hover-primary fs-5 fw-bolder mb-1">{{ $category->fa }}</a>
                                        </td>
                                        <!--end::نام=-->
                                        <!--begin::دسته بندی مادر=-->
                                        <td>
                                            @if ($category->parent)
                                                {{ $category->parent->fa }}
                                            @else
                                                <div class="badge badge-light-danger">
                                                    ندارد
                                                </div>
                                            @endif
                                        </td>
                                        <!--end::دسته بندی مادر=-->
                                        <!--begin::سطح=-->
                                        <td>
                                            {{ $category->level }}
                                        </td>
                                        <!--end::سطح=-->
                                        <!--begin::تعداد محصولات=-->
                                        <td>
                                            {{ $category->products_count }}
                                        </td>
                                        <!--end::تعداد محصولات=-->
                                        <!--begin::عملیات=-->
                                        <td>
                                            <a href="#"
                                                class="btn btn-sm btn-light btn-active-light-primary whitespace-nowrap"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">عملیات
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewbox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="/shop/category/{{ $category->id }}/edit"
                                                        class="menu-link px-3">ویرایش</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="/shop/category/{{ $category->id }}/delete"
                                                        class="menu-link px-3">حذف</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                        <!--end::عملیات=-->
                                    </tr>
                                    <!--end::Table row-->
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    @if ($paginator->hasPages())
                        {{ $paginator->onEachSide(1)->links() }}
                    @endif
                @endif
            </div>
            <!--end::Card body-->
        </div>
        <!--end::دسته بندی-->
    </div>
    <!--end::Container-->
@endsection
@section('page-custom-scripts')
    <script src="/public/admin/js/widgets.bundle.js"></script>
    <script src="/public/admin/js/custom/widgets.js"></script>
@endsection
