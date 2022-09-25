@extends('layouts.master')
@section('page-title', $_settings->website_name)
@section('page-content')
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__title">
                @isset($request_query_result['search_term'])
                    <h3 class="m-0">جستجو برای نام "{{ $request_query_result['search_term'] }}"</h3>
                @endisset
                @isset($request_query_result['tag'])
                    <h3 class="m-0">جستجو برای برچسب "{{ $request_query_result['tag'] }}"</h3>
                @endisset
            </div>
        </div>
    </div>
    <div class="container" data-component="page-content"></div>
@endsection
@section('page-scripts')
    <script>
        __DATA__.dependencies.push("pages.search");
        Object.assign(__DATA__.pageData, {
            productsPaginator: @json($paginator),
            brands: @json($brands),
            categories: @json($categories),
        });
    </script>
@endsection
