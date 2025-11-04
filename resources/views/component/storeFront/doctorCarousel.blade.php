@php
    $doctorItems = ($doctors ?? collect())->values();
@endphp

<!-- Đội Ngũ Bác Sĩ Section -->
<section class="py-16 bg-gradient-to-br from-medical-green-lightest via-white to-medical-green-lightest">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-medical-green mb-4 uppercase tracking-wide">
                BÁC SĨ CHUYÊN KHOA
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                Đội ngũ bác sĩ giàu kinh nghiệm, tận tâm với người bệnh và thường xuyên cập nhật các phương pháp điều trị tiên tiến.
            </p>

            <div
                class="w-24 h-1 bg-gradient-to-r from-medical-green-light to-medical-green mx-auto mt-6 rounded-full"></div>
        </div>

        <!-- Doctors Slider -->
        <div class="max-w-6xl mx-auto">
            @if($doctorItems->isEmpty())
                <p class="text-center text-gray-500">Hiện tại chưa có thông tin bác sĩ.</p>
            @else
            <div class="swiper doctorsSwiper">
                <div class="swiper-wrapper pb-8">
                    @foreach ($doctorItems as $doctor)
                        <!-- Doctor -->
                        <div class="swiper-slide p-4">
                            <div class="bg-white rounded-2xl overflow-hidden shadow-lg group">
                                <div class="relative overflow-hidden">
                                    <img src="{{config('app.asset_url')}}/storage/{{$doctor->image}}"
                                         alt="{{ $doctor->name }}"
                                         class="w-full h-[280px] object-cover transform group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 "></div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                                        {{ $doctor->name }}
                                    </h3>
                                    <p class="text-medical-green font-medium mb-3">
                                        {!!  $doctor->description !!}
                                    </p>
{{--                                    <div class="text-gray-600 space-y-2">--}}
{{--                                        <p class="flex items-center text-sm">--}}
{{--                                            <span--}}
{{--                                                class="w-4 h-4 bg-medical-green-lightest rounded-full mr-2 flex-shrink-0"></span>--}}
{{--                                            Chuyên khoa Tim mạch--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            @endif
        </div>
    </div>
</section>

<script>


    // Khởi tạo Swiper sau khi DOM load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== 'undefined') {
            const swiper = new Swiper('.doctorsSwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            }
        }
            });
        }
    });
</script>

