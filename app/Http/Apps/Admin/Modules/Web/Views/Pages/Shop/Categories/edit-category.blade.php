@extends('layouts.master')
@section('page-title', 'افزودن دسته بندی')
@section('page-vendor-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('page-toolbar-title', 'افزودن دسته بندی')
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
    <li class="breadcrumb-item text-dark">افزودن دسته بندی</li>
    <!--end::Item-->
@endsection
@section('page-content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        <form method="POST" action="/category/{{ $category->id }}/edit" class="form d-flex flex-column flex-lg-row">
            @csrf
            <!--begin::کناری column-->
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                <div data-component="image"></div>
                <!--begin::Parent Category-->
                <div class="card card-flush card-widget">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>دسته بندی مادر</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <select class="form-select" name="parent">
                            <option value="">ندارد</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->fa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Parent Category-->
            </div>
            <!--end::کناری column-->
            <!--begin::Main column-->
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::عمومی options-->
                <div class="card card-flush card-widget">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>عمومی</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Tags-->
                                    <label class="required form-label">نام فارسی </label>
                                    <!--end::Tags-->
                                    <!--begin::Input-->
                                    <input type="text" name="fa"
                                        class="form-control mb-2{{ $errors->has('fa') ? ' is-invalid' : '' }}"
                                        placeholder="نام محصول" value="{{ old('fa') }}">
                                    <!--end::Input-->
                                    @error('fa')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <!--begin::توضیحات-->
                                    <div class="text-muted fs-7">نام فارسی دسته مورد نیاز است و توصیه می شود منحصر به فرد
                                        باشد.
                                    </div>
                                    <!--end::توضیحات-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-sm-6">
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Tags-->
                                    <label class="required form-label">نام انگلیسی </label>
                                    <!--end::Tags-->
                                    <!--begin::Input-->
                                    <input type="text" name="en"
                                        class="form-control mb-2{{ $errors->has('fa') ? ' is-invalid' : '' }}"
                                        placeholder="نام محصول" value="{{ old('en') }}">
                                    <!--end::Input-->
                                    @error('en')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <!--begin::توضیحات-->
                                    <div class="text-muted fs-7">نام انگلیسی دسته مورد نیاز است و توصیه می شود منحصر به فرد
                                        باشد.
                                    </div>
                                    <!--end::توضیحات-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>

                        <!--begin::Input group-->
                        <div>
                            <!--begin::Tags-->
                            <label class="form-label">توضیحات</label>
                            <!--end::Tags-->
                            <!--begin::or-->
                            <div id="ckeditor" name="description">
                            </div>
                            <!--end::or-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card header-->
                </div>
                <!--end::عمومی options-->
                <!--begin::Automation-->
                <div class="card card-flush card-widget">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>اتوماسیون</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Input group-->
                        <div>
                            <!--begin::Tags-->
                            <label class="form-label mb-5">روش واگذاری محصولات</label>
                            <!--end::Tags-->
                            <!--begin::Methods-->
                            <!--begin::Input row-->
                            <div class="d-flex fv-row">
                                <!--begin::رادیو-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3" name="method" type="radio" value="0"
                                        id="kt_ecommerce_add_category_automation_0" checked='checked'>
                                    <!--end::Input-->
                                    <!--begin::Tags-->
                                    <label class="form-check-label" for="kt_ecommerce_add_category_automation_0">
                                        <div class="fw-bolder text-gray-800">دستی</div>
                                        <div class="text-gray-600">با انتخاب دستی این دسته در حین ایجاد یا به روز رسانی
                                            محصول، یک به یک محصول را به این دسته اضافه کنید.</div>
                                    </label>
                                    <!--end::Tags-->
                                </div>
                                <!--end::رادیو-->
                            </div>
                            <!--end::Input row-->
                            <div class='separator separator-dashed my-5'></div>
                            <!--begin::Input row-->
                            <div class="d-flex fv-row">
                                <!--begin::رادیو-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3" name="method" type="radio" value="1"
                                        id="kt_ecommerce_add_category_automation_1">
                                    <!--end::Input-->
                                    <!--begin::Tags-->
                                    <label class="form-check-label" for="kt_ecommerce_add_category_automation_1">
                                        <div class="fw-bolder text-gray-800">اتوماتیک</div>
                                        <div class="text-gray-600">محصولات مطابق با شرایط زیر به طور خودکار به این دسته
                                            اختصاص داده می شود.</div>
                                    </label>
                                    <!--end::Tags-->
                                </div>
                                <!--end::رادیو-->
                            </div>
                            <!--end::Input row-->
                            <!--end::Methods-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-none mt-10" data-kt-ecommerce-catalog-add-category="auto-options">
                            <!--begin::Tags-->
                            <label class="form-label">شروط</label>
                            <!--end::Tags-->
                            <!--begin::Conditions-->
                            <div class="d-flex flex-wrap align-items-center text-gray-600 gap-5 mb-7">
                                <span>محصولات باید مطابقت داشته باشند::</span>
                                <!--begin::رادیو-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="conditions" value=""
                                        id="all_conditions" checked="checked">
                                    <label class="form-check-label" for="all_conditions">همه شروط</label>
                                </div>
                                <!--end::رادیو-->
                                <!--begin::رادیو-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="conditions" value=""
                                        id="any_conditions">
                                    <label class="form-check-label" for="any_conditions">بدون شرط</label>
                                </div>
                                <!--end::رادیو-->
                            </div>
                            <!--end::Conditions-->
                            <!--begin::Repeater-->
                            <div id="kt_ecommerce_add_category_conditions">
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div data-repeater-list="kt_ecommerce_add_category_conditions"
                                        class="d-flex flex-column gap-3">
                                        <div data-repeater-item="" class="form-group d-flex flex-wrap gap-5">
                                            <!--begin::انتخاب2-->
                                            <div class="w-100 w-md-200px">
                                                <select class="form-select" name="condition_type"
                                                    data-placeholder="انتخاب "
                                                    data-kt-ecommerce-catalog-add-category="condition_type">
                                                    <option></option>
                                                    <option value="title">عنوان محصول</option>
                                                    <option value="tag" selected="selected">برچسب محصولات</option>
                                                    <option value="price">قیمت محصول</option>
                                                </select>
                                            </div>
                                            <!--end::انتخاب2-->
                                            <!--begin::انتخاب2-->
                                            <div class="w-100 w-md-200px">
                                                <select class="form-select" name="condition_equals"
                                                    data-placeholder="انتخاب "
                                                    data-kt-ecommerce-catalog-add-category="condition_equals">
                                                    <option></option>
                                                    <option value="equal" selected="selected">برابر با</option>
                                                    <option value="notequal">برابر نباشد با</option>
                                                    <option value="greater">بزرگتر از</option>
                                                    <option value="less">کوچکتر از</option>
                                                    <option value="starts">شروع با</option>
                                                    <option value="ends">تمام بشه با</option>
                                                </select>
                                            </div>
                                            <!--end::انتخاب2-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control mw-100 w-200px"
                                                name="condition_label" placeholder="">
                                            <!--end::Input-->
                                            <!--begin::Button-->
                                            <button type="button" data-repeater-delete=""
                                                class="btn btn-sm btn-icon btn-light-danger">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewbox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="7.05025" y="15.5356"
                                                            width="12" height="2" rx="1"
                                                            transform="rotate(-45 7.05025 15.5356)" fill="currentColor">
                                                        </rect>
                                                        <rect x="8.46447" y="7.05029" width="12"
                                                            height="2" rx="1"
                                                            transform="rotate(45 8.46447 7.05029)" fill="currentColor">
                                                        </rect>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group mt-5">
                                    <!--begin::Button-->
                                    <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewbox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="11" y="18" width="12"
                                                    height="2" rx="1" transform="rotate(-90 11 18)"
                                                    fill="currentColor"></rect>
                                                <rect x="6" y="11" width="12" height="2"
                                                    rx="1" fill="currentColor"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->افزودن شروط
                                    </button>
                                    <!--end::Button-->
                                </div>
                                <!--end::Form group-->
                            </div>
                            <!--end::Repeater-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card header-->
                </div>
                <!--end::Automation-->
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <a href="/shop/categories" class="btn btn-light me-5">انصراف</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button class="btn btn-primary">
                        ذخیره تغییرات
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <!--end::Main column-->
        </form>
    </div>
    <!--end::Container-->
@endsection
@section('page-vendor-scripts')
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('page-custom-scripts')
    <script>
        __DATA__.dependencies.push("pages.shop.edit-category");
    </script>
    <script src="/public/admin/js/custom/apps/ecommerce/catalog/custom/edit-category.js"></script>
    <script src="/public/admin/js/widgets.bundle.js"></script>
    <script src="/public/admin/js/custom/widgets.js"></script>
@endsection
