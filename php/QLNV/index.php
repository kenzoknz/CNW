<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Lý Nhân Viên</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="content-wrapper">
            <?php
            session_start();    
            if (isset($_SESSION["username"]) && $_SESSION["username"]) {
                echo "<div class='user-info'>Xin chào, " . htmlspecialchars($_SESSION['username']) . " | <a href='logout.php'>Đăng xuất</a></div>";
            } else {
                echo "<div class='form-group text-center'><button><a href='login.php'>Đăng nhập</a></button></div>";
            }
            ?>

            <h1>Hệ Thống Quản Lý Nhân Viên</h1>

            <ul class="nav-menu">
                <li><a href="xemthongtinnv.php">Xem thông tin nhân viên</a></li>
                <li><a href="xemthongtinpb.php">Xem thông tin phòng ban</a></li>
                <li><a href="timkiem.php">Tìm kiếm</a></li>
                <?php
                if (isset($_SESSION["username"]) && $_SESSION["username"]) {
                    echo '<li><a href="chen.php">Thêm nhân viên</a></li>';
                    echo '<li><a href="capnhat.php">Cập nhật thông tin phòng ban</a></li>';
                    echo '<li><a href="xoa.php">Xóa nhân viên</a></li>';
                    echo '<li><a href="xoatatca.php">Xóa nhiều nhân viên</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>

</body>

</html>