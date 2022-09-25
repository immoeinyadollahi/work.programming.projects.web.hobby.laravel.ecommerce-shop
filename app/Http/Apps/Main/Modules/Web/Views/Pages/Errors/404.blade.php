@extends('layouts.master')
@section('page-title', 'صفحه مورد نظر پیدا نشد')
@section('page-content')
    <div class="block">
        <div class="container">
            <div class="not-found">
                <div class="not-found__404">وای! خطای 404</div>
                <div class="not-found__content">
                    <h1 class="not-found__title">صفحه مورد نظر پیدا نشد</h1>
                    <p class="not-found__text">ما صفحه ای که دنبال آن بودید را پیدا نکردیم.
                        <br>لطفا از جستجو استفاده کنید.
                    </p>
                    <form class="not-found__search">
                        <input type="text" class="not-found__search-input form-control" placeholder="عبارت مورد جستجو ...">
                        <button type="submit" class="not-found__search-button btn btn-primary">جستجو</button>
                    </form>
                    <p class="not-found__text">یا برای شروع مجدد به صفحه خانه بروید.</p>
                    <a class="btn btn-secondary btn-sm" href="/">رفتن به صفحه خانه</a>
                </div>
            </div>
        </div>
    </div>
@endsection
