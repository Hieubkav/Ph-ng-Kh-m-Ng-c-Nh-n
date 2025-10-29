<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $appName = config('app.name');
        $canonicalUrl = url()->current();
        $logoUrl = asset('images/logo.webp');
    @endphp

    @hasSection('meta')
        @yield('meta')
    @else
        <link rel="canonical" href="{{ $canonicalUrl }}">
        <meta name="description" content="Phòng Khám Đa Khoa Ngọc Nhân cung cấp dịch vụ khám chữa bệnh tổng quát và chuyên khoa với đội ngũ bác sĩ giàu kinh nghiệm, trang thiết bị hiện đại, cam kết chăm sóc sức khỏe toàn diện cho gia đình bạn.">
        <meta name="keywords" content="Phòng Khám Đa Khoa Ngọc Nhân, phòng khám đa khoa Bình Dương, khám tổng quát, khám chuyên khoa, bác sĩ giàu kinh nghiệm, trang thiết bị hiện đại">
        <meta name="robots" content="all">
        <meta property="og:title" content="Phòng Khám Đa Khoa Ngọc Nhân - Chăm Sóc Sức Khỏe Toàn Diện">
        <meta property="og:description" content="Phòng Khám Đa Khoa Ngọc Nhân đồng hành cùng bạn với các gói khám tổng quát, chuyên khoa, trang thiết bị hiện đại và đội ngũ bác sĩ tận tâm, mang lại trải nghiệm chăm sóc sức khỏe an toàn và hiệu quả.">
        <meta property="og:url" content="{{ $canonicalUrl }}">
        <meta property="og:image" content="{{ asset('images/banner.webp') }}">
    @endif

    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebPage",
          "name": "Phòng Khám Đa Khoa Ngọc Nhân - Chăm Sóc Sức Khỏe Toàn Diện",
          "description": "Phòng Khám Đa Khoa Ngọc Nhân mang đến giải pháp chăm sóc sức khỏe toàn diện, từ khám tổng quát đến điều trị chuyên sâu với đội ngũ bác sĩ giàu kinh nghiệm và công nghệ hiện đại.",
          "url": "{{ $canonicalUrl }}",
          "publisher": {
            "@type": "Organization",
            "name": "{{ $appName }}",
            "logo": {
              "@type": "ImageObject",
              "url": "{{ $logoUrl }}"
            }
          }
        }
    </script>
    @stack('structured-data')
    <meta name="revisit-after" content="1 day">
    <meta name="HandheldFriendly" content="true">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <meta name="author" content="Trần Mạnh Hiếu (Hieubkav)">

    <link rel="icon" href="{{ asset('images/logo.webp') }}">

    <title>@yield('title', config('app.name'))</title>

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

@vite(['resources/js/vendor.js', 'resources/js/app.js'])
@stack('scripts')
</body>
</html>
