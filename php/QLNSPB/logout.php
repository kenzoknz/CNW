<?php
// Khởi tạo session
session_start();
 
// Hủy tất cả các biến session
$_SESSION = array();
 
// Hủy session
session_destroy();
 
// Chuyển hướng về trang đăng nhập
header("location: login.php");
exit;
?>