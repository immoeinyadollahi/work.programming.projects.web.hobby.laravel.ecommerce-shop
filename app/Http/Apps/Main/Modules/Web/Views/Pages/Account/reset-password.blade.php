@extends('layouts.master')
@section('page-title', 'بازیابی رمز عبور')
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
                        <li class="breadcrumb-item active">بازیابی رمز عبور</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>بازیابی رمز عبور</h1>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">بازیابی رمز عبور</h4>
                            <form method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $_req->query('token') }}">
                                <div class="form-group">
                                    <label>رمز عبور جدید</label>
                                    <input type="password" name="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        placeholder="رمز عبور جدید را وارد کنید">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>تکرار رمز عبور جدید</label>
                                    <input type="password" name="confirm_password"
                                        class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}"
                                        placeholder="رمز عبور جدید را تکرار کنید">
                                    @error('confirm_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-success btn-block mt-5" type="submit">تغییر رمز عبور</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
