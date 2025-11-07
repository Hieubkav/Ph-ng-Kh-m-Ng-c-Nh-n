# 📝 Hướng dẫn sử dụng Lexical Editor

## 🎨 **Danh sách Font có sẵn**

Editor có sẵn 6 fonts hệ thống phổ biến:

1. **Arial** - Font sans-serif phổ biến nhất, dễ đọc
2. **Georgia** - Font serif đẹp cho văn bản dài
3. **Impact** - Font đậm, thích hợp cho tiêu đề nổi bật
4. **Tahoma** - Font gần với Verdana, dễ đọc
5. **Times New Roman** - Font serif cổ điển, chuyên nghiệp
6. **Verdana** - Font dễ đọc trên màn hình

💡 **Khuyến nghị:** Dùng **Arial** hoặc **Verdana** cho nội dung, **Georgia** cho văn bản dài, **Impact** cho tiêu đề.

## ⚠️ **LƯU Ý QUAN TRỌNG - Căn lề văn bản**

### **Vấn đề:**
Khi bạn muốn căn lề (trái/giữa/phải/đều) cho một cụm chữ, nếu không xuống dòng sẽ bị căn cả đoạn.

### **Cách làm đúng:**

#### ❌ **SAI - Không xuống dòng:**
```
Đây là dòng 1 [chọn "Tiêu đề chính"] và bấm Center → CẢ DÒNG 1 BỊ CENTER
```

#### ✅ **ĐÚNG - Xuống dòng trước và sau:**
```
Đây là dòng 1
[Enter]
Tiêu đề chính  ← Chọn dòng này và bấm Center
[Enter]
Đây là dòng tiếp theo
```

### **Các bước thực hiện:**

1. **Viết nội dung bình thường**
2. **Đặt con trỏ ở cuối dòng trước cụm cần căn**
3. **Nhấn ENTER để xuống dòng**
4. **Viết cụm chữ cần căn (hoặc paste vào)**
5. **Nhấn ENTER để xuống dòng tiếp**
6. **Bôi đen cụm chữ vừa viết**
7. **Click nút căn lề: Trái/Giữa/Phải/Đều**

## 🎯 **Ví dụ thực tế**

### **Ví dụ 1: Căn giữa tiêu đề**

```
Bài viết về sức khỏe
[Enter - xuống dòng]
CÁC BỆNH VỀ TIM MẠCH  ← Chọn dòng này → Click Center
[Enter - xuống dòng]  
Tim mạch là một trong những vấn đề...
```

**Kết quả:**
```
Bài viết về sức khỏe
      CÁC BỆNH VỀ TIM MẠCH      (căn giữa)
Tim mạch là một trong những vấn đề...
```

### **Ví dụ 2: Căn phải chữ ký**

```
Nội dung bài viết ở đây...
[Enter - xuống dòng]
Trân trọng,  ← Chọn dòng này → Click Right
[Enter - xuống dòng]
Ban biên tập  ← Chọn dòng này → Click Right
```

**Kết quả:**
```
Nội dung bài viết ở đây...
                           Trân trọng, (căn phải)
                        Ban biên tập (căn phải)
```

## 🛠️ **Các công cụ khác**

### **Định dạng văn bản:**
- **Bold** (Ctrl+B): Chữ đậm
- **Italic** (Ctrl+I): Chữ nghiêng
- **Underline** (Ctrl+U): Gạch chân
- **Strikethrough**: Gạch ngang

### **Heading (Tiêu đề):**
- **H1**: Tiêu đề cấp 1 (lớn nhất)
- **H2**: Tiêu đề cấp 2
- **H3**: Tiêu đề cấp 3

### **Danh sách:**
- **Bullet List**: Danh sách gạch đầu dòng
- **Numbered List**: Danh sách có số thứ tự
- **Quote**: Trích dẫn

### **Màu sắc:**
- **Text Color**: Màu chữ
- **Background Color**: Màu nền chữ

### **Căn lề:**
- **Left**: Căn trái
- **Center**: Căn giữa
- **Right**: Căn phải
- **Justify**: Căn đều

### **Thụt lề:**
- **Indent**: Thụt vào (Tab)
- **Outdent**: Lùi ra (Shift+Tab)

### **Khác:**
- **HR**: Thêm đường kẻ ngang
- **Image**: Chèn ảnh
- **Clear**: Xóa format

## 💡 **Tips & Tricks**

### **1. Chọn font nhanh:**
- Click vào dropdown "Font Family"
- Gõ tên font để tìm nhanh (ví dụ: "rob" → Roboto)

### **2. Thay đổi font cho cả đoạn:**
- Bôi đen toàn bộ đoạn văn
- Chọn font từ dropdown
- Cả đoạn sẽ đổi font

### **3. Kết hợp nhiều format:**
```
Chữ có thể vừa [Bold] + [Italic] + [Underline] + [Color]
```

### **4. Copy format:**
- Không có Copy Format trong Lexical
- Phải format lại từng đoạn

### **5. Ảnh trong content:**
- Click nút Image
- Upload ảnh
- Ảnh sẽ tự động lưu vào `storage/app/public/uploads/`

## 🚨 **Các lỗi thường gặp**

### **1. Căn lề bị sai:**
**Nguyên nhân:** Không xuống dòng trước và sau cụm chữ
**Giải pháp:** Đọc lại phần "LƯU Ý QUAN TRỌNG" ở trên

### **2. Font không hiển thị:**
**Nguyên nhân:** Trình duyệt không hỗ trợ font
**Giải pháp:** Chọn font khác hoặc dùng font hệ thống (Arial, Verdana...)

### **3. Ảnh không hiển thị:**
**Nguyên nhân:** Chưa chạy `php artisan storage:link`
**Giải pháp:** Chạy command trên trong terminal

### **4. Mất format khi copy từ Word:**
**Nguyên nhân:** Word có format đặc biệt
**Giải pháp:** 
- Dùng "Clear Format" trước
- Paste text thuần
- Format lại bằng Editor

## 📚 **Tham khảo thêm**

### **Cấu trúc lưu ảnh:**
```
storage/app/public/
└── uploads/
    ├── photo1.jpg        # Ảnh chính (cover)
    ├── document.pdf      # File PDF
    └── [random].jpg      # Ảnh trong content editor
```

### **Observer tự động:**
- Khi update ảnh chính → Tự động xóa ảnh cũ
- Khi xóa bài viết → Tự động xóa tất cả ảnh
- Khi xóa ảnh khỏi content → Tự động xóa file

### **Command dọn dẹp:**
```bash
# Xem trước file sẽ xóa
php artisan images:clean-unused --dry-run

# Xóa thật
php artisan images:clean-unused
```

## ✅ **Checklist khi viết bài**

- [ ] Chọn font phù hợp (khuyến nghị: Roboto, Open Sans)
- [ ] Tiêu đề dùng H1, H2, H3
- [ ] Xuống dòng trước khi căn giữa tiêu đề
- [ ] Đoạn văn căn đều (Justify) để đẹp
- [ ] Ảnh có kích thước hợp lý (< 2MB)
- [ ] Kiểm tra lại format trước khi Save

## 🎉 **Kết luận**

Lexical Editor rất mạnh mẽ nếu biết cách dùng. Nhớ:
- **Xuống dòng** trước khi căn lề
- Chọn **font phù hợp** với nội dung
- **Observer tự động** xóa ảnh thừa
- Dùng **command** dọn dẹp định kỳ

Happy writing! 📝
