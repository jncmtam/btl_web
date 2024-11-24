# Config để code chạy được
## 1. Database
1. Tạo database (tên database: `shop`)
2. Chạy script trong file `src/SQL/company_website.sql` để tạo data
## 2. Tạo biến môi trường
1. Sửa file `makeENVdata.php`
	1. `$shop["username"] = "root";` // sửa nếu cần
	2. `$shop["password"] = "";` // sửa nếu cần
	3. `$config["root_path"] = "D:\HCMUT\Lap-trinh-web\BTL\github\btl_web\src";` // sửa thành path trên máy
2. Chạy file `makeENVdata.php` bằng cmd (như hình `src/demo.png`)
## 3. Config xampp
1. Sửa file `httpd.conf` của xampp
	1. Thêm đoạn code sau vào cuối file (sửa đường dẫn theo thư mục trên máy):
```
<VirtualHost shop.localtest.me:80>
    ServerName shop.localtest.me
    DocumentRoot "D:\HCMUT\Lap-trinh-web\BTL\github\btl_web\src\public"
    <Directory "D:\HCMUT\Lap-trinh-web\BTL\github\btl_web\src\public">
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php/$1 [L]
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
## 4. Start xampp apache
Vào Link `shop.localhost.me`
