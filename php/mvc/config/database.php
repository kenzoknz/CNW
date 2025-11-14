<?php
// Thông tin kết nối cơ sở dữ liệu
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // User mặc định của XAMPP
define('DB_PASS', '');     // Password mặc định của XAMPP là rỗng
define('DB_NAME', 'dulieu_mvc'); // Tên database bạn đã tạo

// Tạo chuỗi DSN (Data Source Name)
define('DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8');
?>