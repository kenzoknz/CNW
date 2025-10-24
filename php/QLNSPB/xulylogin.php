<?php
// Bắt đầu session
session_start();

// Gọi file config để kết nối CSDL
require 'config.php';

// Kiểm tra xem form đã được gửi đi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Dùng prepared statement để bảo mật
    $sql = "SELECT username, password FROM admin WHERE username = ? AND password = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Gắn các biến vào statement
        $stmt->bind_param("ss", $param_username, $param_password);
        
        // Gán giá trị cho các biến
        $param_username = $username;
        $param_password = $password; // Lưu ý: thực tế nên mã hóa mật khẩu
        
        // Thực thi
        if ($stmt->execute()) {
            // Lưu trữ kết quả
            $stmt->store_result();
            
            // Nếu có 1 tài khoản khớp
            if ($stmt->num_rows == 1) {
                // Đăng nhập thành công, tạo các biến session
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;                            
                
                // Chuyển hướng đến trang quản trị
                header("location: admin_dashboard.php");
            } else {
                // Mật khẩu hoặc tài khoản không đúng, quay lại trang login với thông báo lỗi
                header("location: login.php?error=1");
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        // Đóng statement
        $stmt->close();
    }
}
// Đóng kết nối
$conn->close();
?>