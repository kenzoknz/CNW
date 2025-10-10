
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên theo phòng ban</title>
</head>
<body>
    <?php
    // Kiểm tra xem IDPB có được truyền không
    if (!isset($_GET['IDPB']) || empty($_GET['IDPB'])) {
        echo "<p>Không tìm thấy mã phòng ban.</p>";
        echo '<a href="xemthongtinpb.php" class="back-link">Quay lại danh sách phòng ban</a>';
        exit;
    }
    $conn = new mysqli("localhost", "root", "", "dulieu");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $idpb = $conn->real_escape_string($_GET['IDPB']);
    $sql = "SELECT nv.IDNV, nv.HoTen, pb.TenPB, nv.DiaChi
            FROM nhanvien nv
            JOIN phongban pb ON nv.IDPB = pb.IDPB
            WHERE nv.IDPB = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idpb);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo '<h3>Danh sách nhân viên của phòng ban</h3>';
        echo '<table border="1" cellspacing="0" cellpadding="10">';
        echo '<tr><th>IDNV</th><th>Họ tên</th><th>Phòng ban</th><th>Địa chỉ</th></tr>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['IDNV']) . '</td>';
            echo '<td>' . htmlspecialchars($row['HoTen']) . '</td>';
            echo '<td>' . htmlspecialchars($row['TenPB']) . '</td>';
            echo '<td>' . htmlspecialchars($row['DiaChi']) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo "<p>Không có nhân viên nào trong phòng ban này.</p>";
    }
    
    // Đóng kết nối
    $stmt->close();
    $conn->close();
    ?>
    
    <a href="xemthongtinpb.php" class="back-link">Quay lại danh sách phòng ban</a>
</body>
</html>
