@extends('layouts.shop')

@php
    $hiringTitle = 'Tuyển Dụng | Phòng Khám Đa Khoa Ngọc Nhân';
    $hiringDescription = isset($settings?->hr_content)
        ? \Illuminate\Support\Str::limit(strip_tags($settings->hr_content), 160, '...')
        : 'Khám phá cơ hội nghề nghiệp tại Phòng Khám Đa Khoa Ngọc Nhân và gia nhập đội ngũ y bác sĩ tận tâm.';
@endphp

@section('title', $hiringTitle)

@section('meta')
    @php $currentUrl = url()->current(); @endphp
    <link rel="canonical" href="{{ $currentUrl }}">
    <meta name="description" content="{{ $hiringDescription }}">
    <meta name="keywords" content="tuyển dụng phòng khám, việc làm y tế, phòng khám đa khoa ngọc nhân, cơ hội nghề nghiệp ngành y">
    <meta property="og:title" content="{{ $hiringTitle }}">
    <meta property="og:description" content="{{ $hiringDescription }}">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:image" content="{{ asset('images/banner.webp') }}">
    <meta property="og:type" content="website">
@endsection

@section('content')
    @include('component.hiring.contentHiring')
@endsection
