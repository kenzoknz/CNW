<?php
// Start the session
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: xoatatca.php?message=Phương thức không hợp lệ");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "dulieu");
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    header("Location: xoatatca.php?message=Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
    exit();
}

$action = $_POST['action'] ?? '';
$delete_all = isset($_POST['delete_all']) && $_POST['delete_all'] == '1';

// Process based on action
if ($delete_all) {
    // Delete all employees
    $sql = "DELETE FROM nhanvien";
    if ($conn->query($sql)) {
        $affected = $conn->affected_rows;
        $conn->close();
        header("Location: xoatatca.php?message=Đã xóa tất cả nhân viên: $affected nhân viên đã bị xóa");
        exit();
    } else {
        $error = $conn->error;
        $conn->close();
        header("Location: xoatatca.php?message=Lỗi khi xóa tất cả nhân viên: $error");
        exit();
    }
} elseif ($action == "Xóa Đã Chọn" && isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {
    // Delete selected employees
    $selected_ids = $_POST['selected_ids'];
    
    // Sanitize IDs to prevent SQL injection
    $sanitized_ids = array();
    foreach ($selected_ids as $id) {
        $sanitized_ids[] = $conn->real_escape_string($id);
    }
    
    // Create a comma-separated list of IDs in single quotes
    $id_list = "'" . implode("','", $sanitized_ids) . "'";
    
    // Delete query
    $sql = "DELETE FROM nhanvien WHERE IDNV IN ($id_list)";
    if ($conn->query($sql)) {
        $affected = $conn->affected_rows;
        $conn->close();
        header("Location: xoatatca.php?message=Đã xóa thành công $affected nhân viên đã chọn");
        exit();
    } else {
        $error = $conn->error;
        $conn->close();
        header("Location: xoatatca.php?message=Lỗi khi xóa nhân viên đã chọn: $error");
        exit();
    }
} else {
    // No action or no selection
    $conn->close();
    header("Location: xoatatca.php?message=Không có hành động hoặc không có nhân viên nào được chọn");
    exit();
}
?>
