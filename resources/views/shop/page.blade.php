@extends('layouts.shop')

@php
    $page = $page ?? (($id ?? null) ? App\Models\Page::find($id) : null);
    $metaTitle = $page?->name
        ? $page->name . ' | Phòng Khám Đa Khoa Ngọc Nhân'
        : 'Phòng Khám Đa Khoa Ngọc Nhân';
    $metaDescription = $page?->content
        ? \Illuminate\Support\Str::limit(strip_tags($page->content), 160, '...')
        : 'Cập nhật thông tin mới nhất từ Phòng Khám Đa Khoa Ngọc Nhân.';
    $metaImage = ($page?->image)
        ? config('app.asset_url') . '/storage/' . $page->image
        : asset('images/banner.webp');
@endphp

@section('title', $metaTitle)

@section('meta')
    @php $currentUrl = url()->current(); @endphp
    <link rel="canonical" href="{{ $currentUrl }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="phòng khám đa khoa ngọc nhân, thông tin phòng khám, dịch vụ y tế, tin tức y tế">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:type" content="article">
@endsection

@section('content')
    @include('component.page.contentPage', ['page' => $page])
@endsection
