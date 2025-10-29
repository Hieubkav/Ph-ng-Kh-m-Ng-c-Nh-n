@extends('layouts.shop')

@section('title', 'Phòng Khám Đa Khoa Ngọc Nhân | Dịch Vụ Y Tế Chất Lượng Cao')

@section('meta')
    @php $currentUrl = url()->current(); @endphp
    <link rel="canonical" href="{{ $currentUrl }}">
    <meta name="description" content="Phòng Khám Đa Khoa Ngọc Nhân cung cấp dịch vụ y tế toàn diện, đội ngũ bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại tại TP. Hồ Chí Minh.">
    <meta name="keywords" content="Phòng Khám Đa Khoa Ngọc Nhân, dịch vụ y tế, bác sĩ chuyên khoa, khám chữa bệnh, phòng khám uy tín">
    <meta property="og:title" content="Phòng Khám Đa Khoa Ngọc Nhân - Dịch Vụ Y Tế Chất Lượng Cao">
    <meta property="og:description" content="Khám chữa bệnh đa khoa, chẩn đoán chuyên sâu và chăm sóc sức khỏe trọn gói tại Phòng Khám Đa Khoa Ngọc Nhân.">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/banner.webp') }}">
@endsection

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "MedicalOrganization",
    "name": "Phòng Khám Đa Khoa Ngọc Nhân",
    "alternateName": "Phòng khám Ngọc Nhân",
    "url": "https://pkngocnhan.vn",
        "logo": {
        "@type": "ImageObject",
        "url": "{{ asset('images/logo.webp') }}"
    },
    "description": "Phòng Khám Đa Khoa Ngọc Nhân cung cấp dịch vụ y tế toàn diện với đội ngũ bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại",
    "address": {
        "@type": "PostalAddress",
        "addressLocality": "TP. Hồ Chí Minh",
        "addressCountry": "VN"
    },
    "medicalSpecialty": [
        "Đa khoa",
        "Nội khoa", 
        "Nhi khoa",
        "Sản phụ khoa"
    ],
    "availableService": {
        "@type": "MedicalService",
        "name": "Khám chữa bệnh đa khoa",
        "description": "Dịch vụ khám chữa bệnh toàn diện cho mọi đối tượng"
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}"
    }
}
</script>
@endpush

@section('content')
    <section class="bg-white py-10">
        <div class="container mx-auto px-4 text-center max-w-4xl">
            <h1 class="text-3xl sm:text-4xl font-bold text-medical-green-dark">
                Phòng Khám Đa Khoa Ngọc Nhân - Dịch Vụ Y Tế Chất Lượng Cao
            </h1>
            <p class="mt-4 text-gray-600 text-lg sm:text-xl">
                Điểm đến tin cậy cho nhu cầu chăm sóc sức khỏe toàn diện của gia đình bạn, hội tụ đội ngũ bác sĩ chuyên khoa giàu kinh nghiệm và hệ thống thiết bị chuẩn quốc tế.
            </p>
        </div>
    </section>
    @include('component.storeFront.carousel', [
        'carousels' => $carousels,
        'hotPosts' => $hotPosts,
    ])
    @include('component.storeFront.schedule', ['activeSchedule' => $activeSchedule])
    @include('component.storeFront.service', ['services' => $services])
    @include('component.storeFront.doctorCarousel', ['doctors' => $doctors])
    @include('component.storeFront.post', ['catPosts' => $catPosts])
@endsection
