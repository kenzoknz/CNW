<?php
// ---- CẤU HÌNH CƠ SỞ DỮ LIỆU ---- //
$servername = "localhost";      // Thường là localhost
$username = "root";             // Tên người dùng mặc định của XAMPP
$password = "";                 // Mật khẩu mặc định của XAMPP là rỗng
$dbname = "dulieu";             // Tên cơ sở dữ liệu bạn đã tạo

// ---- TẠO KẾT NỐI ---- //
$conn = new mysqli($servername, $username, $password, $dbname);

// ---- KIỂM TRA KẾT NỐI ---- //
if ($conn->connect_error) {
    // Nếu kết nối thất bại, hiển thị lỗi và dừng chương trình
    die("Connection failed: " . $conn->connect_error);
}

// ---- SET CHARSET ĐỂ HIỂN THỊ TIẾNG VIỆT ---- //
// Rất quan trọng để không bị lỗi font chữ
$conn->set_charset("utf8");

?>