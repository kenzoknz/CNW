<!DOCTYPE html>
<?php
// Start the session at the very beginning
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa Nhân Viên</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="content-wrapper">
            <div class="user-info">Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php">Đăng xuất</a></div>
            <a href="index.php" class="back-home">← Trở về trang chính</a>
            <h1>Danh Sách Nhân Viên</h1>

            <?php
            // Display message if any
            if (isset($_REQUEST['message'])) {
                $message = htmlspecialchars($_REQUEST['message']);
                $messageClass = strpos($message, 'thành công') !== false ? 'success' : 'error';
                echo '<div class="message ' . $messageClass . '">' . $message . '</div>';
            }
            
            // Database connection
            $conn = new mysqli("localhost", "root", "", "dulieu");
            $conn->set_charset("utf8");

            if ($conn->connect_error) {
                echo '<div class="message error">Kết nối thất bại: ' . $conn->connect_error . '</div>';
                exit();
            }
            
            $sql = "SELECT nv.IDNV, nv.HoTen, pb.TenPB, nv.DiaChi
                    FROM nhanvien nv
                    JOIN phongban pb ON nv.IDPB = pb.IDPB
                    ORDER BY nv.IDNV ASC";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                echo '<div class="table-container">';
                echo '<table>';
                echo '<caption>Danh sách nhân viên</caption>';
                echo '<thead><tr><th>Mã NV</th><th>Họ tên</th><th>Phòng ban</th><th>Địa chỉ</th><th>Thao tác</th></tr></thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['IDNV']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['HoTen']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['TenPB']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['DiaChi']) . '</td>';
                    echo '<td class="text-center">';
                    echo '<a href="xulyxoa.php?IDNV=' . urlencode($row['IDNV']) . '" onclick="return confirm(\'Bạn có chắc chắn muốn xóa nhân viên ' . htmlspecialchars($row['HoTen']) . ' không?\');">Xóa</a>';
                    echo '</td></tr>';
                }
                echo '</tbody></table>';
                echo '</div>';
                
                $result->free_result();
            } else {
                echo '<div class="message info">Không có dữ liệu nhân viên!</div>';
            }
            
            $conn->close();
            ?>
        </div>
    </div>
    
    <script>
    // You can add additional JavaScript functionality here if needed
    </script>
</body>
</html>