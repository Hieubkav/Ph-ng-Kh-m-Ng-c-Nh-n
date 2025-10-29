@extends('layouts.shop')

@section('title', '429 - Quá Nhiều Yêu Cầu')

@section('meta')
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="Bạn đã gửi quá nhiều yêu cầu. Vui lòng đợi một lát và thử lại.">
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full text-center">
        <!-- Rate Limit Icon -->
        <div class="mb-8">
            <svg class="mx-auto h-32 w-32 text-purple-500 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                      d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl sm:text-8xl font-bold text-gray-800 mb-4">429</h1>
        
        <!-- Error Message -->
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-700 mb-4">
            Quá Nhiều Yêu Cầu
        </h2>
        
        <p class="text-gray-600 mb-8 px-4">
            Bạn đã gửi quá nhiều yêu cầu trong thời gian ngắn. 
            Để bảo vệ hệ thống và đảm bảo chất lượng dịch vụ cho tất cả người dùng, 
            vui lòng đợi một lát trước khi thử lại.
        </p>

        <!-- Countdown Timer -->
        <div class="mb-8 p-4 bg-purple-50 rounded-lg inline-block">
            <p class="text-lg font-semibold text-purple-700">
                Vui lòng đợi: <span id="countdown">60</span> giây
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button id="retryBtn" onclick="location.reload()" disabled
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-gray-400 rounded-lg cursor-not-allowed transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Thử Lại
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

        <!-- Information -->
        <div class="mt-12 p-6 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Tại Sao Điều Này Xảy Ra?</h3>
            <ul class="text-gray-600 text-sm text-left space-y-2">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Bảo vệ hệ thống khỏi tấn công tự động</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Đảm bảo hiệu suất ổn định cho tất cả người dùng</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Ngăn chặn việc lạm dụng tài nguyên hệ thống</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Countdown timer
    let timeLeft = 60;
    const countdownEl = document.getElementById('countdown');
    const retryBtn = document.getElementById('retryBtn');
    
    const countdown = setInterval(function() {
        timeLeft--;
        countdownEl.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(countdown);
            countdownEl.parentElement.textContent = 'Bạn có thể thử lại ngay bây giờ';
            retryBtn.disabled = false;
            retryBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            retryBtn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
        }
    }, 1000);
</script>
@endpush
@endsection
