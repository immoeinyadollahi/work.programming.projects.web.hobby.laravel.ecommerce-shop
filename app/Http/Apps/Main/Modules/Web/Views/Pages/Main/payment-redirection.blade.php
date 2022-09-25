@extends('layouts.master')
@section('page-title', $_settings->website_name)
@section('page-content')
    <div class="container">
        <div class="alert alert-success m-0 mt-3">در حال منتقل شدن به درگاه پرداخت ...</div>
    </div>
    <form id="payment-redirection-form" method="{{ $redirection->method }}" action="{{ $redirection->action }}">
        @if ($redirection->inputs)
            @foreach ($redirection->inputs as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        @endif
    </form>
@endsection
@section('page-scripts')
    <script>
        $(window).on("load", (e) => $("#payment-redirection-form").submit());
    </script>
@endsection
