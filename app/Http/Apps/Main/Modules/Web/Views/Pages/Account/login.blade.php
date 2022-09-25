@extends('layouts.master')
@section('page-title', 'ورود')
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
                        <li class="breadcrumb-item active">ورود</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>ورود</h1>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card flex-grow-1 mb-md-0">
                        <div class="card-body">
                            <h3 class="card-title">ورود</h3>
                            <form method="POST">
                                @csrf
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
                                    <small class="form-text text-muted">
                                        <a href="/forget-password">فراموشی رمز عبور</a>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <span class="form-check-input input-check"><span class="input-check__body">
                                                <input class="input-check__input" type="checkbox" name="remember"
                                                    id="login-remember">
                                                <span class="input-check__box"></span>
                                                <svg class="input-check__icon" width="9px" height="7px">
                                                    <use xlink:href="/public/main/images/sprite.svg#check-9x7"></use>
                                                </svg>
                                            </span>
                                        </span>
                                        <label class="form-check-label" for="login-remember">به خاطر سپاری</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">ورود</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
