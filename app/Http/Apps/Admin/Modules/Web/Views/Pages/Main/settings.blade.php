@extends('layouts.master')
@section('page-title', 'تنظیمات')
@section('page-vendor-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection
@section('page-toolbar-title', 'تنظیمات')
@section('page-content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        <form class="form d-flex flex-column flex-row-fluid gap-7 gap-lg-10" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-md-0 mb-5">
                    <div class="card card-flush card-widget mb-5">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>عمومی</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">نام فروشگاه</label>
                                <input type="text" name="website_name" class="form-control" placeholder="نام فروشگاه"
                                    value="{{ old('website_name', $settings->website_name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">آدرس فروشگاه</label>
                                <input type="text" name="address" class="form-control" placeholder="آدرس فروشگاه"
                                    value="{{ old('address', $settings->address) }}">
                            </div>
                            <div>
                                <label class="form-label">تلفن تماس</label>
                                <input type="text" name="phone" class="form-control" placeholder="تلفن تماس"
                                    value="{{ old('phone', $settings->phone) }}">
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <div class="card card-flush card-widget">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>لوگو سایت</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <div data-component="logo"></div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-flush card-widget mb-5">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>رسانه های اجتماعی</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">فیسبوک</label>
                                <input type="text" name="social_media[facebook]" class="form-control" placeholder="آدرس"
                                    value="{{ old('social_media.facebook', $settings->social_media['facebook']) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">توییتر</label>
                                <input type="text" name="social_media[twitter]" class="form-control" placeholder="آدرس"
                                    value="{{ old('social_media.twitter', $settings->social_media['twitter']) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">تلگرام</label>
                                <input type="text" name="social_media[telegram]" class="form-control" placeholder="آدرس"
                                    value="{{ old('social_media.telegram', $settings->social_media['telegram']) }}">
                            </div>
                            <div>
                                <label class="form-label">واتساپ</label>
                                <input type="text" name="social_media[whatsapp]" class="form-control" placeholder="آدرس"
                                    value="{{ old('social_media.whatsapp', $settings->social_media['whatsapp']) }}">
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <div data-component="slideshow"></div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="/shop/property-groups" class="btn btn-light me-5">انصراف</a>
                <!--end::Button-->
                <!--begin::Button-->
                <button class="btn btn-primary">
                    ثبت
                </button>
                <!--end::Button-->
            </div>
        </form>
    </div>
    <!--end::Container-->
@endsection
@section('page-vendor-scripts')
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
@endsection
@section('page-custom-scripts')
    <script>
        __DATA__.dependencies.push("pages.settings");
        Object.assign(__DATA__.pageData, {
            settings: @json($settings)
        });
    </script>
    <script src="/public/admin/js/widgets.bundle.js"></script>
    <script src="/public/admin/js/custom/widgets.js"></script>
@endsection
