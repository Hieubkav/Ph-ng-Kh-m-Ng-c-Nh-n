@php
    $setting = $settings;
@endphp

@push('head')
    <style>
        /* Tạo hiệu ứng lắc qua lắc lại */
        /* Tạo hiệu ứng lắc qua lắc lại */
        /* Tạo hiệu ứng xoay */
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(15deg);
            }
            50% {
                transform: rotate(0deg);
            }
            75% {
                transform: rotate(-15deg);
            }
            100% {
                transform: rotate(0deg);
            }

        }

        /* Áp dụng hiệu ứng cho các icon */
        .speedial-icon {
            animation: rotate 1s infinite linear;
        }
    </style>
@endpush

<section class="relative">
    <div class="fixed bottom-8 right-8 z-20 flex flex-col items-center space-y-2">
        <!-- Phone -->
        <a href="tel:{{ $setting->hotline }}"
           class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transform transition duration-300 hover:scale-110 hover:shadow-lg hover:rotate-3 animate-shake">
            <svg class="speedial-icon w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.35 1.77.69 2.6a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.48-1.26a2 2 0 0 1 2.11-.45c.83.34 1.7.57 2.6.69a2 2 0 0 1 1.72 2.03Z" />
            </svg>
        </a>

        <!-- Messenger -->
        <a href="{{ $setting->messenger }}"
           class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transform transition duration-300 hover:scale-110 hover:shadow-lg hover:rotate-3 animate-shake"
           target="_blank">
            <svg class="speedial-icon w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 2C6.48 2 2 6.05 2 11.05c0 2.85 1.47 5.42 3.85 7.1V22l3.52-1.93c.84.23 1.72.35 2.63.35 5.52 0 10-4.05 10-9.05S17.52 2 12 2Zm1.1 12.4-2.55-2.72-5.03 2.72 5.53-5.88 2.52 2.72 4.98-2.72-5.45 5.88Z" />
            </svg>
        </a>

        <!-- Zalo -->
        <a href="https://zalo.me/{{ $setting->zalo }}"
           class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transform transition duration-300 hover:scale-110 hover:shadow-lg hover:rotate-3 animate-shake"
           target="_blank">
            <span class="speedial-icon">Zalo</span>
        </a>

        <!-- Scroll to Top -->
        <div onclick="scrollToTop()"
             class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transform transition duration-300 hover:scale-110 hover:shadow-lg hover:rotate-3 cursor-pointer animate-shake">
            <svg class="speedial-icon w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 19V5" />
                <path d="m5 12 7-7 7 7" />
            </svg>
        </div>
    </div>
</section>

<script>
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

