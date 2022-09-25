@extends('layouts.master')
@section('page-title', 'فراموشی رمز عبور')
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
                        <li class="breadcrumb-item active">فراموشی رمز عبور</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>فراموشی رمز عبور</h1>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">فراموشی رمز عبور</h4>
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
                                <button class="btn btn-success btn-block mt-5" type="submit">ارسال ایمیل فراموشی</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
