@extends('layouts.shop')

@php
    /** @var \App\Models\Post $post */
    $assetBase = config('app.asset_url') ? rtrim(config('app.asset_url'), '/') : null;
    $storageUrl = function (?string $path) use ($assetBase) {
        if (!$path) {
            return null;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        return $assetBase
            ? $assetBase . '/storage/' . $normalized
            : asset('storage/' . $normalized);
    };

    $ogImage = $storageUrl($post->og_image)
        ?? $storageUrl($settings?->tmp_pic)
        ?? asset('images/banner.webp');

    $metaDescription = trim(\Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 155, '...'));
    if ($metaDescription === '') {
        $metaDescription = $settings?->slogan ?? config('app.name');
    }
@endphp

@section('meta')
    <link rel="canonical" href="{{ route('post', $post->slug) }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->name }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ route('post', $post->slug) }}">
    <meta property="og:image" content="{{ $ogImage }}">
@endsection

@section('content')
    @include('component.post.contentPost', ['post' => $post])
@endsection
