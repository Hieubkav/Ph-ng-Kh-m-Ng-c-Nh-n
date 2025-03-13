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
        <div class="space-y-3 overflow-y-auto" style="max-height: calc(50vw * 0.66 - 4rem)">
            @foreach($hot_posts as $post)
                <!-- Hot News Item -->
                <div
                    class="bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-300 overflow-hidden h-24">
                    <a href="{{route('post',$post->id)}}" class="flex group">
                        <div class="w-1/3 relative overflow-hidden">
                            <img
                                src="{{config('app.asset_url')}}/storage/{{$post->image}}"
                                alt="{{$post->name}}"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
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
        </div>
    </div>
</div>

