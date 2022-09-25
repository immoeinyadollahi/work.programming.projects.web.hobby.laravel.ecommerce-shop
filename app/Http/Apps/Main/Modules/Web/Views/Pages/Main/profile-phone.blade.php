@extends('layouts.master')
@section('page-title', 'ثبت شماره موبایل')
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
                        <li class="breadcrumb-item active" aria-current="page">ثبت شماره موبایل</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>ثبت شماره موبایل</h1>
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
                                <div class="form-group">
                                    <label>شماره موبایل</label>
                                    <input type="text" name="phone"
                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                        placeholder="شماره موبایل را وارد کنید" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-success btn-block mt-5" type="submit">ارسال کد تایید</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
