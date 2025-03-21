@php
    $catPosts = App\Models\CatPost::all();
    $postsPerPage = 3; // Giới hạn chỉ hiển thị 3 bài viết
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-medical-green mb-4">Bài viết mới nhất</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-medical-green-light to-medical-green mx-auto"></div>
        </div>

        <!-- Tabs Container -->
        <div class="max-w-6xl mx-auto" x-data="{ activeTab: '{{ $catPosts->first()?->id }}' }">
            <!-- Tab Headers -->
            <div class="flex flex-wrap justify-center mb-8 gap-4" data-aos="fade-up">
                @foreach($catPosts as $catPost)
                    <button
                        @click="activeTab = '{{ $catPost->id }}'"
                        :class="{'bg-medical-green text-white': activeTab === '{{ $catPost->id }}', 'bg-gray-200 text-gray-700 hover:bg-gray-300': activeTab !== '{{ $catPost->id }}'}"
                        class="px-6 py-3 rounded-full font-medium transition-all duration-300 text-sm md:text-base">
                        {{ $catPost->name }}
                    </button>
                @endforeach
            </div>

            <!-- Tab Panels -->
            @foreach($catPosts as $catPost)
                <div x-show="activeTab === '{{ $catPost->id }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($catPost->posts->take($postsPerPage) as $post)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-transform duration-300 hover:-translate-y-1">
                            <div class="aspect-w-16 aspect-h-9">
                                @if($post->image && Storage::exists('public/' . $post->image))
                                    <img src="{{config('app.asset_url')}}/storage/{{$post->image}}"
                                         alt="{{ $post->name }}"
                                         class="w-full h-full object-cover"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-medical-green-light to-medical-green flex items-center justify-center">
                                        <div class="text-center text-white p-4">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">{{ Str::limit($post->name, 30) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-2 line-clamp-2">{{ $post->name }}</h3>
                                <p class="text-gray-600 text-sm line-clamp-3">{{ $post->description }}</p>
                                <a href="{{ route('post', ['id' => $post->id]) }}"
                                   class="inline-block mt-4 text-medical-green hover:text-medical-green-dark font-medium">
                                    Xem chi tiết →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($catPost->posts->count() > $postsPerPage)
                    <div class="text-center mt-8">
                        <a href="{{ route('catPost', ['id' => $catPost->id]) }}"
                           class="inline-block px-6 py-3 bg-medical-green text-white rounded-full hover:bg-medical-green-dark transition-colors duration-300">
                            Xem tất cả bài viết
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Alpine.js for tab functionality -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
