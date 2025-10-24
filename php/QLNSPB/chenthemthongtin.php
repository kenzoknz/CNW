<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require 'config.php';

$message = '';
// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idnv = trim($_POST['idnv']);
    $hoten = trim($_POST['hoten']);
    $idpb = $_POST['idpb'];
    $diachi = trim($_POST['diachi']);

    // Kiểm tra ID nhân viên đã tồn tại chưa
    $check_sql = "SELECT IDNV FROM nhanvien WHERE IDNV = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("s", $idnv);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $message = "<div class='error'>Lỗi: ID nhân viên đã tồn tại!</div>";
        } else {
            // Thêm nhân viên mới
            $sql = "INSERT INTO nhanvien (IDNV, Hoten, IDPB, Diachi) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $idnv, $hoten, $idpb, $diachi);
                if ($stmt->execute()) {
                    $message = "<div class='success'>Thêm nhân viên thành công!</div>";
                } else {
                    $message = "<div class='error'>Lỗi: " . $stmt->error . "</div>";
                }
                $stmt->close();
            }
        }
        $check_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm nhân viên</title>
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
            font-size: 2rem;
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
        
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 12px 15px; 
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-group input:focus, .form-group select:focus {
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
        <h2>Thêm Nhân viên mới</h2>
        <?php echo $message; ?>
        <form action="chenthemthongtin.php" method="post">
            <div class="form-group">
                <label>ID Nhân viên</label>
                <input type="text" name="idnv" required>
            </div>
            <div class="form-group">
                <label>Họ Tên</label>
                <input type="text" name="hoten" required>
            </div>
            <div class="form-group">
                <label>Phòng ban</label>
                <select name="idpb" required>
                    <option value="">-- Chọn phòng ban --</option>
                    <?php
                    $sql_pb = "SELECT * FROM phongban";
                    $result_pb = $conn->query($sql_pb);
                    if ($result_pb->num_rows > 0) {
                        while($row_pb = $result_pb->fetch_assoc()) {
                            echo "<option value='" . $row_pb['IDPB'] . "'>" . $row_pb['Tenpb'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input type="text" name="diachi">
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Thêm mới">
                <a href="admin_dashboard.php" class="back-link">Quay lại</a>
            </div>
        </form>
    </div>
</body>
</html>