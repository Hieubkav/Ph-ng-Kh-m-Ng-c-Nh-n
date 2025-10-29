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
    
    $siteUrl = rtrim(config('app.url') ?: url('/'), '/');
    $logoUrl = asset('images/logo.webp');
    
    $pageTitle = $servicePost->name . ' | ' . $service->name . ' | ' . config('app.name');
@endphp

@section('title', $pageTitle)

@section('meta')
    <link rel="canonical" href="{{ $servicePostUrl }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $servicePost->name }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $servicePostUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
@endsection

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "MedicalService",
    "name": "{{ str_replace('"', '\"', $servicePost->name) }}",
    "description": "{{ str_replace('"', '\"', $metaDescription) }}",
    "image": "{{ $ogImage }}",
    "provider": {
        "@type": "MedicalOrganization",
        "name": "Phòng Khám Đa Khoa Ngọc Nhân",
        "url": "{{ $siteUrl }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ $logoUrl }}"
        }
    },
    "url": "{{ $servicePostUrl }}",
    "serviceType": "{{ str_replace('"', '\"', $service->name) }}",
    "datePublished": "{{ $servicePost->created_at->toIso8601String() }}",
    "dateModified": "{{ $servicePost->updated_at->toIso8601String() }}",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $servicePostUrl }}"
    }
}
</script>
@endpush

@section('content')
    @include('component.services.contentServicePost', [
        'service' => $service,
        'servicePost' => $servicePost,
    ])
@endsection
