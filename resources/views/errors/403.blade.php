@extends('layouts.shop')

@section('title', '403 - Truy Cập Bị Từ Chối')

@section('meta')
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="Bạn không có quyền truy cập vào trang này. Vui lòng liên hệ quản trị viên nếu cần hỗ trợ.">
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full text-center">
        <!-- 403 Icon -->
        <div class="mb-8">
            <svg class="mx-auto h-32 w-32 text-yellow-500 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl sm:text-8xl font-bold text-gray-800 mb-4">403</h1>
        
        <!-- Error Message -->
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-700 mb-4">
            Truy Cập Bị Từ Chối
        </h2>
        
        <p class="text-gray-600 mb-8 px-4">
            Bạn không có quyền truy cập vào trang này. 
            Nội dung này có thể yêu cầu quyền đặc biệt hoặc đăng nhập.
            Vui lòng kiểm tra lại quyền truy cập của bạn.
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

        <!-- Help Section -->
        <div class="mt-12 p-6 bg-yellow-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Bạn Cần Trợ Giúp?</h3>
            <p class="text-gray-600 mb-4">
                Nếu bạn cho rằng đây là lỗi, vui lòng liên hệ với bộ phận hỗ trợ:
            </p>
            @if(isset($setting) && $setting->phone_contact)
                <p class="text-lg">
                    <span class="font-medium">Hotline:</span> 
                    <a href="tel:{{ $setting->phone_contact }}" class="text-blue-600 hover:underline font-semibold">
                        {{ $setting->phone_contact }}
                    </a>
                </p>
            @endif
            @if(isset($setting) && $setting->email)
                <p class="text-lg mt-2">
                    <span class="font-medium">Email:</span> 
                    <a href="mailto:{{ $setting->email }}" class="text-blue-600 hover:underline">
                        {{ $setting->email }}
                    </a>
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
