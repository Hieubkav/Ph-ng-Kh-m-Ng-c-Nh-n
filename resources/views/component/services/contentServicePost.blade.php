@php
    /** @var \App\Models\ServicePost $servicePost */
    $servicePost->loadMissing('service');
    $service = $service ?? $servicePost->service;

    // L?y c?c b?i vi?t li�n quan kh�c (c?ng d?ch v?, tr? b?i vi?t hi?n t?i)
    $relatedPosts = \App\Models\ServicePost::query()
        ->where('service_id', $service->id)
        ->where('id', '!=', $servicePost->id)
        ->orderByDesc('created_at')
        ->limit(3)
        ->get();

    // L?y b?i vi?t tru?c v? sau trong c?ng d?ch v?
    $previousPost = \App\Models\ServicePost::query()
        ->where('service_id', $service->id)
        ->where('id', '<', $servicePost->id)
        ->orderByDesc('id')
        ->first();
    $nextPost = \App\Models\ServicePost::query()
        ->where('service_id', $service->id)
        ->where('id', '>', $servicePost->id)
        ->orderBy('id')
        ->first();
    $setting = $settings;
@endphp

<article class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Post Header -->
    <header class="mb-8">
        <!-- Category -->
        <div class="text-center mb-4">
            <a href="{{ route('services', ['id' => $service->id]) }}"
               class="inline-flex items-center text-medical-green hover:text-medical-green-dark transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                {{ $service->name }}
            </a>
        </div>

        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl font-bold text-medical-green-dark mb-4 text-center">
            {{ $servicePost->name }}
        </h1>

        <!-- Metadata -->
        <div class="flex justify-center items-center text-sm text-gray-500 mb-6 space-x-4">
            <time datetime="{{ $servicePost->created_at->format('Y-m-d') }}">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $servicePost->created_at->format('d/m/Y') }}
            </time>
        </div>



        <div class="w-20 h-1 bg-medical-green mx-auto"></div>
    </header>

    <!-- Featured Image -->
    @if($servicePost->show_image === 'show' && $servicePost->image)
        <div class="rounded-lg overflow-hidden mb-8 shadow-lg group">
            <div class="relative w-full h-[400px] sm:h-[600px]">
                <!-- Fallback UI when image doesn't load -->
                <div class="absolute inset-0 flex items-center justify-center text-medical-green/80">
                    @if($settings->tmp_pic)
                        <img src="{{config('app.asset_url')}}/storage/{{ $settings->tmp_pic }}"
                             alt="Default Image"
                             class="w-48 h-48 object-contain">
                    @else
                        <img src="{{ asset('images/logo.webp') }}"
                             alt="Default Post Image"
                             class="w-48 h-48 object-contain">
                    @endif
                </div>

                <!-- Actual image with fade-in effect -->
                <img src="{{config('app.asset_url')}}/storage/{{ $servicePost->image }}"
                     alt="{{ $servicePost->name }}"
                     class="absolute inset-0 w-full h-full object-contain transition-opacity duration-500 opacity-0"
                     loading="lazy"
                     onload="this.classList.remove('opacity-0')"
                     onerror="this.classList.add('hidden')">
                <div class="absolute inset-0 "></div>
            </div>
        </div>
    @endif

    <!-- Content -->
    <div class="lexical-content text-gray-700 mb-12">
        {!! $servicePost->content !!}
    </div>

    @if($servicePost->pdf)
        <!-- PDF Viewer Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-medical-green-dark">Tài liệu PDF</h2>
                <div class="flex space-x-4">
                    <a href="{{config('app.asset_url')}}/storage/{{ $servicePost->pdf }}" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-medical-green text-white rounded-lg hover:bg-medical-green-dark transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Xem trong tab mới
                    </a>
                    <a href="{{config('app.asset_url')}}/storage/{{ $servicePost->pdf }}" download
                        class="inline-flex items-center px-4 py-2 bg-medical-green text-white rounded-lg hover:bg-medical-green-dark transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Tải xuống
                    </a>
                </div>
            </div>
            <iframe src="{{config('app.asset_url')}}/storage/{{ $servicePost->pdf }}" class="w-full h-[600px] border rounded-lg shadow-lg"></iframe>
        </div>
    @endif

    <!-- Post Navigation -->
    <nav class="flex items-center justify-between py-4 mb-12">
        @if($previousPost)
            <a href="{{ route('servicePost', ['serviceId' => $service->id, 'slug' => $previousPost->slug]) }}"
               class="group inline-flex items-center text-sm text-gray-500 hover:text-medical-green transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="line-clamp-1 max-w-[150px]">{{ $previousPost->name }}</span>
            </a>
        @else
            <div></div>
        @endif

        @if($nextPost)
            <a href="{{ route('servicePost', ['serviceId' => $service->id, 'slug' => $nextPost->slug]) }}"
               class="group inline-flex items-center text-sm text-gray-500 hover:text-medical-green transition-colors">
                <span class="line-clamp-1 max-w-[150px]">{{ $nextPost->name }}</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @else
            <div></div>
        @endif
    </nav>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <div class="pt-12">
            <h2 class="text-2xl font-bold text-medical-green-dark mb-6">Dịch Vụ Liên Quan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $relatedPost)
                    <a href="{{ route('servicePost', ['serviceId' => $service->id, 'slug' => $relatedPost->slug]) }}"
                       class="group block bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300">
                        <!-- Post Image -->
                        @if($relatedPost->show_image === 'show' && $relatedPost->image)
                            <div class="relative h-48 overflow-hidden">
                                <!-- Fallback UI -->
                                <div class="absolute inset-0 flex items-center justify-center text-medical-green/80">
                                    @if($settings->tmp_pic)
                                        <img src="{{config('app.asset_url')}}/storage/{{ $settings->tmp_pic }}"
                                             alt="Default Image"
                                             class="w-8 h-8 object-contain">
                                    @else
                                        <img src="{{ asset('images/logo.webp') }}"
                                             alt="Default Post Image"
                                             class="w-8 h-8 object-contain">
                                    @endif
                                </div>

                                <!-- Actual image with fade-in effect -->
                                <img src="{{config('app.asset_url')}}/storage/{{ $relatedPost->image }}"
                                     alt="{{ $relatedPost->name }}"
                                     class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 opacity-0"
                                     loading="lazy"
                                     onload="this.classList.remove('opacity-0')"
                                     onerror="this.classList.add('hidden')">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent group-hover:from-black/50 transition-all duration-300"></div>
                            </div>
                        @endif

                        <!-- Post Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-medical-green-dark transition-colors line-clamp-2 mb-2">
                                {{ $relatedPost->name }}
                            </h3>
                            <div class="text-sm text-gray-500">
                                {{ $relatedPost->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Service Info Card -->
    {{-- <div class="border-t border-gray-200 pt-12 mt-12">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-medical-green-dark mb-4">Về dịch vụ</h3>
                <div class="flex items-center mb-4">
                    <div class="rounded-full h-16 w-16 overflow-hidden mr-4 border border-gray-200 bg-gray-50 flex items-center justify-center">
                        <img src="{{config('app.asset_url')}}/storage/{{ $service->image }}" alt="{{ $service->name }}" class="h-12 w-12 object-contain">
                    </div>
                    <h4 class="text-lg font-medium text-gray-800">{{ $service->name }}</h4>
                </div>
                <div class="prose prose-sm mb-4">
                    {!! Str::limit($service->description, 300) !!}
                </div>
                <a href="{{ route('services', $service->id) }}"
                   class="inline-flex items-center text-medical-green hover:text-medical-green-dark transition-colors font-medium">
                    <span>Xem tất cả bài viết về dịch vụ này</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div> --}}

    <!-- Contact Section -->
    {{-- <div class="mt-8 bg-medical-green-dark text-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Đặt lịch tư vấn dịch vụ</h3>
            <p class="text-white/90 mb-4">Liên hệ với chúng tôi để được tư vấn và đặt lịch khám</p>

            <div class="space-y-3">
                <a href="tel:{{ $setting?->hotline }}"
                   class="flex items-center space-x-2 text-white hover:text-medical-green-light transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span>{{ $setting?->hotline }}</span>
                </a>

                @if($setting?->zalo)
                    <a href="https://zalo.me/{{ $setting?->zalo }}"
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-white text-medical-green-dark rounded-lg hover:bg-gray-50 transition-colors w-full">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.49 10.272v-.45h1.347v6.322h-.77a.576.576 0 01-.577-.573v.001c0-.315.256-.572.577-.572h.193v-4.728H12.49zm-1.484 2.595c-.29.06-.525.276-.525.574 0 .315.287.572.642.572h.642v-.572c0-.315-.287-.572-.642-.572h-.117zm.642-1.145c.354 0 .641-.257.641-.572v-.572c0-.315-.287-.572-.641-.572h-.642v1.716h.642zm.642 2.292c0 .316-.287.573-.642.573h-.642v1.716h.642c.354 0 .642-.257.642-.572v-1.717zm-2.41-3.437c0 .316-.287.573-.641.573h-.642v1.716h.642c.354 0 .641-.257.641-.572V10.577zm-.641-.573c.354 0 .641-.257.641-.572V8.86c0-.315-.287-.572-.641-.572h-.642v1.716h.642zm-1.925 4.583c0 .315-.287.572-.642.572h-.641v1.145h1.925V9.432h-1.925v1.145h.641c.355 0 .642.257.642.572v3.438z"/>
                        </svg>
                        Chat Zalo với chúng tôi
                    </a>
                @endif

                @if($setting?->messenger)
                    <a href="{{ $setting?->messenger }}"
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
    </div> --}}
</article>

