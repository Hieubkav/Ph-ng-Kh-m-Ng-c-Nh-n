@extends('layouts.shop')

@section('title', '419 - Phiên Làm Việc Hết Hạn')

@section('meta')
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="Phiên làm việc của bạn đã hết hạn. Vui lòng tải lại trang và thử lại.">
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full text-center">
        <!-- Session Icon -->
        <div class="mb-8">
            <svg class="mx-auto h-32 w-32 text-indigo-500 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl sm:text-8xl font-bold text-gray-800 mb-4">419</h1>
        
        <!-- Error Message -->
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-700 mb-4">
            Phiên Làm Việc Hết Hạn
        </h2>
        
        <p class="text-gray-600 mb-8 px-4">
            Phiên làm việc của bạn đã hết hạn vì lý do bảo mật. 
            Điều này thường xảy ra khi bạn không hoạt động trong một thời gian dài.
            Vui lòng tải lại trang để tiếp tục.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="location.reload()" 
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Tải Lại Trang
            </button>
            
            <a href="{{ route('storeFront') }}" 
               class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Về Trang Chủ
            </a>
        </div>

        <!-- Security Notice -->
        <div class="mt-12 p-6 bg-indigo-50 rounded-lg">
            <svg class="w-8 h-8 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Vì Sự An Toàn Của Bạn</h3>
            <p class="text-gray-600 text-sm">
                Chúng tôi tự động kết thúc phiên làm việc sau một thời gian không hoạt động 
                để bảo vệ thông tin của bạn. Đây là biện pháp bảo mật quan trọng.
            </p>
        </div>
    </div>
</div>
@endsection
