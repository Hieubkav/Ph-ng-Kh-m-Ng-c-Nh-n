@php
    $service = App\Models\Service::find($id);
@endphp

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">{{ $service->name }}</h1>

    <div class="mb-8">
        <img
            src="{{config('app.asset_url')}}/storage/{{$service->image}}"
            alt="{{ $service->name }}"
            class="w-full h-auto rounded-lg shadow-lg object-cover max-h-[500px]"
        />
    </div>

    <article class="prose lg:prose-xl max-w-none">
        {!! $service->description !!}
    </article>
</div>
