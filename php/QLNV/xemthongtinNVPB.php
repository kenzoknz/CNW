
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên theo phòng ban</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="content-wrapper">
            <?php
            if (!isset($_GET['IDPB']) || empty($_GET['IDPB'])) {
                echo '<div class="message error">Không tìm thấy mã phòng ban.</div>';
                echo '<a href="xemthongtinpb.php" class="back-home">Quay lại danh sách phòng ban</a>';
                exit;
            }
            $conn = new mysqli("localhost", "root", "", "dulieu");
            $conn->set_charset("utf8");
            if ($conn->connect_error) {
                echo '<div class="message error">Kết nối thất bại: ' . $conn->connect_error . '</div>';
                exit();
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
                echo '<div class="table-container">';
                echo '<table>';
                echo '<thead><tr><th>Mã NV</th><th>Họ tên</th><th>Phòng ban</th><th>Địa chỉ</th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['IDNV']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['HoTen']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['TenPB']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['DiaChi']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
                echo '</div>';
            } else {
                echo '<div class="message info">Không có nhân viên nào trong phòng ban này.</div>';
            }
            
            // Đóng kết nối
            $stmt->close();
            $conn->close();
            ?>
            
            <a href="xemthongtinpb.php" class="back-home">← Quay lại danh sách phòng ban</a>
        </div>
    </div>
</body>
</html>
