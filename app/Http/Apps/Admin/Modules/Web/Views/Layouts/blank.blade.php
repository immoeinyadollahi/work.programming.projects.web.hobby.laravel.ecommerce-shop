<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl">
<!--begin::Head-->

<head>
    <title>@yield('page-title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/public/admin/media/logos/favicon.ico">
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="/public/admin/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css">
    <link href="/public/admin/css/style.bundle.rtl.css" rel="stylesheet" type="text/css">
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <!--begin::Root-->
    @if (session()->has('messages'))
        <div class="container alert-container js-alert-container mt-3">
            @foreach (session()->get('messages') as $item)
                <!--begin::Alert-->
                <div class="alert alert-{{ $item['level'] }} d-flex align-items-center justify-content-between p-4">
                    <!--begin::Wrapper-->
                    <!--begin::Title-->
                    <h5 class="text-{{ $item['level'] }} m-0">{{ $item['message'] }}</h5>
                    <!--end::Title-->
                    <!--end::Wrapper-->
                    <!--begin::Close-->
                    <button type="button" class="btn p-0" data-bs-dismiss="alert">
                        <i class="bi bi-x fs-1 text-{{ $item['level'] }}"></i>
                    </button>
                    <!--end::Close-->
                </div>
                <!--end::Alert-->
            @endforeach
        </div>
    @endif
    @yield('page-content')
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="/public/admin/plugins/global/plugins.bundle.js"></script>
    <script src="/public/admin/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page سفارشی Javascript(used by this page)-->
    @yield('page-custom-scripts')
    <!--end::Page custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
