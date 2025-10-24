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
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật Phòng ban</title>
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
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: 600;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        th, td { 
            padding: 15px; 
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        
        th { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }
        
        .back-link {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
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
        
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Danh sách Phòng ban</h2>
        <?php echo $message; ?>
        <table>
            <tr>
                <th>IDPB</th>
                <th>Tên Phòng ban</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
            <?php
            $sql = "SELECT * FROM phongban";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['IDPB']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Tenpb']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Mota']) . "</td>";
                    echo "<td><a href='form_capnhat.php?idpb=" . urlencode($row['IDPB']) . "' class='btn'>Cập nhật</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Không có phòng ban nào</td></tr>";
            }
            $conn->close();
            ?>
        </table>
        <div class="text-center">
            <a href="admin_dashboard.php" class="back-link">Quay lại Trang quản trị</a>
        </div>
    </div>
</body>
</html>