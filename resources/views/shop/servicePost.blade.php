@extends('layouts.shop')

@php
    /** @var \App\Models\Service $service */
    /** @var \App\Models\ServicePost $servicePost */
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

    $ogImage = $storageUrl($servicePost->og_image)
        ?? $storageUrl($settings?->tmp_pic)
        ?? asset('images/banner.webp');

    $metaDescription = trim(\Illuminate\Support\Str::limit(strip_tags($servicePost->content ?? ''), 155, '...'));
    if ($metaDescription === '') {
        $metaDescription = $settings?->slogan ?? config('app.name');
    }

    $servicePostUrl = route('servicePost', [
        'serviceId' => $service->id,
        'slug' => $servicePost->slug,
    ]);
@endphp

@section('meta')
    <link rel="canonical" href="{{ $servicePostUrl }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $servicePost->name }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $servicePostUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
@endsection

@section('content')
    @include('component.services.contentServicePost', [
        'service' => $service,
        'servicePost' => $servicePost,
    ])
@endsection
