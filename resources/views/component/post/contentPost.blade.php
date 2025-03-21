@php
$post = App\Models\Post::find($id);
$category = App\Models\CatPost::find($post->cat_post_id);
$relatedPosts = App\Models\Post::where('cat_post_id', $post->cat_post_id)
                             ->where('id', '!=', $post->id)
                             ->take(3)
                             ->get();
// Get previous and next posts in same category
$previousPost = App\Models\Post::where('cat_post_id', $post->cat_post_id)->where('id', '<', $post->id)->orderBy('id', 'desc')->first();
$nextPost = App\Models\Post::where('cat_post_id', $post->cat_post_id)->where('id', '>', $post->id)->orderBy('id', 'asc')->first();
@endphp

<article class="max-w-4xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Post Header -->
    <header class="mb-8">
        <!-- Category -->
        <div class="text-center mb-4">
            <a href="{{ url('/danh-muc/' . $category->id) }}"
               class="inline-flex items-center text-medical-green hover:text-medical-green-dark transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                {{ $category->name }}
            </a>
        </div>

        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl font-bold text-medical-green-dark mb-4 text-center">
            {{ $post->name }}
        </h1>

        <!-- Metadata -->
        <div class="flex justify-center items-center text-sm text-gray-500 mb-6 space-x-4">
            <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $post->created_at->format('d/m/Y') }}
            </time>
        </div>

        <!-- Share buttons -->
        <div class="flex justify-center items-center space-x-4 mb-6">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
            </a>
        </div>

        <div class="w-20 h-1 bg-medical-green mx-auto"></div>
    </header>

    <!-- Featured Image -->
    @if($post->show_image === 'show' && $post->image)
        <div class="rounded-lg overflow-hidden mb-8 shadow-md">
            <img
                src="{{config('app.asset_url')}}/storage/{{$post->image}}"
                alt="{{ $post->name }}"
                class="w-full h-[300px] sm:h-[400px] object-cover"
                loading="lazy"
            >
        </div>
    @endif

    <!-- Content -->
    <div class="prose prose-lg max-w-none text-gray-700 prose-headings:text-medical-green-dark prose-a:text-medical-green prose-img:rounded-lg prose-img:shadow-md prose-img:mx-auto mb-12">
        {!! $post->content !!}
    </div>

    @if($post->pdf)
        <!-- PDF Viewer Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-medical-green-dark">Tài liệu PDF</h2>
                <div class="flex space-x-4">
                    <a href="{{ asset('storage/' . $post->pdf) }}" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-medical-green text-white rounded-lg hover:bg-medical-green-dark transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Xem trong tab mới
                    </a>
                    <a href="{{ asset('storage/' . $post->pdf) }}" download
                        class="inline-flex items-center px-4 py-2 bg-medical-green text-white rounded-lg hover:bg-medical-green-dark transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Tải xuống
                    </a>
                </div>
            </div>
            <iframe src="{{ asset('storage/' . $post->pdf) }}" class="w-full h-[600px] border rounded-lg shadow-lg"></iframe>
        </div>
    @endif

    <!-- Post Navigation -->
    <nav class="flex items-center justify-between border-t border-b border-gray-200 py-4 mb-12">
        @if($previousPost)
            <a href="{{route('post',$previousPost->id)}}"
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
            <a href="{{route('post',$nextPost->id)}}"
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
        <div class="border-t border-gray-200 pt-12">
            <h2 class="text-2xl font-bold text-medical-green-dark mb-6">Bài Viết Liên Quan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $relatedPost)
                    <a href="{{ route('post',$relatedPost->id) }}"
                       class="group block bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all">
                        <!-- Post Image -->
                        @if($relatedPost->show_image === 'show' && $relatedPost->image)
                            <div class="relative h-48 overflow-hidden bg-gray-100">
                                <img
                                    src="{{config('app.asset_url')}}/storage/{{$relatedPost->image}}"
                                    alt="{{ $relatedPost->name }}"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300"
                                    loading="lazy"
                                >
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
</article>
