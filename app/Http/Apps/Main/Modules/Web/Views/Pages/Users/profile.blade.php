@extends('layouts.users')
@section('page-title', 'ویرایش پروفایل')
@section('users-page-header-title', 'ویرایش پروفایل')
@section('users-page-breadcrumb')
    <li class="breadcrumb-item active">ویرایش پروفایل</li>
@endsection
@section('users-page-content')
    <div class="card">
        <div class="card-header">
            <h5>ویرایش پروفایل</h5>
        </div>
        <div class="card-divider"></div>
        <div class="card-body">
            <h5 class="mb-3">اطلاعات کلی</h5>
            <div class="row no-gutters">
                <div class="col-12 col-lg-7 col-xl-6">
                    <form action="{{ _route('users.profile-basic') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>نام و نام خانوادگی</label>
                            <input type="text" value="{{ old('fullname', $_user->fullname) }}" name="fullname"
                                class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}"
                                placeholder="نام و نام خانوادگی">
                            @error('fullname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>آدرس ایمیل</label>
                            <input type="email" name="email"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                placeholder="آدرس ایمیل" value="{{ old('email', $_user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @unless($_user->hasVerifiedEmail())
                                <small class="form-text text-muted">
                                    <a href="/email/resend-verification-mail">تایید ایمیل</a>
                                </small>
                            @endunless
                        </div>
                        <div class="form-group mt-5 mb-0">
                            <button class="btn btn-primary">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-divider"></div>
        <div class="card-body">
            <h5 class="mb-3">شماره موبایل</h5>
            @if ($_user->phone)
                <div class="row">
                    <div class="col-md-7">
                        <input type="text" value="{{ $_user->phone }}" class="form-control" disabled>
                        <a href="{{ _route('profile-phone') }}" class="btn btn-primary mt-3">ویرایش</a>
                    </div>
                </div>
            @else
                <a href="{{ _route('profile-phone') }}" class="btn btn-primary">افزودن</a>
            @endif
        </div>
        <div class="card-divider"></div>
        <div class="card-body">
            <h5 class="mb-3">تصویر پروفایل</h5>
            <form action="{{ _route('users.profile-image') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex align-items-center">
                    <label class="ml-5 mb-0 btn btn-outline-success">
                        <input type="file" name="profile_image" class="d-none" accept=".jpg,.jpeg,.png">
                        انتخاب تصویر
                    </label>
                    <img src="{{ $_user->profileImage->url }}" alt="{{ $_user->fullname }}"
                        style="width: 80px;height: 80px;border-radius: 50%;">
                </div>
            </form>
        </div>
    </div>
@endsection
