<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Hệ Thống Quản Lý Nhân Viên</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Đăng Nhập Hệ Thống</h2>
            <?php
            // Display error message if passed from xulylogin.php
            if(isset($_GET['error'])) {
                echo '<div class="message error">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>
            <form action="xulylogin.php" method="post">
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                </div>
            </form>
            <div class="text-center mt-2"><a href="index.php" class="back-home">Quay về trang chính</a></div>
        </div>
    </div>
</body>
</html>