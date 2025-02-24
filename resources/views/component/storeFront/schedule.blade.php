@php

$setting = App\Models\Setting::first();

    @endphp

<!-- Schedule Section -->
<div class="w-full bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Section Title -->
            <h2 class="text-3xl font-bold text-medical-green-dark text-center mb-8">Lịch khám bệnh</h2>

            <!-- Schedule Image Container -->
            <div class="relative w-full overflow-hidden rounded-2xl shadow-lg cursor-pointer transition-transform duration-300 hover:scale-[1.02]" id="scheduleImage">
                <img src="{{config('app.asset_url')}}/storage/{{$setting->image_schedule}}"
                     alt="Lịch khám bệnh"
                     class="w-full h-auto"
                     loading="lazy">
            </div>
        </div>
    </div>
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" class="fixed inset-0 z-[9999] hidden">
    <!-- Modal Backdrop -->
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="relative max-w-7xl w-full mx-auto bg-white rounded-2xl shadow-2xl">
            <!-- Modal Header -->
            <div class="absolute top-4 right-4 flex items-center space-x-2">
                <!-- Close (X) Button -->
                <button id="closeXBtn" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Image Container -->
            <div class="p-4">
                <img src="{{ asset('images/schedule.webp') }}"
                     alt="Lịch khám bệnh"
                     class="w-full h-auto rounded-lg"
                     loading="lazy">
            </div>

            <!-- Modal Footer -->
            <div class="p-4 border-t border-gray-200 flex justify-end">
                <button id="closeBtn" class="px-6 py-2 bg-medical-green hover:bg-medical-green-dark text-white rounded-lg transition-colors">
                    Đóng
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scheduleImage = document.getElementById('scheduleImage');
    const modal = document.getElementById('scheduleModal');
    const closeBtn = document.getElementById('closeBtn');
    const closeXBtn = document.getElementById('closeXBtn');
    let isAnimating = false;

    // Open modal with fade animation
    function openModal() {
        if (isAnimating) return;
        isAnimating = true;

        modal.style.display = 'block';
        // Force reflow
        modal.offsetHeight;
        modal.classList.add('animate-fadeIn');

        // Lock body scroll
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            isAnimating = false;
        }, 300);
    }

    // Close modal with fade animation
    function closeModal() {
        if (isAnimating) return;
        isAnimating = true;

        modal.classList.add('animate-fadeOut');

        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.remove('animate-fadeIn', 'animate-fadeOut');
            document.body.style.overflow = '';
            isAnimating = false;
        }, 300);
    }

    // Event Listeners
    scheduleImage.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    closeXBtn.addEventListener('click', closeModal);

    // Close on backdrop click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
});

// Add keyframe animations to stylesheet
const style = document.createElement('style');
style.textContent = `
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .animate-fadeOut {
        animation: fadeOut 0.3s ease-in forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes fadeOut {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0; transform: scale(0.95); }
    }
`;
document.head.appendChild(style);
</script>
