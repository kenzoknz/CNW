<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Kết quả tìm kiếm</h2>
    
    <?php
        if (isset($_POST['searchField']) && isset($_POST['searchBy'])) {
            $searchField = $_POST['searchField'];
            $searchBy = $_POST['searchBy'];

            $conn = new mysqli("localhost", "root", "", "dulieu");
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT * FROM nhanvien 
            LEFT JOIN phongban on nhanvien.IDPB = phongban.IDPB
            WHERE $searchBy LIKE ?");
            $likeSearchField = "%" . $searchField . "%";
            $stmt->bind_param("s", $likeSearchField);
            $stmt->execute();
            $result = $stmt->get_result();

            echo '<table border="1" cellspacing="0" cellpadding="10">';
            echo '<caption>Kết quả tìm kiếm</caption>';
            echo '<tr><th>IDNV</th><th>Họ tên</th><th>Phòng ban</th><th>Địa chỉ</th></tr>';

            while ($row = mysqli_fetch_array($result)) {
                echo '<tr><td>' . $row['IDNV'] . '</td><td>' . $row['HoTen'] . '</td><td>' . $row['TenPB'] . '</td><td>' . $row['DiaChi'] . '</td></tr>';
            }
            echo '</table>';

            mysqli_free_result($result);
            $stmt->close();
            $conn->close();
        } else {
            echo "<p>Vui lòng sử dụng form tìm kiếm.</p>";
        }
    ?>
    
    <a href="timkiem.php" class="back-link">Quay lại trang tìm kiếm</a>
</body>
</html>