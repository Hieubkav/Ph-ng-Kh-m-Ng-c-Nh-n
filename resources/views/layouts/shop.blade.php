<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @hasSection('meta')
        @yield('meta')
    @else
        <link rel="canonical" href="https://pkngocnhan.vn">
        <meta name="description" content="Phòng Khám Đa Khoa Ngọc Nhân - Cung cấp dịch vụ y tế toàn diện với đội ngũ bác sĩ chuyên nghiệp và trang thiết bị hiện đại. Chúng tôi cam kết mang đến dịch vụ chăm sóc sức khỏe chất lượng cao, đáp ứng mọi nhu cầu khám chữa bệnh của bạn.">
        <meta name="keywords" content="Phòng Khám Đa Khoa Ngọc Nhân, khám đa khoa, dịch vụ y tế, chăm sóc sức khỏe, bác sĩ chuyên nghiệp, trang thiết bị hiện đại, khám chữa bệnh">
        <meta name="robots" content="all">
        <meta property="og:title" content="Phòng Khám Đa Khoa Ngọc Nhân - Dịch Vụ Y Tế Chất Lượng Cao">
        <meta property="og:description" content="Phòng Khám Đa Khoa Ngọc Nhân cung cấp dịch vụ khám chữa bệnh đa khoa với đội ngũ bác sĩ giàu kinh nghiệm và trang thiết bị y tế hiện đại. Chúng tôi cam kết mang đến trải nghiệm chăm sóc sức khỏe tốt nhất cho bạn và gia đình.">
        <meta property="og:url" content="https://pkngocnhan.vn">
        <meta property="og:image" content="{{ asset('images/banner.webp') }}">
    @endif

    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebPage",
          "name": "Phòng Khám Đa Khoa Ngọc Nhân - Dịch Vụ Y Tế Toàn Diện",
          "description": "Phòng Khám Đa Khoa Ngọc Nhân là địa chỉ uy tín cung cấp dịch vụ y tế chất lượng cao, với đội ngũ bác sĩ chuyên nghiệp và trang thiết bị hiện đại, đáp ứng mọi nhu cầu khám chữa bệnh của bạn.",
          "url": "https://pkngocnhan.vn"
        }
    </script>
    @stack('structured-data')
    <meta name="revisit-after" content="1 day">
    <meta name="HandheldFriendly" content="true">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <meta name="author" content="Trần Mạnh Hiếu (Hieubkav)">

    <link rel="icon" href="{{ asset('images/logo.webp') }}">

    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @livewireStyles
    @vite('resources/css/app.css')
    @stack('head')
</head>

<body class="antialiased">

@include('component.shop.navbar')
<main class="bg-gray-100">
    @yield('content')
</main>
@include('component.shop.footer')
@include('component.shop.speedial')
@include('component.shop.modal')

@livewire('notifications')
@livewireScripts

@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
