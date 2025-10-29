@extends('layouts.shop')

@php
    $service = $service ?? (($id ?? null) ? App\Models\Service::find($id) : null);
    $defaultTitle = 'Dịch Vụ Y Tế | Phòng Khám Đa Khoa Ngọc Nhân';
    $metaTitle = $service?->name
        ? $service->name . ' | Phòng Khám Đa Khoa Ngọc Nhân'
        : $defaultTitle;
    $metaDescription = $service?->description
        ? \Illuminate\Support\Str::limit(strip_tags($service->description), 160, '...')
        : 'Khám phá danh mục dịch vụ y tế chuyên sâu với đội ngũ bác sĩ giàu kinh nghiệm tại Phòng Khám Đa Khoa Ngọc Nhân.';
    $metaImage = $service?->image_url ?? asset('images/banner.webp');
    $metaKeywords = $service?->seo_keyword
        ?? 'dịch vụ y tế, phòng khám đa khoa ngọc nhân, chăm sóc sức khỏe, bác sĩ chuyên khoa';
    $siteUrl = rtrim(config('app.url') ?: url('/'), '/');
    $logoUrl = asset('images/logo.webp');
@endphp

@section('title', $metaTitle)

@section('meta')
    @php $currentUrl = url()->current(); @endphp
    <link rel="canonical" href="{{ $currentUrl }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:type" content="article">
@endsection

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "MedicalService",
    "name": "{{ str_replace('"', '\"', $metaTitle) }}",
    "description": "{{ str_replace('"', '\"', $metaDescription) }}",
    @if($service && $service->image_url)
    "image": "{{ $metaImage }}",
    @endif
    "provider": {
        "@type": "MedicalOrganization",
        "name": "Phòng Khám Đa Khoa Ngọc Nhân",
        "url": "{{ $siteUrl }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ $logoUrl }}"
        }
    },
    "url": "{{ $currentUrl }}",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $currentUrl }}"
    }
}
</script>
@endpush

@section('content')
    @include('component.services.contentServices', ['service' => $service])
@endsection
