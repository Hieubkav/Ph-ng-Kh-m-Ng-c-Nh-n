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
                                @if($post->image)
                                    <img src="{{config('app.asset_url')}}/storage/{{$post->image}}"
                                         alt="{{ $post->name }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.parentElement.innerHTML = `<div class='w-full h-full bg-gradient-to-br from-medical-green-light to-medical-green flex items-center justify-center p-4'>
                                            <div class='text-center text-white'>
                                                <div class='flex justify-center items-center mb-3'>
                                                    <svg class='w-12 h-12' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'></path>
                                                    </svg>
                                                </div>
                                                <h4 class='text-lg font-semibold mb-1'>Bài viết mới</h4>
                                                <p class='text-sm opacity-90'>{{ Str::limit($post->name, 50) }}</p>
                                            </div>
                                         </div>`"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-medical-green-light to-medical-green flex items-center justify-center p-4">
                                        <div class="text-center text-white">
                                            <div class="flex justify-center items-center mb-3">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-semibold mb-1">Bài viết mới</h4>
                                            <p class="text-sm opacity-90">{{ Str::limit($post->name, 50) }}</p>
                                        </div>
                                    </div>
                                @endif
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
