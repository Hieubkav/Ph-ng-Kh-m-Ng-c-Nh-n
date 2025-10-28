@php
    $schedule = $activeSchedule ?? null;
@endphp

<!-- Schedule Section -->
<div class="w-full bg-medical-green/5 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Section Title -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-medical-green-dark text-center">LỊCH KHÁM BỆNH</h2>
                <div class="text-center text-gray-600 mt-2 max-w-2xl mx-auto text-lg">{!! $schedule?->description !!}</div>
            </div>
            <div
                class="w-24 h-1 bg-gradient-to-r from-medical-green-light to-medical-green mx-auto mb-6 rounded-full"></div>

            @if($schedule)
                <!-- Schedule Image Container without hover effect -->
                <div class="w-full overflow-hidden rounded-2xl shadow-xl">
                    <!-- Main Image -->
                    <img src="{{config('app.asset_url')}}/storage/{{$schedule->url_thumbnail}}"
                         alt="{{ $schedule->title }}"
                         class="w-full h-auto"
                         loading="lazy">
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center bg-white rounded-2xl shadow-lg p-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-medical-green/10 mb-4">
                        <svg class="w-8 h-8 text-medical-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-medical-green-dark mb-2">Chưa có lịch khám</h3>
                    <p class="text-gray-500">Lịch khám sẽ được cập nhật sớm nhất có thể.</p>
                </div>
            @endif
        </div>
    </div>
</div>
