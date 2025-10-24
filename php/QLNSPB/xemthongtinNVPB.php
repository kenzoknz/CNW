<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhân viên theo Phòng ban</title>
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
        
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        require 'config.php';

        // Kiểm tra xem có IDPB được truyền qua URL không
        if (isset($_GET['idpb'])) {
            $idpb = $_GET['idpb'];

            // Dùng prepared statement để bảo mật, chống SQL Injection
            // Lấy tên phòng ban để hiển thị tiêu đề
            $stmt_pb = $conn->prepare("SELECT Tenpb FROM phongban WHERE IDPB = ?");
            $stmt_pb->bind_param("s", $idpb);
            $stmt_pb->execute();
            $result_pb = $stmt_pb->get_result();
            $ten_pb = "Không xác định";
            if ($result_pb->num_rows > 0) {
                $ten_pb = $result_pb->fetch_assoc()['Tenpb'];
            }

            echo "<h1>DANH SÁCH NHÂN VIÊN PHÒNG: " . htmlspecialchars($ten_pb) . "</h1>";

            // Lấy danh sách nhân viên
            $stmt_nv = $conn->prepare("SELECT * FROM nhanvien WHERE IDPB = ?");
            $stmt_nv->bind_param("s", $idpb);
            $stmt_nv->execute();
            $result_nv = $stmt_nv->get_result();
            ?>

            <table>
                <tr>
                    <th>IDNV</th>
                    <th>Họ Tên</th>
                    <th>Địa chỉ</th>
                </tr>
                <?php
                if ($result_nv->num_rows > 0) {
                    while($row = $result_nv->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["IDNV"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Hoten"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Diachi"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='no-data'>Không có nhân viên nào trong phòng ban này</td></tr>";
                }
                ?>
            </table>

            <?php
            $stmt_pb->close();
            $stmt_nv->close();
        } else {
            echo "<h1>ID Phòng Ban không hợp lệ.</h1>";
        }
        $conn->close();
        ?>

        <div class="text-center">
            <a href="xemthongtinpb.php" class="back-link">Quay lại danh sách phòng ban</a>
        </div>
    </div>
</body>
</html>