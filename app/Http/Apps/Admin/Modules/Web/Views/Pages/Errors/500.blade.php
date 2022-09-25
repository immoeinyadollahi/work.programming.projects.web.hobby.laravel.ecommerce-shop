@extends('layouts.blank')
@section('page-title', 'خطای سرور')
@section('page-content')
    <div class="d-flex flex-column flex-root">
        <!--begin::احراز هویت - خطایی 500 -->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
                <!--begin::Logo-->
                <a href="/" class="mb-10 pt-lg-10">
                    <img alt="Logo" src="/public/admin/media/logos/logo-1.svg" class="h-40px mb-5">
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="pt-lg-10 mb-10">
                    <!--begin::Logo-->
                    <h1 class="fw-bolder fs-2qx text-gray-800 mb-10">خطای سیستم</h1>
                    <!--end::Logo-->
                    <!--begin::Message-->
                    <div class="fw-bold fs-3 text-muted mb-15">مشکلی پیش آمد!
                        <br>لطفا بعداً دوباره امتحان کنید.
                    </div>
                    <!--end::Message-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <a href="/" class="btn btn-lg btn-primary fw-bolder">برو به صفحه اصلی</a>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Illustration-->
                <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                    style="background-image: url(/public/admin/media/illustrations/sketchy-1/17.png"></div>
                <!--end::Illustration-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::احراز هویت - خطایی 500-->
    </div>
@endsection
