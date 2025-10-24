<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật phòng ban</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="content-wrapper">
            <?php
            session_start();

            if (!isset($_SESSION['username'])) {
                header("Location: login.php");
                exit();
            }
            ?>

            <a href="index.php" class="back-home">← Quay về trang chính</a>

            <?php
            $conn = new mysqli("localhost", "root", "", "dulieu");
            $conn->set_charset("utf8");
            if ($conn->connect_error) {
                echo '<div class="message error">Kết nối thất bại: ' . $conn->connect_error . '</div>';
                exit();
            }
            
            // Display message if exists
            if (isset($_GET['message'])) {
                $message = htmlspecialchars($_GET['message']);
                $messageClass = strpos($message, 'thành công') !== false ? 'success' : 'error';
                echo '<div class="message ' . $messageClass . '">' . $message . '</div>';
            }
            
            $sql = "SELECT * from phongban";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                echo '<div class="table-container">';
                echo '<table>';
                echo '<caption>Danh sách phòng ban</caption>';
                echo '<thead><tr><th>Mã PB</th><th>Tên phòng ban</th><th>Mô tả</th><th>Thao tác</th></tr></thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['IDPB']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['TenPB']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['MoTa']) . '</td>';
                    echo '<td class="text-center"><a href="form_xulycapnhat.php?IDPB=' . urlencode($row['IDPB']) . '">Cập nhật</a></td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
                echo '</div>';
                mysqli_free_result($result);
            } else {
                echo '<div class="message info">Không có phòng ban nào.</div>';
            }
            
            $conn->close();
            ?>
        </div>
    </div>
</body>

</html>