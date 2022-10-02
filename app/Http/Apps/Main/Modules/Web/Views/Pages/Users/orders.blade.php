@extends('layouts.users')
@section('page-title', 'سفارش ها')
@section('users-page-header-title', 'سفارش ها')
@section('users-page-breadcrumb')
    <li class="breadcrumb-item active">سفارش ها</li>
@endsection
@section('users-page-content')
    <div class="card">
        <div class="card-header">
            <h5>سفارش ها</h5>
        </div>
        <div class="card-divider"></div>
        @if ($paginator->isEmpty())
            <div class="card-body">
                <div class="alert alert-info m-0">در حال حاظر سفارشی برای شما ثبت نشده است</div>
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
                            @foreach ($paginator->items() as $order)
                                <tr>
                                    <td>
                                        <a href="{{ _route('users.orders.order', ['order_id' => $order->id]) }}">
                                            #{{ $order->id }}
                                        </a>
                                    </td>
                                    <td>{{ $_Date::formatDate($order->created_at) }}</td>
                                    <td>{{ $order->status_fa }}</td>
                                    <td>{{ number_format($order->payment_cost) }} تومان برای
                                        {{ count($order->items) }}
                                        محصول</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($paginator->hasPages())
                <div class="card-divider"></div>
                <div class="card-footer">
                    {{ $paginator->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
