@php
    $setting = \App\Models\Setting::first();

@endphp

<footer class="bg-green-600 text-white">
    <!-- Top Footer -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Thông tin phòng khám -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-r from-medical-green-light to-medical-green rounded-full flex items-center justify-center">
                        <img src="{{config('app.asset_url')}}/storage/{{$setting->logo}}" alt="Logo" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-gray-200">
                        {{ $setting->name }}
                    </h3>
                </div>
                <div class="space-y-3">
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $setting->address }}
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:{{$setting->hotline}}" class="hover:text-white transition-colors">
                            {{$setting->hotline}}
                        </a>
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Mã số thuế: {{ $setting->mst }}
                    </p>
                </div>

                <!-- Social Links -->
                <div class="pt-4">
                    <p class="mb-3 text-gray-200 font-medium">Kết nối với chúng tôi</p>
                    <div class="flex space-x-4">
                        <a href="{{ $setting->facebook }}"
                           target="_blank"
                           class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                        </a>
                        <a href="{{ $setting->messenger }}" target="_blank"
                           class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <i class="fab fa-facebook-messenger text-xl md:text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Google Maps -->
            <div class="lg:col-span-2 rounded-xl overflow-hidden h-[300px]">
                <iframe src="{{ $setting->google_map }}"
                        class="w-full h-full"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="border-t border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <p class="text-center text-sm">
                © 2024 Phòng Khám Đa Khoa Ngọc Nhân. Tất cả quyền được bảo lưu.
            </p>
        </div>
    </div>
</footer>



