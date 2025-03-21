@php
    // Lấy ra các bài viết nổi bật
    $hot_posts = App\Models\Post::where('is_hot', 'hot')->orderBy('created_at', 'desc')->get();
@endphp

<!-- Hot News Section -->
<div class="h-full flex flex-col bg-white/50 rounded-2xl p-4">
    <h3 class="text-xl font-bold text-medical-green-dark mb-4 border-b-2 border-medical-green pb-2">
        Tin tức nổi bật
    </h3>

    <div class="space-y-3 flex-grow flex flex-col justify-between">
        <!-- Hot News Items Container - Equal height distribution -->
        <div class="space-y-3 relative overflow-hidden md:max-h-[calc(3*6rem+2*0.75rem)] max-h-[calc(3*6rem)]">
            <div class="news-container {{ count($hot_posts) > 3 ? 'animate-scroll' : '' }}">
                @foreach($hot_posts as $post)
                    <!-- Hot News Item -->
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-300 overflow-hidden h-24 mb-3">
                        <a href="{{route('post',$post->id)}}" class="flex group">
                            <div class="w-1/3 relative overflow-hidden bg-medical-green/5">
                                <!-- Fallback UI khi ảnh không load được -->
                                <div class="absolute inset-0 flex items-center justify-center text-medical-green/80">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <!-- Actual image with fade-in effect -->
                                <img src="{{config('app.asset_url')}}/storage/{{$post->image}}"
                                    alt="{{$post->name}}"
                                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-all duration-500 opacity-0 hover:opacity-100"
                                    onload="this.classList.remove('opacity-0')"
                                    onerror="this.classList.add('hidden')">
                            </div>
                            <div class="w-2/3 p-2">
                                <div class="flex items-center text-xs text-gray-500 mb-1 space-x-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $post->created_at }}</span>
                                </div>
                                <h4 class="font-semibold text-medical-green-dark text-sm mb-1 line-clamp-2 group-hover:text-medical-green transition-colors">
                                    {{$post->name}}
                                </h4>
                            </div>
                        </a>
                    </div>
                @endforeach

                @if(count($hot_posts) > 3)
                    @foreach($hot_posts->take(3) as $post)
                        <!-- Clone of first 3 items for smooth infinite scroll -->
                        <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-300 overflow-hidden h-24 mb-3">
                            <a href="{{route('post',$post->id)}}" class="flex group">
                                <div class="w-1/3 relative overflow-hidden bg-medical-green/5">
                                    <!-- Fallback UI khi ảnh không load được -->
                                    <div class="absolute inset-0 flex items-center justify-center text-medical-green/80">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <!-- Actual image with fade-in effect -->
                                    <img src="{{config('app.asset_url')}}/storage/{{$post->image}}"
                                        alt="{{$post->name}}"
                                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-all duration-500 opacity-0 hover:opacity-100"
                                        onload="this.classList.remove('opacity-0')"
                                        onerror="this.classList.add('hidden')">
                                </div>
                                <div class="w-2/3 p-2">
                                    <div class="flex items-center text-xs text-gray-500 mb-1 space-x-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ $post->created_at }}</span>
                                    </div>
                                    <h4 class="font-semibold text-medical-green-dark text-sm mb-1 line-clamp-2 group-hover:text-medical-green transition-colors">
                                        {{$post->name}}
                                    </h4>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@if(count($hot_posts) > 3)
    <style>
        @keyframes scrollNews {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(calc(-100% + 288px)); /* 3 items height: 3 * 96px */
            }
        }

        .animate-scroll {
            animation: scrollNews 30s linear infinite;
            animation-play-state: running;
        }

        .animate-scroll:hover {
            animation-play-state: paused;
        }

        .news-container {
            will-change: transform;
        }

        @media (max-width: 768px) {
            .animate-scroll {
                animation-duration: 20s; /* Tăng tốc độ cuộn trên mobile */
            }
        }
    </style>
@endif
