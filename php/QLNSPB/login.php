<?php
// Bắt đầu session để có thể sử dụng biến $_SESSION
session_start();

// Nếu người dùng đã đăng nhập, chuyển hướng họ đến trang quản trị
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
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
        
        .wrapper { 
            background: white;
            width: 450px; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        h2 { 
            text-align: center; 
            color: #333;
            margin-bottom: 10px;
            font-size: 2rem;
            font-weight: 600;
        }
        
        p {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 1rem;
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        
        .form-group label { 
            display: block; 
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group input { 
            width: 100%; 
            padding: 15px; 
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important; 
            padding: 15px; 
            border: none; 
            border-radius: 10px; 
            cursor: pointer; 
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .error { 
            background: #ffeaea; 
            color: #e74c3c; 
            padding: 15px; 
            border-radius: 10px; 
            text-align: center; 
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Đăng nhập hệ thống</h2>
        <p>Vui lòng nhập thông tin để đăng nhập.</p>

        <?php 
        // Hiển thị thông báo lỗi nếu có
        if(!empty($_GET['error'])){
            echo '<div class="error">Tên đăng nhập hoặc mật khẩu không đúng.</div>';
        }
        ?>

        <form action="xulylogin.php" method="post">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" required>
            </div>    
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Đăng nhập">
            </div>
        </form>
    </div>    
</body>
</html>