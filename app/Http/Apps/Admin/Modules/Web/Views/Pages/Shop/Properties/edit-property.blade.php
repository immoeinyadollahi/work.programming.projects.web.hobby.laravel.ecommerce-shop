@extends('layouts.master')
@section('page-title', 'ویرایش ویژگی')
@section('page-toolbar-title', 'ویرایش ویژگی')
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
    <li class="breadcrumb-item text-muted">ویژگی ها</li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">ویرایش ویژگی</li>
    <!--end::Item-->
@endsection
@section('page-content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        <form class="form d-flex flex-column flex-row-fluid gap-7 gap-lg-10" method="POST">
            @csrf
            <div class="card card-flush">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Input group-->
                    <div class="fv-row fv-plugins-icon-container">
                        <!--begin::Tags-->
                        <label class="required form-label">ویژگی نام</label>
                        <!--end::Tags-->
                        <!--begin::Input-->
                        <input type="text" name="name"
                            class="form-control mb-2{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            placeholder="نام ویژگی" value="{{ old('name', $property->name) }}">
                        <!--end::Input-->
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <!--begin::توضیحات-->
                        <div class="text-muted fs-7">
                            نام ویژگی مورد نیاز است و توصیه می شود بین دیگر مقادیر گروه منحصر به فرد باشد.
                        </div>
                        <!--end::توضیحات-->
                    </div>
                    <!--end::Input group-->
                    <div data-component="property-values"></div>
                </div>
                <!--end::Card header-->
            </div>
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="/shop/property-group/{{ $property->group_id }}/properties" class="btn btn-light me-5">انصراف</a>
                <!--end::Button-->
                <!--begin::Button-->
                <button class="btn btn-primary">
                    ذخیره تغییرات
                </button>
                <!--end::Button-->
            </div>
        </form>
    </div>
    <!--end::Container-->
@endsection
@section('page-custom-scripts')
    <script>
        __DATA__.dependencies.push("partials.shop.property");
        Object.assign(__DATA__.pageData, {
            propertyValues: @json($property->values),
        });
    </script>
    <script src="/public/admin/js/widgets.bundle.js"></script>
    <script src="/public/admin/js/custom/widgets.js"></script>
@endsection
