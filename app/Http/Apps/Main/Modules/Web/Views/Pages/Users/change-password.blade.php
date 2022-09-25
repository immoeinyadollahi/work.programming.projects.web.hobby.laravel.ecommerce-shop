@extends('layouts.users')
@section('page-title', 'تغییر رمز عبور')
@section('users-page-header-title', 'تغییر رمز عبور')
@section('users-page-breadcrumb')
    <li class="breadcrumb-item active">تغییر رمز عبور</li>
@endsection
@section('users-page-content')
    <div class="card">
        <div class="card-header">
            <h5>تغییر رمز عبور</h5>
        </div>
        <div class="card-divider"></div>
        <div class="card-body">
            <div class="row no-gutters">
                <div class="col-12 col-lg-7 col-xl-6">
                    <form method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="password-current">رمز عبور کنونی</label>
                            <input type="password" name="current_password"
                                class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                                id="password-current" placeholder="رمز عبور کنونی">
                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-new">رمز عبور جدید</label>
                            <input type="password" name="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password-new"
                                placeholder="رمز عبور جدید">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">تکرار رمز عبور جدید</label>
                            <input type="password" name="confirm_password"
                                class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}"
                                id="password-confirm" placeholder="تکرار رمز عبور جدید">
                            @error('confirm_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-5 mb-0">
                            <button class="btn btn-primary">تغییر</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
