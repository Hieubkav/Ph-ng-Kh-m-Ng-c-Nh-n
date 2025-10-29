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
    
    $pageTitle = $post->name . ' | ' . config('app.name');
@endphp

@section('title', $pageTitle)

@section('meta')
    <link rel="canonical" href="{{ route('post', $post->slug) }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->name }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ route('post', $post->slug) }}">
    <meta property="og:image" content="{{ $ogImage }}">
@endsection

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "{{ str_replace('"', '\"', $post->name) }}",
    "description": "{{ str_replace('"', '\"', $metaDescription) }}",
    "image": "{{ $ogImage }}",
    "author": {
        "@type": "Organization",
        "name": "Phòng Khám Đa Khoa Ngọc Nhân"
    },
    "publisher": {
        "@type": "Organization",
        "name": "Phòng Khám Đa Khoa Ngọc Nhân",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.webp') }}"
        }
    },
    "datePublished": "{{ $post->created_at->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ route('post', $post->slug) }}"
    }
}
</script>
@endpush

@section('content')
    @include('component.post.contentPost', ['post' => $post])
@endsection
