@php
    $service = $service ?? App\Models\Service::find($id);
    $serviceId = $service?->id ?? $id;
    $servicePosts = $servicePosts ?? App\Models\ServicePost::where('service_id', $serviceId)
        ->orderBy('created_at', 'desc')
        ->get();
    $setting = $settings;
@endphp

@if (!$service)
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h1 class="text-3xl sm:text-4xl font-bold text-medical-green-dark mb-4">Dịch vụ không tồn tại</h1>
        <p class="text-gray-600 text-lg">Vui lòng quay lại sau hoặc liên hệ trực tiếp với phòng khám để được hỗ trợ.</p>
    </div>
@else
<div class="max-w-8 mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Service Header -->
    <div class="text-center mb-12">
        <h1 class="text-3xl sm:text-4xl font-bold text-medical-green-dark mb-4">{{ $service->name }}</h1>
        <div class="w-20 h-1 bg-medical-green mx-auto mb-6"></div>

        @if($service->description)
            <div class="prose max-w-3xl mx-auto mb-8">
                {!! $service->description !!}
            </div>
        @endif
    </div>

    <!-- Service Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @forelse($servicePosts as $post)
            <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group">
                <a href="{{ route('servicePost', ['serviceId' => $service->id, 'slug' => $post->slug]) }}" class="block">
                    <!-- Post Image -->
                    <div class="relative h-48 sm:h-56 overflow-hidden bg-gray-100">
                        @if($post->image && $post->show_image == 'show')
                            <div class="w-full h-full relative">
                                <!-- Fallback UI when image doesn't load -->
                                <div class="absolute inset-0 flex items-center justify-center text-medical-green/80">
                                    @if($settings->tmp_pic)
                                        <img src="{{config('app.asset_url')}}/storage/{{ $settings->tmp_pic }}"
                                             alt="Placeholder image for {{ $post->name }}"
                                             class="w-8 h-8 object-contain">
                                    @else
                                        <img src="{{ asset('images/logo.webp') }}"
                                             alt="Brand mark of {{ config('app.name') }}"
                                             class="w-8 h-8 object-contain">
                                    @endif
                                </div>

                                <!-- Actual image with fade-in effect -->
                                <img src="{{config('app.asset_url')}}/storage/{{ $post->image }}"
                                     alt="{{ $post->name }}"
                                     class="absolute inset-0 w-full h-full object-contain object-center transform group-hover:scale-105 transition-all duration-500 opacity-0"
                                     loading="lazy"
                                     onload="this.classList.remove('opacity-0')"
                                     onerror="this.src='{{config('app.asset_url')}}/storage/{{$settings->tmp_pic ?? ''}}'; this.classList.remove('opacity-0');">
                                <div class="absolute inset-0  "></div>
                            </div>
                        @elseif($settings->tmp_pic)
                            <div class="relative w-full h-full">
                                <!-- Fallback UI when image doesn't load -->
                                <div class="absolute inset-0 flex items-center justify-center text-medical-green/80">
                                    <img src="{{ asset('images/logo.webp') }}"
                                         alt="Brand mark of {{ config('app.name') }}"
                                         class="w-8 h-8 object-contain">
                                </div>

                                <!-- Actual image with fade-in effect -->
                                <img src="{{config('app.asset_url')}}/storage/{{ $settings->tmp_pic }}"
                                     alt="{{ $post->name }}"
                                     class="absolute inset-0 w-full h-full object-contain object-center transform group-hover:scale-105 transition-all duration-500 opacity-0"
                                     loading="lazy"
                                     onload="this.classList.remove('opacity-0')"
                                     onerror="this.classList.add('hidden')">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-50 group-hover:opacity-70 transition-all duration-500 backdrop-blur-[1px]"></div>
                            </div>
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-medical-green-light to-medical-green flex items-center justify-center group-hover:scale-105 transition-all duration-500">
                                <div class="text-white p-4 text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Post Content -->
                    <div class="p-4 sm:p-6">
                        <div class="text-sm text-medical-green mb-2">
                            <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                                {{ $post->created_at->format('d/m/Y') }}
                            </time>
                        </div>

                        <h2 class="text-xl uppercase font-semibold text-gray-800 mb-2 group-hover:text-medical-green-dark transition-colors duration-300 line-clamp-2">
                            {{ $post->name }}
                        </h2>
                        <p class="text-gray-600 line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($post->content), 150) }}
                        </p>

                        <!-- Read More Link -->
                        <div class="flex items-center text-medical-green group-hover:text-medical-green-dark transition-colors duration-300">
                            <span class="text-sm font-medium">Xem chi tiết</span>
                            <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </article>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Chưa có bài viết nào trong dịch vụ này</h2>
                    <p class="text-gray-600">Vui lòng quay lại sau để xem các bài viết mới.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Contact Section -->
    {{-- <div class="mt-16 bg-medical-green-dark text-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-8 md:p-10">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-2/3 mb-6 md:mb-0 md:pr-8">
                    <h2 class="text-2xl font-bold mb-4">Liên hệ tư vấn dịch vụ</h2>
                    <p class="text-white/90 mb-4">Quý khách cần thêm thông tin về dịch vụ, vui lòng liên hệ với chúng tôi:</p>

                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>{{ $setting?->hotline }}</span>
                    </div>

                    @if($setting?->address)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $setting?->address }}</span>
                        </div>
                    @endif
                </div>
                <div class="md:w-1/3 flex flex-col space-y-3">
                    @if($setting?->zalo)
                        <a href="https://zalo.me/{{ $setting?->zalo }}"
                           target="_blank"
                           class="inline-flex items-center justify-center px-4 py-2 bg-white text-medical-green-dark rounded-lg hover:bg-gray-50 transition-colors w-full">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.49 10.272v-.45h1.347v6.322h-.77a.576.576 0 01-.577-.573v.001c0-.315.256-.572.577-.572h.193v-4.728H12.49zm-1.484 2.595c-.29.06-.525.276-.525.574 0 .315.287.572.642.572h.642v-.572c0-.315-.287-.572-.642-.572h-.117zm.642-1.145c.354 0 .641-.257.641-.572v-.572c0-.315-.287-.572-.641-.572h-.642v1.716h.642zm.642 2.292c0 .316-.287.573-.642.573h-.642v1.716h.642c.354 0 .642-.257.642-.572v-1.717zm-2.41-3.437c0 .316-.287.573-.641.573h-.642v1.716h.642c.354 0 .641-.257.641-.572V10.577zm-.641-.573c.354 0 .641-.257.641-.572V8.86c0-.315-.287-.572-.641-.572h-.642v1.716h.642zm-1.925 4.583c0 .315-.287.572-.642.572h-.641v1.145h1.925V9.432h-1.925v1.145h.641c.355 0 .642.257.642.572v3.438z"/>
                            </svg>
                            Chat Zalo với chúng tôi
                        </a>
                    @endif

                    @if($setting?->messenger)
                        <a href="{{ $setting?->messenger }}"
                           target="_blank"
                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors w-full">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.477 2 2 6.145 2 11.257c0 2.89 1.443 5.471 3.695 7.147V22l3.375-1.851c.93.26 1.916.399 2.93.399 5.523 0 10-4.145 10-9.257C22 6.145 17.523 2 12 2z"/>
                            </svg>
                            Chat Messenger
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}
</div>

@endif

