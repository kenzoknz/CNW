<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require 'config.php';

// Xử lý khi form xóa nhiều người được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ids_to_delete'])) {
    $ids = $_POST['ids_to_delete'];
    
    // Kiểm tra xem có chọn nhân viên nào không
    if (empty($ids)) {
        $_SESSION['delete_error'] = "Vui lòng chọn ít nhất một nhân viên để xóa!";
        header("location: xoatatca.php");
        exit();
    }
    
    // Tạo chuỗi placeholder (?,?,?) cho câu lệnh IN
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "DELETE FROM nhanvien WHERE IDNV IN ($placeholders)";
    
    if ($stmt = $conn->prepare($sql)) {
        // Gắn các ID vào statement
        $stmt->bind_param(str_repeat('s', count($ids)), ...$ids);
        if ($stmt->execute()) {
            $_SESSION['delete_success'] = "Đã xóa " . count($ids) . " nhân viên thành công!";
        } else {
            $_SESSION['delete_error'] = "Có lỗi xảy ra khi xóa nhân viên!";
        }
        $stmt->close();
    } else {
        $_SESSION['delete_error'] = "Có lỗi xảy ra khi chuẩn bị câu lệnh SQL!";
    }
    
    $conn->close();
    
    // Tải lại trang để thấy kết quả
    header("location: xoatatca.php");
    exit();
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trường hợp POST nhưng không có ids_to_delete
    $_SESSION['delete_error'] = "Vui lòng chọn ít nhất một nhân viên để xóa!";
    header("location: xoatatca.php");
    exit();
} else {
    // Trường hợp truy cập trực tiếp không thông qua POST
    header("location: xoatatca.php");
    exit();
}
?>
