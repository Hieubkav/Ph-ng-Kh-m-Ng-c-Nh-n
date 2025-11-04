@php
    $setting = $settings;
@endphp

<footer class="bg-green-500 text-white relative">
    <!-- Top Footer -->
    <div class="container mx-auto px-3 md:px-4 py-1 md:py-1 relative max-w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 md:gap-2 lg:gap-4" style="min-height: 450px">

            <!-- Phần 1: Thông tin phòng khám và Social Media Icons -->
            <div
                class="space-y-4 rounded-xl p-3 sm:p-4 md:p-6 h-full w-full
                        transform transition-all">
                <div class="flex items-center mb-1">
                    <h3 class="text-xl sm:text-[1.4rem] font-bold text-white">
                        {{ $setting->name }}
                    </h3>
                </div>
                <div class="space-y-3">
                    <p class="flex items-start">
                        <svg class="w-5 h-5 mr-0 text-white  shrink-0 mt-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="flex-1 text-[0.95rem]">{{ $setting->address }}</span>
                    </p>

                    <p class="flex items-center">
                        <!-- icon mã số thuế -->
                        <svg class="w-5 h-5 mr-1 text-white shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <a href="tel:{{ $setting->hotline }}" class="hover:text-white transition-colors text-[0.95rem]">
                            Mã số thuế: {{ $setting->mst }}
                        </a>
                    </p>
                    <p class="flex items-center">
                        <!-- icon giấy phép hoạt động -->
                        <svg class="w-5 h-5 mr-1 text-white shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <a href="tel:{{ $setting->hotline }}" class="hover:text-white transition-colors text-[0.95rem]">
                            Giấy phép hoạt động: {{ $setting->giay_phep ?? '00851/VL-GPHĐ' }}
                        </a>
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-white shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 3h5m0 0v5m0-5l-6 6M5 3a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7h.01M15 11h.01M15 15h.01M15 19h.01M11 7h.01M11 11h.01M11 15h.01M11 19h.01M7 11h.01M7 15h.01M7 19h.01">
                            </path>
                        </svg>
                        <a href="tel:{{ $setting->telephone }}" class="hover:text-white transition-colors text-[0.95rem]">
                            Số điện thoại: {{ $setting->telephone ?? '02923 777 999' }}
                        </a>
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-white shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <a href="tel:{{ $setting->hotline }}" class="hover:text-white transition-colors text-[0.95rem]">
                            Di động/Zalo: {{ $setting->hotline }}
                        </a>
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-white shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <a href="tel:{{ $setting->hotline }}" class="hover:text-white transition-colors text-[0.95rem]">
                            Email: {{ $setting->email }}
                        </a>
                    </p>
                </div>

                <!-- Social Media Icons -->
                <div class="flex items-center justify-start gap-4 mt-6">
                    <!-- Facebook Icon -->
                    <a href="https://www.facebook.com/phongkhamdakhoangocnhan" target="_blank" rel="noopener noreferrer"
                        class="bg-white p-0 rounded-full shadow-lg 
                               transform hover:scale-110 transition-all duration-300
                               hover:shadow-[0_0_15px_rgba(59,130,246,0.5)]
                               flex items-center justify-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/2023_Facebook_icon.svg/1024px-2023_Facebook_icon.svg.png"
                        alt="Facebook" class="w-10 h-10" loading="lazy" />
                    </a>

                    <!-- Zalo Icon -->
                    <a href="https://zalo.me/{{ str_replace(' ', '', $setting->hotline) }}" target="_blank"
                        rel="noopener noreferrer"
                        class="bg-white p-0 rounded-full shadow-lg 
                               transform hover:scale-110 transition-all duration-300
                               hover:shadow-[0_0_15px_rgba(59,130,246,0.5)]
                               flex items-center justify-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Icon_of_Zalo.svg/2048px-Icon_of_Zalo.svg.png"
                        alt="Zalo" class="w-10 h-10" loading="lazy" />
                    </a>
                </div>
            </div>

            <!-- Phần 2: Facebook Fanpage -->
            <div
                class="relative overflow-hidden rounded-xl md:col-span-2 lg:col-span-1
                        p-3 sm:p-4 md:p-6 h-full w-full">
                <h3 class="text-xl sm:text-2xl font-bold text-white mb-2 sm:mb-4 flex items-center gap-2">
                    {{-- <i class="fab fa-facebook text-blue-400"></i>
                    Fanpage --}}
                </h3>
                <div class="relative w-full h-[350px] xs:h-[400px] sm:h-[420px] md:h-[calc(100%-3rem)] min-h-[350px]">
                    <iframe
                        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fphongkhamdakhoangocnhan&tabs=timeline&width=500&height=400&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true"
                        class="w-full h-full rounded-lg" style="border:none;overflow:hidden" scrolling="no"
                        allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                    </iframe>
                </div>
            </div>

            <!-- Phần 3: Google Maps -->
            <div
                class="rounded-xl overflow-hidden p-3 sm:p-4 md:p-6 h-full w-full
                        transform transition-all duration-500">
                <h3 class="text-xl sm:text-2xl font-bold text-white mb-2 sm:mb-4 flex items-center gap-2">
                    {{-- <i class="fas fa-map-marker-alt text-red-400"></i>
                    Bản đồ --}}
                </h3>
                <div
                    class="h-[350px] xs:h-[400px] sm:h-[420px] md:h-[calc(100%-3rem)] min-h-[350px] rounded-lg overflow-hidden">
                    <iframe
                        src="{{ $setting->google_map ? $setting->google_map . '&mode=streets' : 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15675.274533554673!2d106.68522829999999!3d10.822147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1683907656882!5m2!1svi!2s' }}"
                        class="w-full h-full" style="border:0;filter:contrast(1.1)" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class=" bg-green-600 text-white">
        <div class="container mx-auto px-4 py-4">
            <p class="text-center text-sm text-white">
                © 2025 Phòng Khám Đa Khoa Ngọc Nhân. Tất cả quyền được bảo lưu.
            </p>
        </div>
    </div>
</footer>

