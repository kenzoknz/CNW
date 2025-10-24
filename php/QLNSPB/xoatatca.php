<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Lấy thông báo từ session
$message = '';
if (isset($_SESSION['delete_success'])) {
    $message = "<div class='success'>" . $_SESSION['delete_success'] . "</div>";
    unset($_SESSION['delete_success']);
}
if (isset($_SESSION['delete_error'])) {
    $message = "<div class='error'>" . $_SESSION['delete_error'] . "</div>";
    unset($_SESSION['delete_error']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xem và Xóa Nhân viên</title>
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
            margin-bottom: 20px;
            font-size: 2.5rem;
            font-weight: 600;
        }
        
        p {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        
        .delete-btn {
            display: block;
            margin: 0 auto 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
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
        
        .btn-delete {
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .btn-delete:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
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
        
        .text-center {
            text-align: center;
        }
        
        /* Checkbox styling */
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #667eea;
            cursor: pointer;
        }
        
        hr {
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e9ecef, transparent);
            margin: 20px 0;
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
    <script>
        function confirmDelete() {
            return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');
        }
        
        function confirmDeleteSelected() {
            var checkboxes = document.getElementsByName('ids_to_delete[]');
            var checkedCount = 0;
            for (var checkbox of checkboxes) {
                if (checkbox.checked) {
                    checkedCount++;
                }
            }
            
            if (checkedCount === 0) {
                alert('Vui lòng chọn ít nhất một nhân viên để xóa!');
                return false;
            }
            
            return confirm('Bạn có chắc chắn muốn xóa ' + checkedCount + ' nhân viên đã chọn?');
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Danh sách Nhân viên</h2>
        <p>Bạn có thể xóa từng nhân viên hoặc chọn nhiều người để xóa cùng lúc.</p>
        <?php echo $message; ?>
        <form action="xulyxoatatca.php" method="post">
            <input type="submit" value="Xóa các mục đã chọn" class="delete-btn" onclick="return confirmDeleteSelected();">
            <hr>
            <table>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>IDNV</th>
                    <th>Họ Tên</th>
                    <th>Phòng Ban</th>
                    <th>Hành động</th>
                </tr>
                <?php
                // Lấy lại kết nối sau khi có thể đã bị đóng ở phần xử lý POST
                require 'config.php';
                $sql = "SELECT * FROM nhanvien";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='ids_to_delete[]' value='" . htmlspecialchars($row['IDNV']) . "'></td>";
                        echo "<td>" . htmlspecialchars($row['IDNV']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Hoten']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['IDPB']) . "</td>";
                        echo "<td><a href='xoa.php?idnv=" . urlencode($row['IDNV']) . "' class='btn-delete' onclick='return confirmDelete();'>Xóa</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Không có nhân viên nào</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </form>
        <div class="text-center">
            <a href="admin_dashboard.php" class="back-link">Quay lại Trang quản trị</a>
        </div>
    </div>

    <script>
        // Javascript để chọn/bỏ chọn tất cả checkbox
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.getElementsByName('ids_to_delete[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    </script>
</body>
</html>