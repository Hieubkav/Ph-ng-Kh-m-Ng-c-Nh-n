# Performance Issue: Trang chủ có nhiều điểm nghẽn tốc độ

## Mô tả vấn đề
Trang chủ của website Phòng Khám Ngọc Nhân có một số điểm nghẽn về tốc độ loading và hiệu suất, ảnh hưởng đến trải nghiệm người dùng và SEO.

## Các điểm nghẽn được xác định

### 1. **Thiếu caching database** (Priority: High)
- Tất cả queries trong `MainController::storeFront` được thực hiện trực tiếp mà không cache
- Mỗi lần load trang đều query database: carousels, services, doctors, hotPosts, catPosts, videos
- **Giải pháp đề xuất**: Sử dụng Laravel Cache với TTL 1 giờ

### 2. **Cấu hình AOS không tối ưu** (Priority: Medium)
- AOS được khởi tạo với `once: false` và `mirror: true`
- Gây ra animation lặp lại mỗi lần scroll và scroll ngược
- **Giải pháp**: Đặt `once: true` và `mirror: false`

### 3. **Thiếu lazy loading cho images** (Priority: Medium)
- Images trong component post không có `loading="lazy"`
- Chỉ carousel có lazy loading
- **Giải pháp**: Thêm `loading="lazy"` cho tất cả images

### 4. **JavaScript carousel custom** (Priority: Low)
- Sử dụng JavaScript custom cho carousel thay vì library có sẵn
- Swiper đã có trong dependencies nhưng không sử dụng
- **Giải pháp**: Thay thế bằng Swiper

### 5. **Thiếu gzip compression** (Priority: High)
- Assets không được compress server-side
- **Giải pháp**: Cấu hình gzip/brotli compression

### 6. **Images chưa được tối ưu** (Priority: Medium)
- Không có WebP conversion
- Không có responsive images
- Không sử dụng CDN
- **Giải pháp**: Pipeline tối ưu images

### 7. **Thiếu critical CSS** (Priority: Medium)
- CSS không được inline above-the-fold
- **Giải pháp**: Extract và inline critical CSS

### 8. **Thiếu preload cho resources quan trọng** (Priority: Low)
- Không preload logo, hero images, main bundles
- **Giải pháp**: Thêm `<link rel="preload">`

## Impact
- Slow loading time
- Poor Core Web Vitals scores
- Bad user experience
- Lower SEO ranking

## Steps to reproduce
1. Truy cập trang chủ `/`
2. Sử dụng Lighthouse để đo performance
3. Kiểm tra network tab trong DevTools

## Expected result
- First Contentful Paint < 1.5s
- Largest Contentful Paint < 2.5s
- Cumulative Layout Shift < 0.1
- Total blocking time < 200ms

## Environment
- Laravel 11
- Vite build system
- Dependencies: Alpine.js, AOS, Flowbite, Swiper

## Assignee
TBD

## Labels
performance, frontend, optimization, qa
