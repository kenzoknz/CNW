<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên</title>
</head>
<body>
    <div class="login-container">
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Thêm Nhân Viên</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <div class="container">
                <div class="form-container">
                    <h2>Thêm Nhân Viên Mới</h2>
                    <?php
                    if (isset($_GET['error'])) {
                        echo '<div class="message error">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    if (isset($_GET['success'])) {
                        echo '<div class="message success">' . htmlspecialchars($_GET['success']) . '</div>';
                    }
                    echo "<a href='index.php' class='back-home'>Trở về trang chính</a><br><br>";
                    ?>
            
                    <form action="xulychen.php" method="post">
                        <div class="form-group">
                            <label for="idnv">Mã nhân viên:</label>
                            <input type="text" id="idnv" name="IDNV" required>
                        </div>
                
                        <div class="form-group">
                            <label for="hoten">Họ và tên:</label>
                            <input type="text" id="hoten" name="HoTen" required>
                        </div>
                
                        <div class="form-group">
                            <label for="idpb">Phòng ban:</label>
                            <select id="idpb" name="IDPB" required>
                                <option value="">-- Chọn phòng ban --</option>
                                <?php
                                // Database connection
                                $conn = new mysqli("localhost", "root", "", "dulieu");
                                if ($conn->connect_error) {
                                    die("Kết nối thất bại: " . $conn->connect_error);
                                }
                        
                                // Get all departments
                                $sql = "SELECT * FROM phongban ORDER BY TenPB";
                                $result = $conn->query($sql);
                        
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['IDPB']) . "'>" . htmlspecialchars($row['TenPB']) . "</option>";
                                    }
                                }
                        
                                $conn->close();
                                ?>
                            </select>
                        </div>
                
                        <div class="form-group">
                            <label for="diachi">Địa chỉ:</label>
                            <input type="text" id="diachi" name="DiaChi" required>
                        </div>
                
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">Thêm nhân viên</button>
                            <a href="index.php" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </body>
        </html>