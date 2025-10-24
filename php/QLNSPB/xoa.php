<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require 'config.php';

// Kiểm tra xem IDNV có được truyền qua không
if (isset($_GET['idnv'])) {
    $idnv = $_GET['idnv'];
    $sql = "DELETE FROM nhanvien WHERE IDNV = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $idnv);
        $stmt->execute();
        $stmt->close();
    }
}
$conn->close();
// Quay lại trang danh sách
header("location: xoatatca.php");
exit();
?>