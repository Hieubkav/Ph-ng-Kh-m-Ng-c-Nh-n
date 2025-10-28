@php
    $setting = $settings;
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-medical-green-dark mb-4">Cơ Hội Nghề Nghiệp</h1>
        <div class="w-20 h-1 bg-medical-green mx-auto mb-6 rounded-full"></div>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Hãy gia nhập đội ngũ y tế chuyên nghiệp của chúng tôi và cùng nhau mang đến sự chăm sóc tốt nhất cho bệnh nhân
        </p>
    </div>

    @if($setting->hr_status=='on')
        <!-- Active Job Listings -->
        <div class="prose prose-lg max-w-none
                    prose-headings:text-medical-green-dark prose-headings:font-bold
                    prose-h2:text-2xl prose-h2:mt-0 prose-h3:text-xl
                    prose-p:text-gray-600 prose-ul:text-gray-600
                    prose-li:my-1 prose-li:pl-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sm:p-8">
                <div class="space-y-8 divide-y divide-gray-200 [&>*:first-child]:mt-0 [&>*:last-child]:mb-0 [&>div]:pt-8 [&>div:first-child]:pt-0">
                    {!! $setting->hr_content !!}
                </div>
            </div>
            <div class="mt-8 text-center">
                <p class="text-gray-500">Nếu bạn quan tâm đến vị trí nào, vui lòng gửi CV của bạn đến email: <a href="mailto:{{$setting->email}}" class="text-medical-green hover:text-medical-green-dark">{{$setting->email}}</a></p>
            </div>
        </div>
    @else
        <!-- No Jobs Available State -->
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <div class="max-w-md mx-auto px-4">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h2 class="text-xl sm:text-2xl font-semibold text-medical-green-dark mb-2">Hiện Tại Chưa Có Vị Trí Tuyển Dụng</h2>
                <p class="text-gray-600 text-lg">Vui lòng quay lại sau để xem các cơ hội mới</p>
            </div>
        </div>
    @endif
</div>

