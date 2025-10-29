@php
    $page = $page ?? (($id ?? null) ? App\Models\Page::find($id) : null);
@endphp

@if (!$page)
    <div class="max-w-4xl mx-auto px-4 py-16 text-center">
        <h1 class="text-3xl font-bold text-medical-green-dark mb-4">Nội dung đang được cập nhật</h1>
        <p class="text-gray-600 text-lg">Vui lòng quay lại sau để xem thông tin chi tiết từ Phòng Khám Đa Khoa Ngọc Nhân.</p>
    </div>
@else
<article class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <header class="mb-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-bold text-medical-green-dark mb-4">
            {{ $page->name }}
        </h1>
        <div class="w-20 h-1 bg-medical-green mx-auto"></div>
    </header>

    <!-- Featured Image -->
    <div class="rounded-lg overflow-hidden mb-8 shadow-md">
        <img
            src="{{config('app.asset_url')}}/storage/{{$page->image}}"
            alt="{{ $page->name }}"
            class="w-full h-[300px] sm:h-[400px] object-cover"
        >
    </div>

    <!-- Content -->
    <div class="prose prose-lg max-w-none text-gray-700 prose-headings:text-medical-green-dark prose-a:text-medical-green prose-img:rounded-lg prose-img:shadow-md">
        {!! $page->content !!}
    </div>
</article>
@endif
