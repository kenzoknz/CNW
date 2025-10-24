<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "dulieu");
$conn->set_charset("utf8");

if (isset($_REQUEST['IDNV'])) {
    $idnv = $_REQUEST['IDNV'];
    
    $sql = "DELETE FROM nhanvien WHERE IDNV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idnv); // 's' for string type
    
    if ($stmt->execute()) {
        // Set success message
        $message = "Nhân viên có mã " . $idnv . " đã được xóa thành công!";
    } else {
        // Set error message
        $message = "Lỗi khi xóa nhân viên: " . $conn->error;
    }
    
    $stmt->close();
} else {
    $message = "Không tìm thấy mã nhân viên!";
}

$conn->close();

// Redirect back with message
header("Location: xoa.php?message=" . urlencode($message));
exit(); // Always add exit after header redirect
?>