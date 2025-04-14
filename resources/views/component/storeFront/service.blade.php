@php
    // Sorting services by order_service in ascending order
    $services = App\Models\Service::orderBy('order_service', 'asc')->get();
@endphp

<!-- Service Section -->
<div class="w-full bg-gray-50 py-16">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-bold text-medical-green-dark text-center " data-aos="fade-up">
            DỊCH VỤ Y TẾ
        </h2>
        <div class="text-center text-gray-600 mt-2 max-w-2xl mx-auto text-lg">Khám chữa bệnh, điều trị chuyên khoa, xét nghiệm hiện đại nhất</div>
        <div
            class="w-24 h-1 bg-gradient-to-r from-medical-green-light to-medical-green mx-auto my-6 rounded-full"></div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @foreach ($services as $service)
            <!-- Khám Tổng Quát -->
            <div class="bg-white rounded-2xl shadow-lg p-6 group hover:shadow-xl transition-all duration-300"
                 data-aos="fade-up"
                 data-aos-delay="100">
                <div class="text-medical-green-dark mb-4 group-hover:scale-110 transition-transform duration-300">
                    <img src="{{config('app.asset_url')}}/storage/{{ $service->image }}" alt="{{ $service->name }}" class="w-12 h-12 mx-auto">
                </div>
                <h3 class="text-xl font-semibold text-medical-green-dark mb-3">{{ $service->name }}</h3>
                <a href="{{route('services',$service->id)}}" class="inline-flex items-center text-medical-green hover:text-medical-green-dark transition-colors">
                    <span>Xem chi tiết</span>
                    <svg class="w-5 h-5 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            @endforeach
        </div>

    </div>
</div>


