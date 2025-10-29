@extends('layouts.shop')

@section('title', '404 - Không tìm thấy trang')

@section('meta')
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="Trang bạn tìm kiếm không tồn tại. Vui lòng kiểm tra lại đường dẫn hoặc quay về trang chủ Phòng Khám Đa Khoa Ngọc Nhân.">
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full text-center">
        <!-- 404 Icon/Image -->
        <div class="mb-8">
            <svg class="mx-auto h-32 w-32 text-blue-500 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl sm:text-8xl font-bold text-gray-800 mb-4">404</h1>
        
        <!-- Error Message -->
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-700 mb-4">
            Không Tìm Thấy Trang
        </h2>
        
        <p class="text-gray-600 mb-8 px-4">
            Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã được chuyển đến địa chỉ khác. 
            Vui lòng kiểm tra lại đường dẫn hoặc sử dụng các liên kết bên dưới.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('storeFront') }}" 
               class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Về Trang Chủ
            </a>
            
            <button onclick="history.back()" 
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Quay Lại
            </button>
        </div>

        <!-- Helpful Links -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Liên Kết Hữu Ích</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-lg mx-auto">
                @if(isset($services) && $services->count() > 0)
                    <a href="{{ route('services', $services->first()->id) }}" 
                       class="text-blue-600 hover:text-blue-800 hover:underline">
                        Dịch Vụ
                    </a>
                @endif
                
                @if(isset($catPosts) && $catPosts->count() > 0)
                    <a href="{{ route('catPost', $catPosts->first()->id) }}" 
                       class="text-blue-600 hover:text-blue-800 hover:underline">
                        Tin Tức
                    </a>
                @endif
                
                <a href="{{ route('hiring') }}" 
                   class="text-blue-600 hover:text-blue-800 hover:underline">
                    Tuyển Dụng
                </a>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="mt-8 text-sm text-gray-500">
            <p>Nếu bạn cần hỗ trợ, vui lòng liên hệ với chúng tôi</p>
            @if(isset($setting) && $setting->phone_contact)
                <p class="mt-2">
                    <span class="font-medium">Hotline:</span> 
                    <a href="tel:{{ $setting->phone_contact }}" class="text-blue-600 hover:underline">
                        {{ $setting->phone_contact }}
                    </a>
                </p>
            @endif
        </div>
    </div>
</div>

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "404 - Không tìm thấy trang",
    "description": "Trang không tồn tại - Phòng Khám Đa Khoa Ngọc Nhân",
    "url": "{{ url()->current() }}",
    "publisher": {
        "@type": "MedicalOrganization",
        "name": "Phòng Khám Đa Khoa Ngọc Nhân",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.webp') }}"
        }
    }
}
</script>
@endpush
@endsection
