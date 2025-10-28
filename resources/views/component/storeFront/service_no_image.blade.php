@php
    // Sorting services by order_service in ascending order
    $services = App\Models\Service::orderBy('order_service', 'asc')->get();
@endphp

<!-- Service Section - Version Without Images -->
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
            <!-- Service Card Without Image -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border-t-4 border-medical-green"
                 data-aos="fade-up"
                 data-aos-delay="100">
                
                <!-- Icon or Number Section -->
                <div class="p-6">
                    <!-- Medical Icon -->
                    <div class="w-16 h-16 bg-gradient-to-br from-medical-green-light to-medical-green rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-medical-green-dark mb-3 group-hover:text-medical-green transition-colors">
                        {{ $service->name }}
                    </h3>
                    
                    <p class="text-gray-600 mb-4 line-clamp-2">
                        Dịch vụ chuyên nghiệp với đội ngũ bác sĩ giàu kinh nghiệm
                    </p>
                    
                    <a href="{{route('services',$service->id)}}" 
                       class="inline-flex items-center text-medical-green hover:text-medical-green-dark font-medium transition-all duration-300 group-hover:gap-3">
                        <span>Xem chi tiết</span>
                        <svg class="w-5 h-5 ml-2 transition-transform group-hover:translate-x-2" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
