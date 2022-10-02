@extends('layouts.users')
@section('page-title', 'جزئیات سفارش')
@section('users-page-header-title', 'جزئیات سفارش')
@section('users-page-breadcrumb')
    <li class="breadcrumb-item active">جزئیات سفارش</li>
@endsection
@section('users-page-content')
    <div class="card">
        <div class="card-header">
            <h5>جزئیات سفارش</h5>
        </div>
        <div class="card-divider"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <h5>آدرس</h5>
                        <div class="d-flex mb-2">
                            <small>تحویل گیرنده : </small>
                            <small class="mr-2">{{ $order->address->recipient_fullname }}</small>
                        </div>
                        <div class="d-flex mb-2">
                            <small>شماره تماس : </small>
                            <small class="mr-2">{{ $order->address->recipient_phone }}</small>
                        </div>
                        <div class="d-flex mb-4">
                            <small>ارسال به : </small>
                            <small class="mr-2">{{ $order->address->postal_address }}</small>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex mb-2">
                            <small>مبلغ کل : </small>
                            <small class="mr-2">{{ number_format($order->payment_cost) }} تومان</small>
                        </div>
                        @if ($order->extra->total_discount_price)
                            <div class="d-flex mb-2 text-danger">
                                <small>سود شما از خرید : </small>
                                <small class="mr-2">{{ number_format($order->extra->total_discount_price) }}
                                    تومان</small>
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <h5 class="m-0">وضعیت</h5>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-success">{{ $order->status_fa }}</div>
                            @if ($order->status === 'pending')
                                <a href="{{ _route('users.orders.pay-order', ['order_id' => $order->id]) }}"
                                    class="btn btn-primary">پرداخت</a>
                            @endif
                        </div>
                    </div>
                    <div>
                        <a class="collapsed order-transactions-collapse-btn" data-toggle="collapse"
                            href="#order-transactions">
                            تراکنش ها
                            <span class="fas fa-angle-down mr-2"></span>
                        </a>
                        <div class="collapse mt-2" id="order-transactions">
                            <div class="card">
                                @foreach ($order->transactions as $transaction)
                                    <div class="order-transaction">
                                        <div>
                                            <span>وضعیت</span>
                                            <div class="d-flex align-items-center">
                                                {{ $transaction->is_done ? 'موفق' : 'ناموفق' }}
                                                <span
                                                    class="fas {{ $transaction->is_done ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} mr-2"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <span>درگاه</span>
                                            <span>زرین پال</span>
                                        </div>
                                        <div>
                                            <span>شماره پیگیری</span>
                                            <span>{{ $transaction->is_done ? $transaction->ref_id : '-' }}</span>
                                        </div>
                                        <div>
                                            <span>زمان انجام</span>
                                            <span>{{ $_Date::formatDate($transaction->created_at) }}</span>
                                        </div>
                                        <div>
                                            <span>مقدار</span>
                                            <span>{{ number_format($transaction->amount) }} تومان</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-md-0 mt-3">
                    <h5>کالاها</h5>
                    <div class="d-flex mb-2">
                        <small>جمع قیمت کالاها : </small>
                        <small class="mr-2">{{ number_format($order->extra->items_final_price) }} تومان</small>
                    </div>
                    <div class="d-flex mb-4">
                        <small>هزینه ارسال : </small>
                        <small class="mr-2">رایگان</small>
                    </div>
                    <ul class="p-0 mb-0 border-top pt-2">
                        @foreach ($order->items as $item)
                            @php
                                $product = $item->productSu->product;
                                $total_price = $item->product_su_sale_price * $item->quantity;
                            @endphp
                            <li class="d-flex align-items-center">
                                <a href="/product/{{ $product->id }}/{{ $product->slug }}" style="width: 100px;">
                                    <img src="{{ $product->image->url }}" class="w-100" alt="{{ $product->name }}">
                                </a>
                                <div class="d-flex flex-column flex-grow-1 mr-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>{{ $product->name }}</small>
                                        <small>{{ $item->quantity }} عدد</small>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center">
                                            <small>قیمت کل : </small>
                                            <small class="mr-2">
                                                {{ number_format($total_price) }}
                                                تومان
                                            </small>
                                        </div>
                                        @if ($item->product_su_discounted_price)
                                            <div class="d-flex align-items-center text-danger">
                                                <small>تخفیف : </small>
                                                <small class="mr-2">
                                                    {{ number_format($item->product_su_price * $item->quantity - $total_price) }}
                                                    تومان
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
