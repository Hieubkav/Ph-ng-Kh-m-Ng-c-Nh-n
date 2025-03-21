@php

    $carousels = App\Models\Carousel::all();

@endphp

    <!-- Medical Clinic Hero Section with Carousel and Hot News -->
<div class="container mx-auto px-4 mt-5">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main Carousel Section (2/3 width on desktop and tablet) -->
        <div class="md:w-2/3 w-full">
            <div class="relative overflow-hidden rounded-2xl shadow-2xl bg-gray-100" style="padding-bottom: calc(3*6rem + 2*0.75rem + 4rem);">
                <!-- Loading State -->
                <div id="loading-state" class="absolute inset-0 flex items-center justify-center bg-white z-[5]">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 relative">
                            <div class="absolute inset-0 border-4 border-medical-green/30 rounded-full"></div>
                            <div
                                class="absolute inset-0 border-4 border-medical-green border-t-transparent rounded-full animate-spin"></div>
                        </div>
                        <p class="mt-4 text-medical-green font-medium">Đang tải...</p>
                    </div>
                </div>

                <!-- Slides Container -->
                <div id="slides-container" class="absolute inset-0">
                    <!-- Slides -->
                    @foreach($carousels as $index => $carousel)
                        <div class="absolute inset-0 transition-all duration-1000 ease-in-out opacity-0 transform"
                             data-slide="{{ $index }}">
                            <img src="{{config('app.asset_url')}}/storage/{{$carousel->image}}"
                                 alt="{{ $index }}"
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        </div>
                    @endforeach

                    <!-- Navigation Controls -->
                    <button
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-medical-green flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-110 backdrop-blur-sm z-[5] group"
                        id="prev-btn">
                        <svg class="w-6 h-6 transition-transform group-hover:-translate-x-1" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-medical-green flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-110 backdrop-blur-sm z-[5] group"
                        id="next-btn">
                        <svg class="w-6 h-6 transition-transform group-hover:translate-x-1" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-3 z-[5]" id="indicators">
                        @foreach($carousels as $index => $carousel)
                            <button
                                class="w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white transition-all duration-300 hover:scale-125"
                                data-index="{{ $index }}">
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Hot News Section (1/3 width on desktop and tablet) -->
        <div class="md:w-1/3 w-full h-full">
            @include('partials.shop.carousel.hotNew')
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = {
            container: document.getElementById('slides-container'),
            slides: Array.from(document.querySelectorAll('[data-slide]')),
            indicators: Array.from(document.querySelectorAll('#indicators button')),
            prevBtn: document.getElementById('prev-btn'),
            nextBtn: document.getElementById('next-btn'),
            loadingState: document.getElementById('loading-state'),
            currentSlide: 0,
            isTransitioning: false,
            autoPlayInterval: null,
            touchStartX: 0,
            touchEndX: 0,

            init() {
                this.showSlide(0);
                this.setupEventListeners();
                this.startAutoplay();
                this.handleImagesLoading();
            },

            setupEventListeners() {
                this.prevBtn.addEventListener('click', () => this.prevSlide());
                this.nextBtn.addEventListener('click', () => this.nextSlide());

                this.indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => this.showSlide(index));
                });

                this.container.addEventListener('touchstart', (e) => {
                    this.touchStartX = e.touches[0].clientX;
                });

                this.container.addEventListener('touchend', (e) => {
                    this.touchEndX = e.changedTouches[0].clientX;
                    this.handleSwipe();
                });

                // Pause autoplay on hover
                this.container.addEventListener('mouseenter', () => {
                    if (this.autoPlayInterval) clearInterval(this.autoPlayInterval);
                });

                this.container.addEventListener('mouseleave', () => {
                    this.startAutoplay();
                });
            },

            showSlide(index) {
                if (this.isTransitioning) return;
                this.isTransitioning = true;

                // Update slides
                const direction = index > this.currentSlide ? 1 : -1;

                // Current slide animation out
                this.slides[this.currentSlide].style.transform = `translateX(${-direction * 100}%)`;
                this.slides[this.currentSlide].classList.remove('opacity-100');
                this.slides[this.currentSlide].classList.add('opacity-0');
                this.indicators[this.currentSlide].classList.remove('bg-white', 'scale-125');
                this.indicators[this.currentSlide].classList.add('bg-white/50');

                // Next slide animation in
                this.slides[index].style.transform = `translateX(${direction * 100}%)`;
                requestAnimationFrame(() => {
                    this.slides[index].classList.remove('opacity-0');
                    this.slides[index].classList.add('opacity-100');
                    requestAnimationFrame(() => {
                        this.slides[index].style.transform = 'translateX(0)';
                    });
                });

                // Update indicators
                this.indicators[index].classList.remove('bg-white/50');
                this.indicators[index].classList.add('bg-white', 'scale-125');

                // Update current slide
                this.currentSlide = index;

                // Reset transition lock
                setTimeout(() => {
                    this.isTransitioning = false;
                }, 1000);
            },

            nextSlide() {
                const nextIndex = (this.currentSlide + 1) % this.slides.length;
                this.showSlide(nextIndex);
            },

            prevSlide() {
                const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                this.showSlide(prevIndex);
            },

            startAutoplay() {
                if (this.autoPlayInterval) clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = setInterval(() => this.nextSlide(), 5000); // Auto slide every 5 seconds
            },

            handleSwipe() {
                const swipeDistance = this.touchEndX - this.touchStartX;
                const minSwipeDistance = 50;

                if (Math.abs(swipeDistance) > minSwipeDistance) {
                    if (swipeDistance > 0) {
                        this.prevSlide();
                    } else {
                        this.nextSlide();
                    }
                }
            },

            handleImagesLoading() {
                Promise.all(
                    this.slides.map(slide => {
                        const img = slide.querySelector('img');
                        return img.complete ? Promise.resolve() : new Promise(resolve => {
                            img.onload = resolve;
                        });
                    })
                ).then(() => {
                    this.loadingState.classList.add('opacity-0');
                    setTimeout(() => {
                        this.loadingState.style.display = 'none';
                    }, 300);
                });
            }
        };

        slider.init();
    });
</script>
