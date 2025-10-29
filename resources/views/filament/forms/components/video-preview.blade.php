@php
    $record = $getRecord();
    $embedUrl = $record?->embed_url;
@endphp

@if ($embedUrl)
    <div class="col-span-2">
        <div class="mt-4">
            <div class="aspect-video rounded-xl overflow-hidden bg-gray-900">
                <iframe
                    class="w-full h-full"
                    src="{{ $embedUrl }}"
                    allowfullscreen
                    loading="lazy"
                ></iframe>
            </div>
            <p class="mt-2 text-sm text-gray-500">
                Xem trước video đang được nhúng trên trang chủ.
            </p>
        </div>
    </div>
@endif
