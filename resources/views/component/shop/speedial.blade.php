<head>
    <style>
        /* Tạo hiệu ứng lắc qua lắc lại */
        /* Tạo hiệu ứng lắc qua lắc lại */
        /* Tạo hiệu ứng xoay */
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            50% { transform: rotate(0deg); }
            75% { transform: rotate(-15deg); }
            100% { transform: rotate(0deg); }

        }

        /* Áp dụng hiệu ứng cho các icon */
        .speedial-icon {
            animation: rotate 1s infinite linear;
        }
    </style>
</head>

<section class="relative">
    <div class="fixed bottom-8 right-8 z-20 flex flex-col items-center space-y-2">
        <!-- Phone -->
        <a href="tel:0948066514" class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transform transition duration-300 hover:scale-110 hover:shadow-lg hover:rotate-3 animate-shake">
            <i class="fas fa-phone text-xl speedial-icon md:text-2xl"></i>
        </a>

        <!-- Messenger -->
        <a href="https://www.facebook.com/hieu.tranmanh.39589" class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transform transition duration-300 hover:scale-110 hover:shadow-lg hover:rotate-3 animate-shake" target="_blank">
            <i class="fab fa-facebook-messenger speedial-icon text-xl md:text-2xl"></i>
        </a>

        <!-- Zalo -->
        <a href="https://zalo.me/0948066514" class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transform transition duration-300 hover:scale-110 hover:shadow-lg hover:rotate-3 animate-shake" target="_blank">
            <span class="speedial-icon">Zalo</span>
        </a>

        <!-- Scroll to Top -->
        <div onclick="scrollToTop()" class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transform transition duration-300 hover:scale-110 hover:shadow-lg hover:rotate-3 cursor-pointer animate-shake">
            <i class="fas fa-arrow-up text-xl  md:text-2xl"></i>
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
