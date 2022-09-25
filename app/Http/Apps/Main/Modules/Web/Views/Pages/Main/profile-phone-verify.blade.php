@extends('layouts.master')
@section('page-title', 'تایید شماره موبایل')
@section('page-content')
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">خانه</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">تایید شماره موبایل</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>تایید شماره موبایل</h1>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST">
                                @csrf
                                <small class="text-muted mb-4">کد تایید برای شماره موبایل {{ $phone }} ارسال
                                    گردید</small>
                                <div class="form-group">
                                    <label>کد تایید</label>
                                    <input type="text" name="code"
                                        class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}"
                                        placeholder="کد تایید را وارد کنید" value="{{ old('code') }}">
                                    @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-primary btn-block js-otp-resend-btn mb-2 mt-5"
                                    disabled>
                                    ارسال مجدد کد تا
                                    <span class="d-inline-block mx-1"
                                        data-resend-countdown="{{ $otp_resend_timeout }}"></span>
                                    دیگر
                                </button>
                                <button class="btn btn-success btn-block">ثبت</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
