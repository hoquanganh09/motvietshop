# Hướng dẫn Cài đặt & Triển khai Dự án MotVietShop

Dự án này đã được đóng gói sẵn với Docker môi trường (PHP-FPM 8.2, MySQL, Nginx, phpMyAdmin). Việc triển khai cực kì đơn giản và không yêu cầu bạn phải cài đặt tốn công bất kỳ phần mềm môi trường (như XAMPP/WAMP) nào lên máy tính thật.

---

## 1. Yêu cầu hệ thống (Prerequisites)
- [Docker Engine](https://docs.docker.com/engine/install/) & [Docker Compose](https://docs.docker.com/compose/install/) (Khuyến nghị dùng Docker Desktop nếu bạn đang ở trên Windows / macOS).
- Đảm bảo các Port sau trên máy tính của bạn chưa có phần mềm nào khác sử dụng:
  - **Port 9999:** Dành cho Website.
  - **Port 3306:** Dành cho MySQL Database.
  - **Port 9090:** Dành cho phpMyAdmin.

---

## 2. Các bước Triển khai (Installation Steps)

**Bước 1:** Mở Terminal (hoặc Command Prompt / PowerShell) và điều hướng đến thư mục gốc của dự án (`motvietshop`).

**Bước 2:** Chạy câu lệnh sau để tự động tải các images, cài đặt thư viện và khởi động môi trường:
```bash
docker compose up -d --build
```

**Quá trình khởi tạo tự động hóa sẽ gồm:**
- Tự động download và cài đặt các Extensions PHP tương thích.
- Tự động cài đặt các Package của Laravel qua `composer install`.
- Tự động sao chép cấu hình `.env.example` sang `.env`.
- Tự động sinh mã `APP_KEY` an toàn (`php artisan key:generate`).
- Tự động phân quyền ghi (write permission) an toàn cho phân vùng thư mục `storage` và `bootstrap/cache`.
- Tự động Nạp (Import) hệ cơ sở dữ liệu có sẵn thông qua file `init.sql` đồ sộ của dự án.

> [!NOTE]
> Ở lần chạy đầu tiên, thời gian cài đặt có thể mất từ 3 tới 5 phút tùy thuộc vào tốc độ mạng (do phải kéo các base image từ Docker Hub). Ở những lần sử dụng sau, thời gian khởi động chỉ tốn vài giây!

---

## 3. Truy cập dự án

Sau khi Terminal thông báo các dòng chữ `Started` màu xanh, bạn có thể lập tức mở trình duyệt và truy cập:

- 🌐 **Giao diện Website MotVietShop:** [http://localhost:9999](http://localhost:9999)
- 📊 **Trang Quản trị CSDL (phpMyAdmin):** [http://localhost:9090](http://localhost:9090)
  - Thông tin đăng nhập phpMyAdmin:
    - **Server:** Khai báo là `mysql`
    - **Username:** `root`
    - **Password:** `root_password`

- 🔑 **Tài khoản quản trị Hệ thống (Admin Web):** 
  - Đường dẫn đăng nhập: [http://localhost:9999/admin/dang-nhap](http://localhost:9999/admin/dang-nhap)
  - **Email Root Admin:** `root@admin.com`
  - **Mật khẩu (chung):** `admin123`
  *(Ngoài ra có các tài khoản cấp thấp hơn: `superadmin@admin.com`, `admin@admin.com`, `user@admin.com` với cùng mật khẩu `admin123`)*

---

## 4. Các Lỗi Thường Gặp (Troubleshooting)

### A. Nếu bị lỗi đụng Port (Ports are not available / Bind for 0.0.0.0:xxxx failed)
Có thể một ứng dụng nền đang chiếm giữ Port. Bạn chỉ cần vào file `docker-compose.yml`, tìm Port đó và sửa vế đằng trước. 
Ví dụ: Thay `9999:80` thành `8888:80` nếu Port 9999 bị trùng.

### B. Mở Shell để gõ lệnh Laravel Artisan
Mọi logic nằm trong container PHP-FPM, nếu bạn muốn chạy các lệnh `php artisan`, đừng gõ ở máy tính host mà hãy chạy lệnh:
```bash
docker exec -it motvietshop-php-fpm-1 php artisan <tên lệnh>
# VD: docker exec -it motvietshop-php-fpm-1 php artisan make:controller ABC
```

---

## 5. Tính năng Live-Reload (Tự động cập nhật code)

Dự án hiện tại đã được thiết lập tính năng **Bind Mount** (map đường dẫn `.` hiện tại vào `/app` bên trong container) từ file `docker-compose.yml`. Nhờ kiến trúc này, toàn bộ mã nguồn trên máy thật của bạn đã được kết nối đồng bộ trực tiếp vào máy chủ ảo.

Vì vậy, mọi chỉnh sửa đối với source code (file PHP, HTML, JS, CSS... cấu hình) trên Code Editor của bạn sau khi nhấn **Save** (`Ctrl + S`) sẽ được **tự động cập nhật ngay lập tức** lên Website mà **KHÔNG CẦN CHẠY BẤT KỲ LỆNH NÀO**, bạn cũng hoàn toàn không cần phải sử dụng lại lệnh docker build. Bạn chỉ việc mở trình duyệt ra và bấm tải lại trang (`F5`) là sẽ thấy ngay kết quả mới nhất!

---

## 6. Dừng hoặc Xoá Dự án

Khi làm việc xong, muốn tắt toàn bộ Website để giải phóng RAM mà vẫn giữ lại Database:
```bash
docker compose down
```

**⚠️ Cảnh báo xoá hoàn toàn:** Nếu bạn làm hỏng dữ liệu data, và muốn quay lại từ đầu (xoá sạch toàn bộ cấu trúc DB hiện tại để nó chạy lại file `init.sql` ban đầu):
```bash
docker compose down -v
```
*(Chỉ sử dụng -v khi bạn chắc chắn và không có dữ liệu quan trọng)*
