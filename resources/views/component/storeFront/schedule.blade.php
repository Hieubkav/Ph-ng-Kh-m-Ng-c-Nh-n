@php
$activeSchedule = App\Models\Schedule::where('status', 'show')->latest()->first();
@endphp

<!-- Schedule Section -->
<div class="w-full bg-medical-green/5 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Section Title with Pills -->
            <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
                <h2 class="text-3xl font-bold text-medical-green-dark text-center md:text-left">Lịch khám bệnh</h2>
                @if($activeSchedule)
                    <div class="flex gap-3">
                        <!-- Nút tải lịch -->
                        <a href="{{config('app.asset_url')}}/storage/{{$activeSchedule->url_thumbnail}}" 
                           download="lich-kham-benh.jpg"
                           class="inline-flex items-center px-4 py-2 bg-medical-green text-white rounded-lg hover:bg-medical-green-dark transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Tải lịch khám
                        </a>
                        <!-- Nút mở trong tab mới -->
                        <a href="{{config('app.asset_url')}}/storage/{{$activeSchedule->url_thumbnail}}" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-white text-medical-green border-2 border-medical-green rounded-lg hover:bg-medical-green hover:text-white transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Xem toàn màn hình
                        </a>
                    </div>
                @endif
            </div>

            @if($activeSchedule)
                <!-- Schedule Image Container with hover effect -->
                <div class="group relative w-full overflow-hidden rounded-2xl shadow-xl transition-all duration-500 hover:shadow-2xl">
                    <!-- Gradient overlay on hover -->
                    <div class="absolute inset-0 bg-gradient-to-t from-medical-green/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
                    
                    <!-- Main Image -->
                    <img src="{{config('app.asset_url')}}/storage/{{$activeSchedule->url_thumbnail}}"
                         alt="{{ $activeSchedule->title }}"
                         class="w-full h-auto transform transition-transform duration-700 group-hover:scale-105"
                         loading="lazy">

                    <!-- Zoom indicator on hover -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-20">
                        <div class="bg-white/90 p-3 rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <svg class="w-6 h-6 text-medical-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                            </svg>
                        </div>
                    </div>
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

<!-- Image Preview Modal -->
@if($activeSchedule)
<div id="scheduleModal" class="fixed inset-0 z-[9999] hidden" role="dialog" aria-modal="true">
    <!-- Modal Backdrop -->
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="relative w-full max-h-[90vh] overflow-auto bg-transparent rounded-xl">
            <!-- Close button -->
            <button id="closeBtn" class="absolute top-4 right-4 z-50 bg-white/90 p-2 rounded-full shadow-lg hover:bg-white transition-colors">
                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Image -->
            <img src="{{config('app.asset_url')}}/storage/{{$activeSchedule->url_thumbnail}}"
                 alt="{{ $activeSchedule->title }}"
                 class="w-full h-auto rounded-lg shadow-2xl"
                 loading="lazy">
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scheduleImage = document.querySelector('.group');
    const modal = document.getElementById('scheduleModal');
    const closeBtn = document.getElementById('closeBtn');
    let isAnimating = false;

    function openModal() {
        if (isAnimating) return;
        isAnimating = true;
        
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        requestAnimationFrame(() => {
            modal.querySelector('.fixed').classList.add('scale-100', 'opacity-100');
            isAnimating = false;
        });
    }

    function closeModal() {
        if (isAnimating) return;
        isAnimating = true;

        modal.querySelector('.fixed').classList.remove('scale-100', 'opacity-100');
        
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            isAnimating = false;
        }, 200);
    }

    // Event Listeners
    if (scheduleImage && modal) {
        scheduleImage.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        
        // Close on backdrop click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.style.display === 'block') closeModal();
        });
    }
});
</script>
@endif
