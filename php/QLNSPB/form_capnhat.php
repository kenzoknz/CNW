<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require 'config.php';

// Lấy thông báo từ session
$message = '';
if (isset($_SESSION['update_success'])) {
    $message = "<div class='success'>" . $_SESSION['update_success'] . "</div>";
    unset($_SESSION['update_success']);
}
if (isset($_SESSION['update_error'])) {
    $message = "<div class='error'>" . $_SESSION['update_error'] . "</div>";
    unset($_SESSION['update_error']);
}

// Lấy thông tin phòng ban cần cập nhật
$idpb = $_GET['idpb'];
$sql = "SELECT * FROM phongban WHERE IDPB = ?";
if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("s", $idpb);
    $stmt->execute();
    $result = $stmt->get_result();
    $phongban = $result->fetch_assoc();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Cập nhật</title>
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
        }
        
        .wrapper { 
            background: white;
            width: 500px; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 1.8rem;
            font-weight: 600;
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
            padding: 12px 15px; 
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 14px;
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
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important; 
            border: none; 
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .back-link {
            display: block;
            text-align: center;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .error { 
            color: #e74c3c; 
            background: #ffeaea;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
            margin-bottom: 20px;
            font-weight: 500;
        } 
        
        .success { 
            color: #27ae60; 
            background: #eafaf1;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #27ae60;
            margin-bottom: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Cập nhật thông tin cho phòng ban: <?php echo htmlspecialchars($phongban['Tenpb']); ?></h2>
        <?php echo $message; ?>
        <form action="xulicapnhat.php" method="post">
            <!-- Gửi IDPB đi một cách ẩn -->
            <input type="hidden" name="idpb" value="<?php echo htmlspecialchars($phongban['IDPB']); ?>">
            <div class="form-group">
                <label>Tên Phòng ban</label>
                <input type="text" name="tenpb" value="<?php echo htmlspecialchars($phongban['Tenpb']); ?>" required>
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <input type="text" name="mota" value="<?php echo htmlspecialchars($phongban['Mota']); ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Lưu thay đổi">
                <a href="capnhat.php" class="back-link">Quay lại</a>
            </div>
        </form>
    </div>
</body>
</html>