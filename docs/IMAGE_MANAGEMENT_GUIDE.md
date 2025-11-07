# 📸 Hướng dẫn quản lý ảnh tự động với Observer

## 🎯 Tổng quan

Hệ thống quản lý ảnh tự động giúp:
- ✅ Xóa ảnh cũ khi upload ảnh mới
- ✅ Xóa tất cả ảnh khi xóa bài viết
- ✅ Xóa ảnh trong content editor khi không còn sử dụng
- ✅ Tránh rác trong storage

## 📦 Cấu trúc lưu trữ

### Bảng `posts`:
```
- id: bigint
- name: string
- content: text (HTML từ TipTap Editor)
- image: string (path: uploads/filename.jpg)
- pdf: string (path: uploads/filename.pdf)
- ...
```

### Bảng `service_posts`:
```
- id: bigint
- name: string
- content: text (HTML từ TipTap Editor)
- image: string (path: uploads/filename.jpg)
- pdf: string (path: uploads/filename.pdf)
- ...
```

### Storage paths:
- **Ảnh chính**: `storage/app/public/uploads/`
- **Ảnh trong Post content**: `storage/app/public/uploads/content/`
- **Ảnh trong ServicePost content**: `storage/app/public/uploads/service-content/`
- **PDF files**: `storage/app/public/uploads/`

## 🔍 Observer hoạt động như thế nào?

### PostObserver

#### 1. **Creating Event** (Khi tạo mới)
```php
public function creating(Post $post): void
{
    // Tự động tạo slug từ tên bài viết
    if (empty($post->slug)) {
        $post->slug = \Str::slug($post->name);
    }
}
```

#### 2. **Updating Event** (Khi cập nhật)
```php
public function updating(Post $post): void
{
    $oldPost = Post::find($post->id);
    
    // Xóa ảnh chính cũ nếu có ảnh mới
    if ($post->image !== $oldPost->image) {
        $this->deleteOldImage($oldPost->image);
    }
    
    // Xóa PDF cũ nếu có PDF mới
    if ($post->pdf !== $oldPost->pdf) {
        $this->deleteOldImage($oldPost->pdf);
    }
    
    // Xóa ảnh trong content không còn dùng
    $this->handleContentImages($oldPost->content, $post->content);
}
```

#### 3. **Deleted Event** (Khi xóa bài viết)
```php
public function deleted(Post $post): void
{
    // Xóa ảnh chính
    if ($post->image) {
        $this->deleteOldImage($post->image);
    }
    
    // Xóa PDF
    if ($post->pdf) {
        $this->deleteOldImage($post->pdf);
    }
    
    // Xóa tất cả ảnh trong content
    $this->deleteContentImages($post->content);
}
```

### ServicePostObserver

Hoạt động tương tự như PostObserver nhưng cho bảng `service_posts`.

## 🛠️ Các tình huống xử lý

### Tình huống 1: Upload ảnh mới thay thế ảnh cũ

**Trước:**
```
Post ID 1:
- image: uploads/old-photo.jpg (tồn tại trong storage)
```

**Sau khi upload ảnh mới:**
```
Post ID 1:
- image: uploads/new-photo.jpg

Observer tự động:
✅ Xóa uploads/old-photo.jpg
✅ Giữ uploads/new-photo.jpg
```

### Tình huống 2: Xóa ảnh khỏi content editor

**Trước:**
```
Post content:
<img src="/storage/uploads/content/image1.jpg">
<img src="/storage/uploads/content/image2.jpg">
```

**Sau khi xóa image1 khỏi editor:**
```
Post content:
<img src="/storage/uploads/content/image2.jpg">

Observer tự động:
✅ Xóa uploads/content/image1.jpg
✅ Giữ uploads/content/image2.jpg
```

### Tình huống 3: Xóa bài viết

**Trước:**
```
Post ID 1:
- image: uploads/photo.jpg
- pdf: uploads/document.pdf
- content: <img src="/storage/uploads/content/img1.jpg">
           <img src="/storage/uploads/content/img2.jpg">
```

**Sau khi xóa bài viết:**
```
Observer tự động xóa:
✅ uploads/photo.jpg
✅ uploads/document.pdf
✅ uploads/content/img1.jpg
✅ uploads/content/img2.jpg
```

## 🧹 Command dọn dẹp ảnh không sử dụng

### Sử dụng Command

#### 1. **Dry Run** (Xem trước, không xóa thật)
```bash
php artisan images:clean-unused --dry-run
```

Output:
```
🔍 Đang quét các file ảnh không sử dụng...
⚠️  CHẾ ĐỘ DRY RUN - Không xóa file thực tế
📊 Tìm thấy 50 ảnh đang được sử dụng trong database
📦 Tìm thấy 75 file trong storage
🗑️  Tìm thấy 25 file không sử dụng
💾 Tổng dung lượng: 15.5 MB

📋 Danh sách file sẽ xóa:
  - uploads/old-image-1.jpg (500 KB)
  - uploads/old-image-2.jpg (800 KB)
  - uploads/content/unused-1.jpg (1.2 MB)
  ...
```

#### 2. **Xóa thật sự**
```bash
php artisan images:clean-unused
```

Output:
```
🔍 Đang quét các file ảnh không sử dụng...
📊 Tìm thấy 50 ảnh đang được sử dụng trong database
📦 Tìm thấy 75 file trong storage
🗑️  Tìm thấy 25 file không sử dụng
💾 Tổng dung lượng: 15.5 MB

Bạn có chắc muốn xóa 25 file này? (yes/no): yes

[████████████████████████████] 100%

✅ Đã xóa 25 file (15.5 MB)
```

### Khi nào nên chạy Command?

- **Hàng tuần**: Để dọn dẹp ảnh rác định kỳ
- **Sau khi migrate data**: Khi có dữ liệu cũ không còn sử dụng
- **Khi storage đầy**: Giải phóng không gian

### Tự động hóa với Cron Job

Thêm vào `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Chạy mỗi tuần vào Chủ nhật 2h sáng
    $schedule->command('images:clean-unused')
        ->weekly()
        ->sundays()
        ->at('02:00')
        ->emailOutputOnFailure('admin@example.com');
}
```

## 📋 Logs và Tracking

Observer tự động ghi log mọi thao tác:

```
[2025-11-07 08:30:15] local.INFO: Deleted old image for Post ID 5: uploads/old-photo.jpg
[2025-11-07 08:30:15] local.INFO: Deleted unused content image: uploads/content/unused.jpg
[2025-11-07 08:35:20] local.INFO: Deleted image for deleted Post ID 10: uploads/photo.jpg
```

Xem logs tại: `storage/logs/laravel.log`

## ⚠️ Lưu ý quan trọng

### 1. **Không xóa ảnh ngoài thư mục uploads/**
Observer chỉ xóa ảnh trong:
- `uploads/`
- `uploads/content/`
- `uploads/service-content/`

Ảnh trong thư mục khác (public/, assets/...) không bị ảnh hưởng.

### 2. **Backup trước khi dọn dẹp**
Luôn backup storage trước khi chạy command xóa:
```bash
# Backup storage
cp -r storage/app/public/uploads storage/app/public/uploads_backup_$(date +%Y%m%d)

# Hoặc tạo zip
zip -r uploads_backup_$(date +%Y%m%d).zip storage/app/public/uploads
```

### 3. **Test với --dry-run trước**
Luôn chạy với `--dry-run` để xem trước:
```bash
php artisan images:clean-unused --dry-run
```

### 4. **Observer đã được đăng ký**
Observers đã được đăng ký tự động trong `EventServiceProvider`:
```php
public function boot(): void
{
    Post::observe(PostObserver::class);
    ServicePost::observe(ServicePostObserver::class);
}
```

## 🐛 Troubleshooting

### Vấn đề 1: Observer không chạy

**Giải pháp:**
```bash
# Clear cache
php artisan optimize:clear

# Kiểm tra Observer đã đăng ký
php artisan tinker
>>> Post::getObservableEvents()
```

### Vấn đề 2: File không được xóa

**Nguyên nhân:**
- Không có quyền ghi vào storage
- File đang được sử dụng

**Giải pháp:**
```bash
# Cấp quyền cho storage
chmod -R 775 storage/app/public/

# Kiểm tra file ownership
ls -la storage/app/public/uploads/
```

### Vấn đề 3: Xóa nhầm ảnh đang dùng

**Phòng tránh:**
- Luôn test với `--dry-run` trước
- Backup storage định kỳ
- Kiểm tra logs trước khi xóa

**Khôi phục:**
```bash
# Restore từ backup
cp -r storage/app/public/uploads_backup_20251107/* storage/app/public/uploads/
```

## 📊 Thống kê và Monitoring

### Kiểm tra số lượng file
```bash
# Đếm file trong uploads
find storage/app/public/uploads -type f | wc -l

# Kiểm tra dung lượng
du -sh storage/app/public/uploads
```

### Tìm ảnh lớn nhất
```bash
find storage/app/public/uploads -type f -exec du -h {} + | sort -rh | head -20
```

## ✅ Checklist bảo trì

### Hàng tuần:
- [ ] Chạy `php artisan images:clean-unused --dry-run`
- [ ] Review logs để kiểm tra các thao tác xóa
- [ ] Kiểm tra dung lượng storage

### Hàng tháng:
- [ ] Backup toàn bộ storage
- [ ] Chạy command dọn dẹp thật sự
- [ ] Kiểm tra và tối ưu database

### Hàng quý:
- [ ] Review và cập nhật Observer logic
- [ ] Kiểm tra hiệu năng storage
- [ ] Tối ưu hóa ảnh cũ (chuyển sang WebP...)

## 🎉 Kết luận

Observer giúp quản lý ảnh tự động, tiết kiệm storage và giữ hệ thống sạch sẽ. Không cần lo lắng về việc xóa ảnh thủ công nữa!
