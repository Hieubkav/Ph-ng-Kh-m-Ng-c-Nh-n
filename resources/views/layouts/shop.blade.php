<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--   Thẻ tạo icon--}}
    <link rel="icon" href="{{ asset('images/logo.webp') }}">

    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
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

@filamentScripts
@vite('resources/js/app.js')
</body>
</html>
