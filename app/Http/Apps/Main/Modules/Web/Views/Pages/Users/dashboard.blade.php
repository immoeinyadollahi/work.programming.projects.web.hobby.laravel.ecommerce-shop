@extends('layouts.users')
@section('page-title', 'داشبورد')
@section('users-page-header-title', 'داشبورد')
@section('users-page-breadcrumb')
    <li class="breadcrumb-item active">داشبورد</li>
@endsection
@section('users-page-content')
    <div class="dashboard">
        <div class="dashboard__profile card profile-card w-100">
            <div class="card-body profile-card__body">
                <div class="profile-card__avatar">
                    <img src="{{ $_user->profileImage->url }}" alt="{{ $_user->fullname }}">
                </div>
                <div class="profile-card__name">{{ $_user->fullname }}</div>
                <div class="profile-card__email">{{ $_user->email }}</div>
                <div class="profile-card__edit">
                    <a href="/users/edit-profile" class="btn btn-secondary btn-sm">
                        ویرایش پروفایل
                    </a>
                </div>
            </div>
        </div>
        <div class="dashboard__orders card">
            <div class="card-header">
                <h5>سفارشات اخیر</h5>
            </div>
            <div class="card-divider"></div>
            @if ($_user->orders->isEmpty())
                <div class="card-body">
                    <div class="alert alert-info">در حال حاظر سفارشی برای شما ثبت نشده است</div>
                </div>
            @else
                <div class="card-table">
                    <div class="table-responsive-sm">
                        <table>
                            <thead>
                                <tr>
                                    <th>سفارش</th>
                                    <th>تاریخ</th>
                                    <th>وضعیت</th>
                                    <th>جمع کل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($_user->orders as $order)
                                    <tr>
                                        <td><a
                                                href="{{ _route('users.orders.order', ['order_id' => $order->id]) }}">#{{ $order->id }}</a>
                                        </td>
                                        <td>{{ $_Date::formatDate($order->created_at) }}</td>
                                        <td>{{ $order->status_fa }}</td>
                                        <td>{{ number_format($order->info->payment_cost) }} تومان برای
                                            {{ count($order->items) }}
                                            محصول</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
