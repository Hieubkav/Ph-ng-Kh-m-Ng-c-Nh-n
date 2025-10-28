@php
    $categoryItems = ($catPosts ?? collect())->values();
    $postsPerTab = 3; // Gi?i h?n ch? hi?n th? 3 b�i vi�t
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-medical-green mb-4">
                BÀI VIẾT MỚI NHẤT</h2>
            <div class="text-center text-gray-600 mt-2 max-w-2xl mx-auto text-lg">
                Cập nhật nhanh các hoạt động, sự kiện nổi bật và thông báo quan trọng từ bệnh viện, giúp người đọc nắm bắt thông tin mới nhất một cách kịp thời và chính xác.
            </div>

            <div class="w-24 h-1 bg-gradient-to-r from-medical-green-light to-medical-green mx-auto my-6"></div>
        </div>

        @if($categoryItems->isNotEmpty())
        <!-- Tabs Container -->
        <div class="max-w-6xl mx-auto" x-data="{ activeTab: '{{ $categoryItems->first()?->id }}' }">
            <!-- Tab Headers -->
            <div class="flex flex-wrap justify-center mb-8 gap-4" data-aos="fade-up">
                @foreach($categoryItems as $catPost)
                    <button
                        @click="activeTab = '{{ $catPost->id }}'"
                        :class="{'bg-medical-green text-white': activeTab === '{{ $catPost->id }}', 'bg-gray-200 text-gray-700 hover:bg-gray-300': activeTab !== '{{ $catPost->id }}'}"
                        class="px-6 py-3 rounded-full font-medium transition-all duration-300 text-sm md:text-base">
                        {{ $catPost->name }}
                    </button>
                @endforeach
            </div>

            <!-- Tab Panels -->
            @foreach($categoryItems as $catPost)
                <div x-show="activeTab === '{{ $catPost->id }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(($catPost->posts ?? collect())->take($postsPerTab) as $post)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-transform duration-300 hover:-translate-y-1">
                                <div class="h-52 overflow-hidden">
                                    <div class="w-full h-full relative">
                                        @if($post->image)
                                            <img src="{{config('app.asset_url')}}/storage/{{$post->image}}"
                                                 alt="{{ $post->name }}"
                                                 class="w-full h-full object-cover transition-opacity duration-300"
                                                 onerror="this.src='{{config('app.asset_url')}}/storage/{{$settings->tmp_pic ?? ''}}'">
                                        @else
                                            @if($settings->tmp_pic)
                                                <img src="{{config('app.asset_url')}}/storage/{{$settings->tmp_pic}}"
                                                     alt="Default Image"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-medical-green-light to-medical-green"></div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold mb-2 line-clamp-2">{{ $post->name }}</h3>
                                    <p class="text-gray-600 text-sm line-clamp-3">{{ $post->description }}</p>
                                    <a href="{{ route('post', $post->slug) }}"
                                       class="inline-block mt-4 text-medical-green hover:text-medical-green-dark font-medium">
                                        Xem chi tiết →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-8">
                        <a href="{{ route('catPost', ['id' => $catPost->id]) }}"
                           class="inline-block px-6 py-3 bg-medical-green text-white rounded-full hover:bg-medical-green-dark transition-colors duration-300">
                            Xem tất cả bài viết
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">Hiện tại không có chuyên mục bài viết nào được hiển thị.</p>
        </div>
        @endif
    </div>
</section>

<!-- Alpine.js for tab functionality -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


