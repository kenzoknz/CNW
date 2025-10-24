<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: chen.php?error=Phương thức không hợp lệ");
    exit();
}

// Check if all required fields are provided
if (!isset($_POST['IDNV']) || !isset($_POST['HoTen']) || !isset($_POST['IDPB']) || !isset($_POST['DiaChi']) || 
    empty($_POST['IDNV']) || empty($_POST['HoTen']) || empty($_POST['IDPB']) || empty($_POST['DiaChi'])) {
    header("Location: chen.php?error=Vui lòng điền đầy đủ thông tin");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "dulieu");
if (mysqli_connect_errno()) {
    header("Location: chen.php?error=Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    exit();
}

// Get form data
$idnv = mysqli_real_escape_string($conn, $_POST['IDNV']);
$hoten = mysqli_real_escape_string($conn, $_POST['HoTen']);
$idpb = mysqli_real_escape_string($conn, $_POST['IDPB']);
$diachi = mysqli_real_escape_string($conn, $_POST['DiaChi']);

// Check if employee ID already exists
$check_sql = "SELECT * FROM nhanvien WHERE IDNV = '$idnv'";
$check_result = mysqli_query($conn, $check_sql);
if ($check_result && mysqli_num_rows($check_result) > 0) {
    header("Location: chen.php?error=Mã nhân viên đã tồn tại");
    mysqli_close($conn);
    exit();
}

// Insert new employee
$sql = "INSERT INTO nhanvien (IDNV, HoTen, IDPB, DiaChi) VALUES ('$idnv', '$hoten', '$idpb', '$diachi')";
if (mysqli_query($conn, $sql)) {
    header("Location: chen.php?success=Thêm nhân viên thành công");
} else {
    header("Location: chen.php?error=Lỗi khi thêm nhân viên: " . mysqli_error($conn));
}

mysqli_close($conn);
?>