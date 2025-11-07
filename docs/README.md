# 📚 Tài liệu hướng dẫn

Thư mục này chứa các tài liệu hướng dẫn cho dự án.

## 📖 Danh sách tài liệu

### 1. [IMAGE_MANAGEMENT_GUIDE.md](IMAGE_MANAGEMENT_GUIDE.md)
Hướng dẫn quản lý ảnh tự động:
- Observer tự động xóa ảnh khi update/delete
- Command dọn dẹp ảnh không sử dụng
- Cấu trúc thư mục lưu trữ

### 2. [LEXICAL_EDITOR_GUIDE.md](LEXICAL_EDITOR_GUIDE.md)
Hướng dẫn sử dụng Lexical Editor:
- 6 fonts có sẵn trong editor
- Cách căn lề văn bản đúng cách
- Tips & tricks sử dụng editor
- Các lỗi thường gặp và cách khắc phục

## 🚀 Quick Start

### Quản lý ảnh:
```bash
# Xem trước ảnh sẽ xóa
php artisan images:clean-unused --dry-run

# Xóa ảnh không dùng
php artisan images:clean-unused
```

### Lexical Editor:
- **Font:** Arial, Georgia, Impact, Tahoma, Times New Roman, Verdana
- **Căn lề:** Phải xuống dòng (Enter) trước và sau cụm chữ cần căn

## 💡 Lưu ý
- Observer tự động kích hoạt khi tạo/sửa/xóa bài viết
- Ảnh trong content editor cũng được tự động xóa
- Nên chạy lệnh cleanup định kỳ để dọn ảnh thừa
