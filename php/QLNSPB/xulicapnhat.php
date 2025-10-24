<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idpb = $_POST['idpb'];
    $tenpb = trim($_POST['tenpb']);
    $mota = trim($_POST['mota']);

    // Lấy thông tin phòng ban hiện tại để so sánh
    $current_sql = "SELECT Tenpb, Mota FROM phongban WHERE IDPB = ?";
    if ($current_stmt = $conn->prepare($current_sql)) {
        $current_stmt->bind_param("s", $idpb);
        $current_stmt->execute();
        $current_result = $current_stmt->get_result();
        $current_data = $current_result->fetch_assoc();
        $current_stmt->close();

        // Kiểm tra xem có thay đổi gì không
        if ($current_data['Tenpb'] == $tenpb && $current_data['Mota'] == $mota) {
            $_SESSION['update_error'] = "Không có thay đổi nào được thực hiện!";
            header("location: form_capnhat.php?idpb=" . urlencode($idpb));
            exit();
        }

        // Kiểm tra tên phòng ban đã tồn tại chưa (ngoại trừ phòng ban hiện tại)
        $check_sql = "SELECT IDPB FROM phongban WHERE Tenpb = ? AND IDPB != ?";
        if ($check_stmt = $conn->prepare($check_sql)) {
            $check_stmt->bind_param("ss", $tenpb, $idpb);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            
            if ($check_result->num_rows > 0) {
                $_SESSION['update_error'] = "Tên phòng ban đã tồn tại! Vui lòng chọn tên khác.";
                $check_stmt->close();
                $conn->close();
                header("location: form_capnhat.php?idpb=" . urlencode($idpb));
                exit();
            } else {
                $sql = "UPDATE phongban SET Tenpb = ?, Mota = ? WHERE IDPB = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("sss", $tenpb, $mota, $idpb);
                    if ($stmt->execute()) {
                        $_SESSION['update_success'] = "Cập nhật thông tin phòng ban thành công!";
                        header("location: capnhat.php");
                        exit();
                    } else {
                        $_SESSION['update_error'] = "Có lỗi xảy ra khi cập nhật!";
                        header("location: form_capnhat.php?idpb=" . urlencode($idpb));
                        exit();
                    }
                    $stmt->close();
                }
            }
            $check_stmt->close();
        }
    }
    $conn->close();
}
?>