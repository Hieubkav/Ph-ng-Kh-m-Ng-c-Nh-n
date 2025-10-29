@props(['videos' => collect()])

@php
    $videosCollection = collect($videos);
    $mainVideo = $videosCollection->firstWhere('is_hot', true) ?? $videosCollection->first();
    $sideVideos = $mainVideo
        ? $videosCollection->where('id', '!=', $mainVideo->id)->values()
        : $videosCollection;
    $displayVideos = $sideVideos->take(4);
    $componentId = 'video-section-' . uniqid();
    $mainEmbed = $mainVideo?->embed_url ?? $mainVideo?->youtube_url;
@endphp

@if ($mainVideo && $mainEmbed)
    <section
        id="{{ $componentId }}"
        class="max-w-6xl mx-auto p-6 text-center"
    >
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-medical-green uppercase tracking-wide">
                Video của Phòng Khám Ngọc Nhân
            </h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto text-lg">
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto text-lg">
                Khám phá nhịp sống và hình ảnh nổi bật của phòng khám.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow border border-green-100 overflow-hidden text-left">
            <div class="grid grid-cols-1 lg:grid-cols-3">
                <div class="lg:col-span-2 p-4 border-b lg:border-b-0 lg:border-r border-green-100">
                    <div class="aspect-video w-full rounded-xl overflow-hidden bg-black">
                        <iframe
                            data-role="main-player"
                            class="w-full h-full"
                            src="{{ $mainEmbed }}"
                            title="{{ $mainVideo->title }}"
                            allowfullscreen
                            loading="lazy"
                        ></iframe>
                    </div>

                    <h2
                        data-role="main-title"
                        class="mt-3 text-lg font-semibold text-gray-900"
                    >
                        {{ $mainVideo->title }}
                    </h2>
                </div>

                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-700">Danh sách video</h3>
                        <a
                            href="https://www.youtube.com/@pkngocnhan"
                            target="_blank"
                            rel="noopener"
                            class="text-green-600 text-sm hover:underline"
                        >
                            Xem tất cả
                        </a>
                    </div>

                    <ul class="space-y-3">
                        @foreach ($displayVideos as $video)
                            @php
                                $thumbnail = $video->thumbnail_url
                                    ?? ($video->youtube_id
                                        ? 'https://img.youtube.com/vi/' . $video->youtube_id . '/hqdefault.jpg'
                                        : 'https://placehold.co/320x180?text=Video');
                                $embed = $video->embed_url ?? $video->youtube_url;
                            @endphp

                            @if ($embed)
                                <li
                                    class="flex gap-3 cursor-pointer hover:bg-green-50 p-2 rounded-xl transition"
                                    data-role="video-item"
                                    data-embed="{{ $embed }}"
                                    data-title="{{ $video->title }}"
                                >
                                    <img
                                        src="{{ $thumbnail }}"
                                        class="w-28 h-16 rounded-md object-cover border border-gray-200 flex-shrink-0"
                                        alt="{{ $video->title }}"
                                    >
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 leading-snug line-clamp-2">
                                            {{ $video->title }}
                                        </p>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    @if ($sideVideos->count() > $displayVideos->count())
                        <p class="mt-3 text-xs text-gray-500">
                            * Hiển thị tối đa 4 video phụ. Quản lý danh sách tại trang quản trị.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        (() => {
            const section = document.getElementById(@json($componentId));
            if (!section) {
                return;
            }

            const mainPlayer = section.querySelector('[data-role="main-player"]');
            const mainTitle = section.querySelector('[data-role="main-title"]');
            const items = section.querySelectorAll('[data-role="video-item"]');

            items.forEach((item) => {
                item.addEventListener('click', () => {
                    const embedUrl = item.dataset.embed;
                    const title = item.dataset.title;

                    if (embedUrl && mainPlayer) {
                        mainPlayer.src = embedUrl;
                    }

                    if (title && mainTitle) {
                        mainTitle.textContent = title;
                    }
                });
            });
        })();
    </script>
@endif
