@extends('layouts.users')
@section('page-title', 'افزودن آدرس')
@section('users-page-header-title', 'افزودن آدرس')
@section('users-page-breadcrumb')
    <li class="breadcrumb-item active">افزودن آدرس</li>
@endsection
@section('users-page-content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5>افزودن آدرس</h5>
        </div>
        <div class="card-divider"></div>
        <div class="card-body">
            <form method="POST" class="js-address-form">
                @csrf
                <div class="form-group">
                    <label class="required">نشانی پستی</label>
                    <textarea style="resize: none;" type="text" name="postal_address" rows="3"
                        class="form-control{{ $errors->has('postal_address') ? ' is-invalid' : '' }}">{{ old('postal_address') }}</textarea>
                    @error('postal_address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required">استان</label>
                            <select name="province"
                                class="form-control{{ $errors->has('province') ? ' is-invalid' : '' }}">
                                <option hidden selected value="">انتخاب کنید</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('province')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required">شهر</label>
                            <select name="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}">
                                <option hidden selected value="">ابتدا استان را انتخاب کنید</option>
                            </select>
                            @error('city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="required">کد پستی</label>
                    <input type="text" name="postal_code"
                        class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}"
                        value="{{ old('postal_code') }}">
                    @error('postal_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div>
                    <h5>گیرنده</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required">نام و نام خانوادگی</label>
                                <input type="text" name="recipient_fullname"
                                    class="form-control{{ $errors->has('recipient_fullname') ? ' is-invalid' : '' }}"
                                    value="{{ old('recipient_fullname') }}">
                                @error('recipient_fullname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required">ایمیل</label>
                                <input type="email" name="recipient_email"
                                    class="form-control{{ $errors->has('recipient_email') ? ' is-invalid' : '' }}"
                                    value="{{ old('recipient_email') }}">
                                @error('recipient_email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required">شماره تلفن</label>
                        <input type="text" name="recipient_phone"
                            class="form-control{{ $errors->has('recipient_phone') ? ' is-invalid' : '' }}"
                            value="{{ old('recipient_phone') }}">
                        @error('recipient_phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary">ثبت</button>
            </form>
        </div>
    </div>
@endsection
