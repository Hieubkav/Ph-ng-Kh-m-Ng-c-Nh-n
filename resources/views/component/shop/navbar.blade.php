<!-- Sub nav -->
@include('partials.shop.navbar.subnav')

@php
    $topLevelPosts = \App\Models\Post::where('parent_id', -1)->orderBy('order')->get();
@endphp

    <!-- Main Navigation -->
<nav class="bg-medical-green backdrop-blur-sm transition-all duration-300 w-full relative text-xl z-50" id="mainNav">
    <div class="container mx-auto px-4">
        <div class="flex justify-between">
            <!-- Mobile menu button -->
            <div class="flex md:hidden">
                <button id="mobileMenuBtn" class="text-white p-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path class="menu-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path class="menu-close hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden md:flex md:items-center md:flex-wrap gap-x-6 gap-y-2 justify-center">
                <a href="{{ route('storeFront') }}" class="py-4 px-2 text-white hover:text-medical-green-light hover:border-b-2 hover:border-medical-green-light transition-all duration-300">
                    Trang chủ
                </a>

                @foreach($topLevelPosts as $post)
                    @if($post->children->isNotEmpty())
                        <!-- Dropdown cho bài viết có con -->
                        <div class="relative group">
                            <button class="py-4 px-2 text-white group-hover:text-medical-green-light hover:border-b-2 hover:border-medical-green-light transition-all duration-300 inline-flex items-center">
                                <span>{{ $post->name }}</span>
                                <svg class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-0 w-48 max-h-[80vh] overflow-y-auto bg-medical-green backdrop-blur-sm rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[9999] scrollbar-thin scrollbar-thumb-medical-green-light scrollbar-track-medical-green">
                                @foreach($post->children as $child)
                                    <a href="{{ route('post', $child->id) }}" class="block px-4 py-2 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Link cho bài viết không có con -->
                        <a href="{{ route('post', $post->id) }}" class="py-4 px-2 text-white hover:text-medical-green-light hover:border-b-2 hover:border-medical-green-light transition-all duration-300">
                            {{ $post->name }}
                        </a>
                    @endif
                @endforeach

{{--                <!-- Các mục bổ sung (nếu cần) -->--}}
{{--                <a href="{{ route('hiring') }}" class="py-4 px-2 text-white hover:text-medical-green-light hover:border-b-2 hover:border-medical-green-light transition-all duration-300">--}}
{{--                    Tuyển dụng--}}
{{--                </a>--}}
{{--                <a href="{{ route('catPost', 1) }}" class="py-4 px-2 text-white hover:text-medical-green-light hover:border-b-2 hover:border-medical-green-light transition-all duration-300">--}}
{{--                    Tin tức sự kiện--}}
{{--                </a>--}}
{{--                <a href="{{ route('catPost', 2) }}" class="py-4 px-2 text-white hover:text-medical-green-light hover:border-b-2 hover:border-medical-green-light transition-all duration-300">--}}
{{--                    An sinh xã hội--}}
{{--                </a>--}}
{{--                <a href="{{ route('page', 6) }}" class="py-4 px-2 text-white hover:text-medical-green-light hover:border-b-2 hover:border-medical-green-light transition-all duration-300">--}}
{{--                    Chi phí khám--}}
{{--                </a>--}}
            </div>
        </div>

        <!-- Mobile menu panel -->
        <div id="mobileMenu" class="hidden md:hidden max-h-[80vh] overflow-y-auto scrollbar-thin scrollbar-thumb-medical-green-light scrollbar-track-medical-green">
            <a href="{{ route('storeFront') }}" class="block py-2 px-4 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">
                Trang chủ
            </a>

            @foreach($topLevelPosts as $post)
                @if($post->children->isNotEmpty())
                    <!-- Mobile Dropdown cho bài viết có con -->
                    <div class="relative mobile-dropdown">
                        <button class="flex justify-between items-center w-full py-2 px-4 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">
                            <span>{{ $post->name }}</span>
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hidden pl-4 mobile-dropdown-content max-h-[60vh] overflow-y-auto">
                            @foreach($post->children as $child)
                                <a href="{{ route('post', $child->id) }}" class="block py-2 px-4 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Link cho bài viết không có con -->
                    <a href="{{ route('post', $post->id) }}" class="block py-2 px-4 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">
                        {{ $post->name }}
                    </a>
                @endif
            @endforeach

{{--            <!-- Các mục bổ sung (nếu cần) -->--}}
{{--            <a href="{{ route('hiring') }}" class="block py-2 px-4 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">--}}
{{--                Tuyển dụng--}}
{{--            </a>--}}
{{--            <a href="{{ route('catPost', 1) }}" class="block py-2 px-4 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">--}}
{{--                Tin tức sự kiện--}}
{{--            </a>--}}
{{--            <a href="{{ route('catPost', 2) }}" class="block py-2 px-4 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">--}}
{{--                An sinh xã hội--}}
{{--            </a>--}}
{{--            <a href="{{ route('page', 6) }}" class="block py-2 px-4 text-white hover:bg-medical-green-light hover:text-white transition-colors duration-300">--}}
{{--                Chi phí khám--}}
{{--            </a>--}}
        </div>
    </div>
</nav>

<!-- Script giữ nguyên -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nav = document.getElementById('mainNav');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuOpen = document.querySelector('.menu-open');
        const menuClose = document.querySelector('.menu-close');
        const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');

        let lastScrollPosition = 0;
        let isScrolling = false;

        // Handle scroll behavior
        window.addEventListener('scroll', () => {
            if (!isScrolling) {
                window.requestAnimationFrame(() => {
                    const currentScrollPosition = window.pageYOffset;

                    if (currentScrollPosition <= 0) {
                        nav.classList.remove('fixed', 'top-0', 'shadow-lg', '-translate-y-full');
                        nav.classList.add('relative');
                    } else {
                        if (currentScrollPosition < lastScrollPosition) {
                            nav.classList.remove('relative', '-translate-y-full');
                            nav.classList.add('fixed', 'top-0', 'shadow-lg', 'z-[9999]');
                        } else {
                            nav.classList.add('-translate-y-full');
                        }
                    }

                    lastScrollPosition = currentScrollPosition;
                    isScrolling = false;
                });
            }
            isScrolling = true;
        });

        // Mobile menu toggle
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            menuOpen.classList.toggle('hidden');
            menuClose.classList.toggle('hidden');

            if (!mobileMenu.classList.contains('hidden')) {
                mobileMenu.style.animation = 'slideDown 0.3s ease-out forwards';
            } else {
                mobileMenu.style.animation = 'slideUp 0.2s ease-in forwards';
            }
        });

        // Mobile dropdowns
        mobileDropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('button');
            const content = dropdown.querySelector('.mobile-dropdown-content');
            const arrow = button.querySelector('svg');

            button.addEventListener('click', () => {
                content.classList.toggle('hidden');
                arrow.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        });
    });

    // Add keyframe animations to stylesheet
    const style = document.createElement('style');
    style.textContent = `
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); }
    }
`;
    document.head.appendChild(style);
</script>
