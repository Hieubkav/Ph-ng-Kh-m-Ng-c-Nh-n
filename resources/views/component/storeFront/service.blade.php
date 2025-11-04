@php
    $serviceItems = ($services ?? collect())->values();
@endphp

<!-- Service Section -->
<div class="w-full bg-gray-50 py-16">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-bold text-medical-green-dark text-center">
            DỊCH VỤ Y TẾ
        </h2>
        <div class="text-center text-gray-600 mt-2 max-w-2xl mx-auto text-lg">Khám chữa bệnh, điều trị chuyên khoa, xét nghiệm hiện đại nhất</div>
        <div
            class="w-24 h-1 bg-gradient-to-r from-medical-green-light to-medical-green mx-auto my-6 rounded-full"></div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @forelse ($serviceItems as $service)
            <!-- Service Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <!-- Image Container with Better Proportion -->
                <div class="bg-gradient-to-br from-medical-green-light/10 to-medical-green/10 p-8 flex items-center justify-center">
                    <div class="relative">
                        <img src="{{ $service->image_url }}" 
                             alt="{{ $service->name }}" 
                             class="w-24 h-24 object-contain group-hover:scale-110 transition-transform duration-300">
                        <!-- Decorative Circle Background -->
                        <div class="absolute inset-0 bg-white/30 rounded-full blur-xl group-hover:bg-medical-green-light/20 transition-colors duration-300"></div>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-medical-green-dark mb-3 group-hover:text-medical-green transition-colors">
                        {{ $service->name }}
                    </h3>
                    
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
            @empty
                <p class="col-span-full text-center text-gray-500">Hiện tại chưa có dịch vụ để hiển thị.</p>
            @endforelse
        </div>

    </div>
</div>


