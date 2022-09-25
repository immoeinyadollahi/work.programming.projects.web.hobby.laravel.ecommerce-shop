@extends('layouts.blank')
@section('page-title', 'صفحه مورد نظر پیدا نشد')
@section('page-content')
    <div class="d-flex flex-column flex-root">
        <!--begin::احراز هویت - 404 Page-->
        <div class="d-flex flex-column flex-center flex-column-fluid p-10">
            <!--begin::Illustration-->
            <img src="/public/admin/media/illustrations/sketchy-1/18.png" alt="" class="mw-100 mb-10 h-lg-450px">
            <!--end::Illustration-->
            <!--begin::Message-->
            <h1 class="fw-bold mb-10" style="color: #A3A3C7">انگار اینجا چیزی نیست</h1>
            <!--end::Message-->
            <!--begin::Link-->
            <a href="/" class="btn btn-primary">برو به صفحه اصلی</a>
            <!--end::Link-->
        </div>
        <!--end::احراز هویت - 404 Page-->
    </div>
@endsection
