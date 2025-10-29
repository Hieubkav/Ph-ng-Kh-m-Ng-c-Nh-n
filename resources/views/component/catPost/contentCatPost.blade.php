@php

$catPost = App\Models\CatPost::find($id);

$listPost = App\Models\Post::where('cat_post_id', $catPost->id)
    ->orderBy('created_at', 'desc')
    ->get();

@endphp

<div class="max-w-8 mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Category Header -->
    <div class="text-center mb-12">
        <h1 class="text-3xl sm:text-4xl font-bold text-medical-green-dark mb-4">{{ $catPost->name }}</h1>
        <div class="w-20 h-1 bg-medical-green mx-auto mb-6"></div>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @forelse($listPost as $post)
            <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group">
                <a href="{{ route('post', $post->slug) }}" class="block">
                    <!-- Post Image -->
                    <div class="relative h-48 sm:h-56 overflow-hidden bg-gray-100">
                        @if($post->image)
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
                                <div class="absolute inset-0  group-hover:opacity-100 transition-all "></div>
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
                            <span class="text-sm font-medium">Xem thêm</span>
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
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Chưa có bài viết nào trong danh mục này</h2>
                    <p class="text-gray-600">Vui lòng quay lại sau để xem các bài viết mới.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
