<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: capnhat.php?message=Phương thức không hợp lệ");
    exit();
}


if (!isset($_POST['IDPB']) || !isset($_POST['TenPB']) || !isset($_POST['MoTa']) || 
    empty($_POST['IDPB']) || empty($_POST['TenPB']) || empty($_POST['MoTa'])) {
    header("Location: capnhat.php?message=Vui lòng điền đầy đủ thông tin");
    exit();
}


$conn = new mysqli("localhost", "root", "", "dulieu");
$conn->set_charset("utf8");


if ($conn->connect_error) {
    header("Location: capnhat.php?message=Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
    exit();
}


$idpb = $_POST['IDPB'];
$tenpb = $_POST['TenPB'];
$mota = $_POST['MoTa'];


$check_sql = "SELECT 1 FROM phongban WHERE IDPB = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $idpb);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows == 0) {
    
    $check_stmt->close();
    $conn->close();
    header("Location: capnhat.php?message=Không tìm thấy phòng ban với mã " . htmlspecialchars($idpb));
    exit();
}

$check_stmt->close();


$check_name_sql = "SELECT 1 FROM phongban WHERE TenPB = ? AND IDPB != ?";
$check_name_stmt = $conn->prepare($check_name_sql);
$check_name_stmt->bind_param("ss", $tenpb, $idpb);
$check_name_stmt->execute();
$check_name_result = $check_name_stmt->get_result();

if ($check_name_result->num_rows > 0) {
    
    $check_name_stmt->close();
    $conn->close();
    header("Location: form_xulycapnhat.php?IDPB=" . urlencode($idpb) . "&message=Tên phòng ban đã tồn tại");
    exit();
}

$check_name_stmt->close();


$update_sql = "UPDATE phongban SET TenPB = ?, MoTa = ? WHERE IDPB = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("sss", $tenpb, $mota, $idpb);

if ($update_stmt->execute()) {
    
    if ($update_stmt->affected_rows > 0) {
        $update_stmt->close();
        $conn->close();
        header("Location: capnhat.php?message=Cập nhật thông tin phòng ban thành công");
        exit();
    } else {
        
        $update_stmt->close();
        $conn->close();
        header("Location: capnhat.php?message=Không có thay đổi nào được thực hiện");
        exit();
    }
} else {
    
    $error = $update_stmt->error;
    $update_stmt->close();
    $conn->close();
    header("Location: form_xulycapnhat.php?IDPB=" . urlencode($idpb) . "&message=Lỗi khi cập nhật: " . htmlspecialchars($error));
    exit();
}
?>
