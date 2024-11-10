# BÀI TẬP LỚN LẬP TRÌNH WEB

###

| HỌ VÀ TÊN | MSSV | VAI TRÒ          |
| --------- | ---- | ---------------- |
| Bách      |      | Frontend         |
| Tâm       |      | Leader + Backend |
| Trường    |      | Backend          |
| Kiệt      |      | Backend          |

## CHỦ ĐỀ : Website bán hàng dành cho doanh nghiệp.

### Giao diện

- **Home:** index.php(guest), admin.php(admin), user.php(user)
  - Trang chủ
  - Guest, User, Admin
- **Profile:** profile.php
  - Trang cá nhân
  - User, Admin
- **About Us:** about.php
  - Trang thông tin công ty
  - Guest, User, Admin
- **News:** news.php
  - Trang tin tức, sự kiện
  - Guest, User, Admin
- **Services:** services.php
  - Trang sản phẩm
  - Guest, User
- **Contact:** contact.php
  - Trang phản hồi 
  - Guest, User
- **Shopping Cart:** shopping_cart.php
  - Trang giỏ hàng
  - User
- **Pricing:** pricing.php
  - Trang giao dịch
  - User  
- **Product Management:** services_admin.php
  - Trang quản lý sản phẩm
  - Admin
- **User Management:** usermanagement.php
  - Trang quản lý người dùng
  - Admin
- **News Management:** news_admin.php
  - Trang quản lý tin tức
  - Admin 
- **Feedback Management:** feedback_admin.php
  - Trang quản lý feedback
  - Admin
- **Login:** login.php
  - Trang đăng nhập
  - Guest
- **Register:** register.php
  - Trang đăng kí
  - Guest 


### Database (company_website)
- **Products:** bảng products
  - id:
  - name:
  - price:
  - quantity:
  - image:
- **User:**
  - id:
  - username
  - password:
  - role:
  - phone:
  - email:
- **Contact:**
  - id:
  - name:
  - message:
  - created_at:
- **News:** 
  - id:
  - title:
  - content
  - image(nếu có):
  - created_at: 
- **Feedbacks:**  
  - id
  - user_id:
  - type: 
  - reference_id:
  - comment:
  - created_at: