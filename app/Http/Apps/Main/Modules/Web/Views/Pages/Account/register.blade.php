@extends('layouts.master')
@section('page-title', 'ثبت نام')
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
                        <li class="breadcrumb-item active">ثبت نام</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>ثبت نام</h1>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card flex-grow-1 mb-0">
                        <div class="card-body">
                            <h3 class="card-title">ثبت نام</h3>
                            <form method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>نام و نام خانوادگی</label>
                                    <input type="text" name="fullname"
                                        class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}"
                                        placeholder="نام و نام خانوادگی را وارد کنید" value="{{ old('fullname') }}">
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
                                        placeholder="ایمیل را وارد کنید" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>رمز عبور</label>
                                    <input type="password" name="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        placeholder="رمز عبور را وارد کنید">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>تکرار رمز عبور</label>
                                    <input type="password" name="confirm_password"
                                        class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}"
                                        placeholder="رمز عبور را تکرار کنید">
                                    @error('confirm_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">ثبت نام</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
