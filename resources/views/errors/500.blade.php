@extends('layouts.shop')

@section('title', '500 - Lỗi Máy Chủ')

@section('meta')
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="Đã xảy ra lỗi từ phía máy chủ. Chúng tôi đang khắc phục sự cố này. Vui lòng thử lại sau.">
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <svg class="mx-auto h-32 w-32 text-red-500 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl sm:text-8xl font-bold text-gray-800 mb-4">500</h1>
        
        <!-- Error Message -->
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-700 mb-4">
            Lỗi Máy Chủ Nội Bộ
        </h2>
        
        <p class="text-gray-600 mb-8 px-4">
            Xin lỗi, đã xảy ra lỗi không mong muốn từ phía máy chủ. 
            Đội ngũ kỹ thuật của chúng tôi đã được thông báo và đang khắc phục sự cố này.
            Vui lòng thử lại sau vài phút.
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
            
            <button onclick="location.reload()" 
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Thử Lại
            </button>
        </div>

        <!-- Contact Support -->
        <div class="mt-12 p-6 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Cần Hỗ Trợ Ngay?</h3>
            <p class="text-gray-600 mb-4">
                Nếu sự cố vẫn tiếp tục, vui lòng liên hệ với chúng tôi:
            </p>
            @if(isset($setting) && $setting->phone_contact)
                <p class="text-lg">
                    <span class="font-medium">Hotline:</span> 
                    <a href="tel:{{ $setting->phone_contact }}" class="text-blue-600 hover:underline font-semibold">
                        {{ $setting->phone_contact }}
                    </a>
                </p>
            @endif
        </div>

        <!-- Error ID for debugging -->
        <div class="mt-8 text-xs text-gray-400">
            <p>Mã lỗi: {{ uniqid('ERR-') }}</p>
            <p>Thời gian: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</div>
@endsection
