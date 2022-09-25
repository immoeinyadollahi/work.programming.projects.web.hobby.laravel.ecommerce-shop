@extends('layouts.master')
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
                        @yield('users-page-breadcrumb')
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>@yield('users-page-header-title')</h1>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3 d-flex">
                    <div class="account-nav flex-grow-1">
                        <h4 class="account-nav__title">ناوبری</h4>
                        <ul>
                            @php
                                $pages = [
                                    [
                                        'name' => 'users.dashboard',
                                        'title' => 'داشبورد',
                                    ],
                                    [
                                        'name' => 'users.profile',
                                        'title' => 'ویرایش پروفایل',
                                    ],
                                    [
                                        'name' => 'users.orders',
                                        'matches' => ['users.orders', 'users.orders.order'],
                                        'title' => 'سفارش ها',
                                    ],
                                    [
                                        'name' => 'users.addresses',
                                        'matches' => ['users.addresses', 'users.addresses.add', 'users.addresses.edit'],
                                        'title' => 'آدرس ها',
                                    ],
                                    [
                                        'name' => 'users.change-password',
                                        'title' => 'تغییر رمز عبور',
                                    ],
                                ];
                            @endphp
                            @foreach ($pages as $page)
                                <li
                                    class="account-nav__item{{ (isset($page['matches']) ? _is_route(...$page['matches']) : _is_route($page['name'])) ? ' account-nav__item--active' : '' }}">
                                    <a href="{{ _route($page['name']) }}">{{ $page['title'] }}</a>
                                </li>
                            @endforeach
                            <li class="account-nav__item"><a href="/logout">خروج</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                    @yield('users-page-content')
                </div>
            </div>
        </div>
    </div>
@endsection
