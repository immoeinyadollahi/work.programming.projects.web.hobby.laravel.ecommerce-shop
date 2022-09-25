@extends('layouts.users')
@section('page-title', 'آدرس ها')
@section('users-page-header-title', 'آدرس ها')
@section('users-page-breadcrumb')
    <li class="breadcrumb-item active">آدرس ها</li>
@endsection
@section('users-page-content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5>آدرس ها</h5>
            <a href="{{ _route('users.addresses.add') }}" class="btn btn-primary">افزودن</a>
        </div>
        <div class="card-divider"></div>
        <div class="card-body">
            @if ($_user->addresses->isEmpty())
                <div class="alert alert-info m-0">در حال حاظر آدرسی برای شما ثبت نشده است</div>
            @else
                @foreach ($_user->addresses as $address)
                    <div class="address-list-item card">
                        <div class="address-card__body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span>
                                    {{ $address->postal_address }}
                                </span>
                                <div class="dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="fas fa-ellipsis-v"></span>
                                    </div>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-warning"
                                            href="{{ _route('users.addresses.edit', ['address_id' => $address->id]) }}">ویرایش</a>
                                        <a class="dropdown-item text-danger"
                                            href="{{ _route('users.addresses.remove', ['address_id' => $address->id]) }}">حذف</a>

                                    </div>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">گیرنده</h5>
                                <div>
                                    <div>
                                        <div class="address-card__row-title">نام و نام خانوادگی</div>
                                        <div class="address-card__row-content">{{ $address->recipient_fullname }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="address-card__row-title">شماره تلفن</div>
                                        <div class="address-card__row-content"><span
                                                class="ltr_text">{{ $address->recipient_phone }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="address-card__row-title">آدرس ایمیل</div>
                                        <div class="address-card__row-content">{{ $address->recipient_email }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
