<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dulieu";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    header("Location: login.php?error=Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
    exit();
}


if (!isset($_POST['username']) || !isset($_POST['password']) || empty($_POST['username']) || empty($_POST['password'])) {
    header("Location: login.php?error=Vui lòng nhập tên đăng nhập và mật khẩu");
    exit();
}


$username = $_POST['username'];
$password = $_POST['password'];


$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);


$result = $conn->query("SHOW TABLES LIKE 'admin'");
if ($result->num_rows == 0) {
    header("Location: login.php?error=Bảng admin chưa được tạo. Vui lòng truy cập 'check_db.php' để cài đặt.");
    $conn->close();
    exit();
}

$sql = "SELECT * FROM admin WHERE username='$username'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    $row = $result->fetch_assoc();

    if ($password == $row['password']) {

      //  $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];


        $conn->close();

        header("Location: index.php");
        exit();
    } else {

        $conn->close();
        header("Location: login.php?error=Tên đăng nhập hoặc mật khẩu không đúng");
        exit();
    }
} else {

    $conn->close();
    header("Location: login.php?error=Tên đăng nhập hoặc mật khẩu không đúng");
    exit();
}
?>