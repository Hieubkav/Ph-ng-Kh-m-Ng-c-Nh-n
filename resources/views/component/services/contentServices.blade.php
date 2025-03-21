@php
    $service = App\Models\Service::find($id);
@endphp

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Hero Section -->
    <div class="relative rounded-2xl overflow-hidden mb-12 shadow-2xl bg-medical-green-dark">
        <div class="absolute inset-0">
            <img
                src="{{config('app.asset_url')}}/storage/{{$service->image}}"
                alt="{{ $service->name }}"
                class="w-full h-full object-cover opacity-25"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-medical-green-dark/80 to-medical-green-dark/40"></div>
        </div>
        
        <div class="relative py-16 px-8 md:py-24 md:px-12">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 max-w-3xl">
                {{ $service->name }}
            </h1>
            @if($service->short_description)
                <p class="text-lg md:text-xl text-white/90 max-w-2xl">
                    {{ $service->short_description }}
                </p>
            @endif
        </div>
    </div>

    <!-- Content Section -->
    <div class="grid md:grid-cols-12 gap-8">
        <!-- Main Content -->
        <div class="md:col-span-8">
            <article class="prose lg:prose-xl max-w-none">
                {!! $service->description !!}
            </article>
        </div>

        <!-- Sidebar -->
        <div class="md:col-span-4">
            <div class="sticky top-8 space-y-8">
                <!-- Info Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="p-6 space-y-4">
                        <h3 class="text-xl font-semibold text-medical-green-dark">Thông tin dịch vụ</h3>
                        
                        @if($service->price)
                            <div class="flex items-center space-x-2 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Giá từ: {{ number_format($service->price) }}đ</span>
                            </div>
                        @endif

                        @if($service->duration)
                            <div class="flex items-center space-x-2 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Thời gian: {{ $service->duration }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="bg-medical-green-dark text-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 space-y-4">
                        <h3 class="text-xl font-semibold">Đặt lịch ngay</h3>
                        <p class="text-white/90">Liên hệ với chúng tôi để được tư vấn và đặt lịch khám</p>
                        
                        <div class="space-y-3">
                            <a href="tel:{{ \App\Models\Setting::first()?->hotline }}" 
                               class="flex items-center space-x-2 text-white hover:text-medical-green transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>{{ \App\Models\Setting::first()?->hotline }}</span>
                            </a>

                            @if(\App\Models\Setting::first()?->zalo)
                                <a href="https://zalo.me/{{ \App\Models\Setting::first()?->zalo }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-white text-medical-green-dark rounded-lg hover:bg-gray-50 transition-colors w-full">
                                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.49 10.272v-.45h1.347v6.322h-.77a.576.576 0 01-.577-.573v.001c0-.315.256-.572.577-.572h.193v-4.728H12.49zm-1.484 2.595c-.29.06-.525.276-.525.574 0 .315.287.572.642.572h.642v-.572c0-.315-.287-.572-.642-.572h-.117zm.642-1.145c.354 0 .641-.257.641-.572v-.572c0-.315-.287-.572-.641-.572h-.642v1.716h.642zm.642 2.292c0 .316-.287.573-.642.573h-.642v1.716h.642c.354 0 .642-.257.642-.572v-1.717zm-2.41-3.437c0 .316-.287.573-.641.573h-.642v1.716h.642c.354 0 .641-.257.641-.572V10.577zm-.641-.573c.354 0 .641-.257.641-.572V8.86c0-.315-.287-.572-.641-.572h-.642v1.716h.642zm-1.925 4.583c0 .315-.287.572-.642.572h-.641v1.145h1.925V9.432h-1.925v1.145h.641c.355 0 .642.257.642.572v3.438z"/>
                                    </svg>
                                    Chat Zalo với chúng tôi
                                </a>
                            @endif

                            @if(\App\Models\Setting::first()?->messenger)
                                <a href="{{ \App\Models\Setting::first()?->messenger }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors w-full">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.477 2 2 6.145 2 11.257c0 2.89 1.443 5.471 3.695 7.147V22l3.375-1.851c.93.26 1.916.399 2.93.399 5.523 0 10-4.145 10-9.257C22 6.145 17.523 2 12 2z"/>
                                    </svg>
                                    Chat Messenger
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
