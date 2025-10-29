// Import và export các thư viện bên thứ ba
import Alpine from 'alpinejs';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

// Khởi tạo Alpine
window.Alpine = Alpine;
Alpine.start();

// Export Swiper để sử dụng global
window.Swiper = Swiper;
