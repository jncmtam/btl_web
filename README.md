# BÀI TẬP LỚN LẬP TRÌNH WEB

###

| HỌ VÀ TÊN | MSSV | VAI TRÒ          |
| --------- | ---- | ---------------- |
| Bách      |      | Frontend         |
| Tâm       |      | Leader + Backend |
| Trường    |      | Backend          |
| Kiệt      |      | Backend          |

## CHỦ ĐỀ : Website bán hàng dành cho doanh nghiệp.

### CHỨC NĂNG

- **Guest:**
  - Xem các thông tin public trên trang web: các trang thông tin như trang chủ, sản
    phẩm, thông tin liện hệ, tin tức,...
  - Tìm kiếm tài nguyên (tin tức, sản phẩm, dịch vụ),...

### **Đăng ký - Đăng nhập**

- **Client (sau khi đã đăng nhập)**
  - Lập trình một số chức năng cơ bản:
    - Thay đổi thông tin cá nhân, mật khẩu, hình ảnh đại diện,...
    - Viết bình luận đánh giá (cho sản phẩm, tin tức,...)
    - Các tính năng khác dành riêng cho thành viên
- **Admin:**
  - Quản lý thành viên (xem thông tin, sửa, cấm, xóa thành viên,. . . ).
  - Quản lý bình luận đánh giá của thành viên
  - Quản lý các liên hệ của khách hàng
  - Quản lý thông tin trên các trang public như thay đổi thông tin liên hệ.
  - Quản lý (xem, thêm, sửa, xoá) các trang thông tin như sản phẩm, dịch vụ, bảng
    giá,...
  - Quản lý (xem, thêm, sửa, xoá) tin tức, quản lý từ khoá, mô tả, tiêu đề bài viết.
  - Các tính năng quản lý tài nguyên của trang web khác như quản lý hình ảnh, nội
    dung của trang web,...

### LƯU Ý

- Chạy Demo trực tiếp vào buổi báo cáo được tổ chức vào cuối kỳ.
- Làm đến đâu viết report (Latex) đến đó (Giải thích công nghệ sử dụng, Tính năng,...).
- Cách thức tính điểm tùy thuộc vào số lượng và chất lượng các tính năng của ứng dụng theo yêu
  cầu đề bài.
- Số lượng tính năng nhiều, thiết kế giao diện đẹp, cơ sở dữ liệu tốt sẽ được cộng điểm bonus.
- Giao diện (30%) + tính năng (70%), bao gồm điểm báo cáo.

### CÔNG NGHỆ

- Bootstrap (CSS), PHP, jQuery, AJAX (Javascript), mySQL, Figma.

- Mô hình : `Model` - `View` - `Controller.`

```bash

/database
    |-- db.sql
/src
    |-- controllers
        |-- admin
        |-- error
        |-- main
    |-- models
    |-- views
        |-- admin
        |-- error
        |-- main

    |-- index.php
    |-- routes.php
```

- Thực hiện kiểm tra dữ liệu đầu vào, sử dụng cả kiểm tra bằng javascript (client side) và PHP (server side).
- Thiết kế giao diện, hiệu ứng và tương tác cho trang web như carousel, wysiwyg, drag & drop file upload, lazy loading, parallax, animations,... Hiện thực phân trang cho các tính năng hiển thị thông tin quá dài.
