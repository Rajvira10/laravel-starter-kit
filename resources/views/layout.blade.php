<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none"
    data-preloader="disable">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @include('head-links')

    <title>@yield('title', 'Export Promotion Bureau')</title>

    @php
        $settings = App\Models\Setting::first();
        $brandColor = $settings->brand_color ?? '';
    @endphp

    <style>
        .navbar-menu {
            background-color: {{ $brandColor }};
        }

        .nav-link {
            color: #d6d6d6 !important;
        }

        .nav-link.active {
            color: #fff !important;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #fff !important;
        }
    </style>


</head>

<body>

    <div id="layout-wrapper">

        @include('top-header')

        @include('sidebar')

        @yield('content')

        {{-- @include('theme-customizer') --}}

    </div>

    @include('scripts')

    @yield('custom-script')
</body>

</html>
