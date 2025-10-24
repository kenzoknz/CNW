<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin Nhân viên</title>
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
        
        h1 { 
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
        
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 30px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>DANH SÁCH TOÀN BỘ NHÂN VIÊN</h1>

        <table>
            <tr>
                <th>IDNV</th>
                <th>Họ Tên</th>
                <th>IDPB</th>
                <th>Địa chỉ</th>
            </tr>
            <?php
            // 1. Gọi đến tệp config.php để có kết nối $conn
            require 'config.php';

            // 2. Viết câu lệnh SQL để lấy dữ liệu
            $sql = "SELECT * FROM nhanvien";

            // 3. Thực thi câu lệnh và lấy kết quả
            $result = $conn->query($sql);

            // 4. Kiểm tra và lặp qua kết quả để hiển thị ra bảng
            if ($result->num_rows > 0) {
                // Lặp qua mỗi hàng dữ liệu
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["IDNV"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Hoten"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["IDPB"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Diachi"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>Không có nhân viên nào</td></tr>";
            }

            // 5. Đóng kết nối
            $conn->close();
            ?>
        </table>

        <div class="text-center">
            <a href="admin_dashboard.php" class="back-link">Quay lại Trang quản trị</a>
            <a href="timkiem.php" class="back-link" style="margin-left: 10px;">🔍 Tìm kiếm nhân viên</a>
        </div>
    </div>
</body>
</html>