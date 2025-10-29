@extends('layouts.shop')

@php
    $catPost = App\Models\CatPost::find($id);
    $pageTitle = $catPost ? $catPost->name . ' | ' . config('app.name') : config('app.name');
@endphp

@section('title', $pageTitle)

@section('meta')
    @php
        $catPost = App\Models\CatPost::find($id);
        $currentUrl = route('catPost', ['id' => $id]);
        $metaDescription = $catPost ? 
            \Illuminate\Support\Str::limit(strip_tags($catPost->description ?? ''), 160, '...') : 
            'Khám phá các bài viết về sức khỏe tại Phòng Khám Đa Khoa Ngọc Nhân.';
        $metaTitle = $catPost ? $catPost->name . ' | ' . config('app.name') : config('app.name');
    @endphp
    <link rel="canonical" href="{{ $currentUrl }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $catPost->seo_keyword ?? 'bài viết sức khỏe, y tế, phòng khám đa khoa ngọc nhân' }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/banner.webp') }}">
@endsection

@section('content')
    @include('component.catPost.contentCatPost')
@endsection
