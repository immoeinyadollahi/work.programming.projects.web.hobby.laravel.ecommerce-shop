@extends('layouts.blank')
@section('page-title', 'ورود')
@section('page-content')
    <div class="d-flex flex-column flex-root">
        <!--begin::احراز هویت - ورود -->
        <div
            class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="/" class="mb-12">
                    <img alt="Logo" src="/public/admin/media/logos/logo-1.svg" class="h-40px">
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" method="POST">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">ورود به مترونیک</h1>
                            <!--end::Title-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Tags-->
                            <label class="form-label fs-6 fw-bolder text-dark">ایمیل</label>
                            <!--end::Tags-->
                            <!--begin::Input-->
                            <input
                                class="form-control form-control-lg form-control-solid{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                placeholder="آدرس ایمیل خود را وارد کنید" type="text" name="email" autocomplete="off"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Tags-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">کلمه عبور</label>
                                <!--end::Tags-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->
                            <input
                                class="form-control form-control-lg form-control-solid{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                placeholder="کلمه عبور خود را وارد کنید" type="password" name="password" autocomplete="off">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::ثبت button-->
                            <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">ورود</span>
                            </button>
                            <!--end::ثبت button-->
                            <!--begin::Separator-->
                            <div class="text-center text-muted text-uppercase fw-bolder mb-5">یا</div>
                            <!--end::Separator-->
                            <!--begin::گوگل link-->
                            <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                                <img alt="Logo" src="/public/admin/media/svg/brand-logos/google-icon.svg"
                                    class="h-20px me-3">ورود با گوگل</a>
                            <!--end::گوگل link-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::احراز هویت - ورود-->
    </div>
@endsection
