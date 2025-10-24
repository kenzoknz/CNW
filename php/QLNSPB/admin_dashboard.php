<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Quản trị</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        
        .page-header h1 { 
            font-size: 2.5em; 
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .welcome-msg { 
            margin-bottom: 30px; 
            color: #666;
            font-size: 1.1rem;
            line-height: 1.5;
        }
        
        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .nav-links a { 
            display: block; 
            padding: 15px 25px; 
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white; 
            text-decoration: none; 
            border-radius: 10px; 
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }
        
        .nav-links a:hover { 
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
        }
        
        .logout a { 
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 12px 30px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }
        
        .logout a:hover { 
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }
        
        .username {
            color: #667eea;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Chào mừng, <span class="username"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>!</h1>
        </div>
        <p class="welcome-msg">Đây là trang quản trị. Bạn có thể sử dụng các chức năng dưới đây.</p>
        
        <div class="nav-links">
            <a href="xemthongtinnv.php">📋 Xem danh sách nhân viên</a>
            <a href="xemthongtinpb.php">🏢 Xem thông tin phòng ban</a>
            <a href="timkiem.php">🔍 Tìm kiếm nhân viên</a>
            <a href="chenthemthongtin.php">➕ Thêm nhân viên mới</a>
            <a href="capnhat.php">📝 Cập nhật thông tin phòng ban</a>
            <a href="xoatatca.php">🗑️ Xem và Xóa nhân viên</a>
        </div>

        <p class="logout">
            <a href="logout.php">🚪 Đăng xuất</a>
        </p>
    </div>
</body>
</html>