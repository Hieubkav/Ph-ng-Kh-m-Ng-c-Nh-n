@extends('layouts.shop')

@section('title', '503 - Bảo Trì Hệ Thống')

@section('meta')
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="Website đang trong quá trình bảo trì. Chúng tôi sẽ quay lại sớm nhất có thể. Xin lỗi vì sự bất tiện này.">
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full text-center">
        <!-- Maintenance Icon -->
        <div class="mb-8">
            <svg class="mx-auto h-32 w-32 text-orange-500 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl sm:text-8xl font-bold text-gray-800 mb-4">503</h1>
        
        <!-- Error Message -->
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-700 mb-4">
            Đang Bảo Trì Hệ Thống
        </h2>
        
        <p class="text-gray-600 mb-4 px-4">
            Website hiện đang trong quá trình bảo trì để nâng cấp và cải thiện trải nghiệm người dùng.
        </p>
        
        <p class="text-gray-600 mb-8 px-4">
            Chúng tôi sẽ trở lại hoạt động trong thời gian sớm nhất. 
            Xin lỗi vì sự bất tiện này!
        </p>

        <!-- Estimated Time -->
        <div class="mb-8 p-4 bg-orange-50 rounded-lg inline-block">
            <p class="text-lg font-semibold text-orange-700">
                Thời gian dự kiến: 30 phút
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="location.reload()" 
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Thử Lại
            </button>
            
            <button onclick="history.back()" 
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Quay Lại
            </button>
        </div>

        <!-- Contact Info -->
        <div class="mt-12">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Liên Hệ Khẩn Cấp</h3>
            <p class="text-gray-600 mb-4">
                Trong trường hợp khẩn cấp, vui lòng liên hệ trực tiếp:
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

        <!-- Social Links (Optional) -->
        <div class="mt-8 text-sm text-gray-500">
            <p>Theo dõi cập nhật từ chúng tôi trên mạng xã hội</p>
            <!-- Add social media icons/links here if available -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tự động refresh sau 5 phút
    setTimeout(function() {
        location.reload();
    }, 300000); // 5 phút = 300000ms
</script>
@endpush
@endsection
