@php
    $setting = \App\Models\Setting::first();
@endphp

<footer class="bg-green-600 text-white">
    <!-- Top Footer -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Thông tin phòng khám và QR Codes -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3 mb-1">
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
                </div>

                <!-- QR Codes -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <!-- Facebook QR -->
                    <div class="bg-white p-3 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <div class="aspect-square relative">
                            <img src="{{asset('images/fb_qr.png')}}" 
                                 alt="Facebook QR Code" 
                                 class="w-full h-full object-contain rounded-lg">
                            <div class="absolute bottom-0 left-0 right-0 bg-blue-600 text-white text-center py-1 text-xs rounded-b-lg">
                                Facebook
                            </div>
                        </div>
                    </div>
                    
                    <!-- Zalo QR -->
                    <div class="bg-white p-3 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <div class="aspect-square relative">
                            <img src="{{asset('images/zalo_qr.png')}}" 
                                 alt="Zalo QR Code" 
                                 class="w-full h-full object-contain rounded-lg">
                            <div class="absolute bottom-0 left-0 right-0 bg-blue-500 text-white text-center py-1 text-xs rounded-b-lg">
                                Zalo
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instruction Text -->
                <p class="text-sm text-white/90 text-center mt-2">
                    Quét mã QR để kết nối nhanh
                </p>
            </div>

            <!-- Facebook Fanpage -->
            <div class="rounded-xl overflow-hidden h-[300px] bg-white">
                <div class="fb-page w-full h-full" 
                     data-href="{{ $setting->facebook }}"
                     data-tabs="timeline"
                     data-width="500"
                     data-height="300"
                     data-small-header="false"
                     data-adapt-container-width="true"
                     data-hide-cover="false"
                     data-show-facepile="true">
                    <blockquote cite="{{ $setting->facebook }}" class="fb-xfbml-parse-ignore">
                        <a href="{{ $setting->facebook }}">{{ $setting->name }}</a>
                    </blockquote>
                </div>
            </div>

            <!-- Google Maps -->
            <div class="rounded-xl overflow-hidden h-[300px]">
                <iframe src="{{ $setting->google_map ? $setting->google_map . '&mode=streets' : 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15675.274533554673!2d106.68522829999999!3d10.822147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1683907656882!5m2!1svi!2s' }}"
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
                © 2025 Phòng Khám Đa Khoa Ngọc Nhân. Tất cả quyền được bảo lưu.
            </p>
        </div>
    </div>
</footer>

<!-- Facebook SDK -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" 
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0" 
        nonce="random_nonce">
</script>
