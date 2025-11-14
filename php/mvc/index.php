<?php
// File: index.php (Front Controller)

// Nạp file cấu hình
require_once 'config/database.php';

// Xác định controller và action từ URL
$controllerName = isset($_GET['controller']) ? 'C_' . ucfirst($_GET['controller']) : 'C_Student';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// Tạo đường dẫn đến file controller
$controllerFile = 'controllers/' . $controllerName . '.php';

// Kiểm tra file controller có tồn tại không
if (file_exists($controllerFile)) {
    // Nhúng file controller
    require_once $controllerFile;

    // Kiểm tra class controller có tồn tại không
    if (class_exists($controllerName)) {
        // Tạo đối tượng controller
        $controller = new $controllerName();

        // Kiểm tra phương thức (action) có tồn tại trong class không
        if (method_exists($controller, $actionName)) {
            // Gọi action
            $controller->$actionName();
        } else {
            echo "Action không tồn tại!";
        }
    } else {
        echo "Controller class không tồn tại!";
    }
} else {
    echo "Controller file không tồn tại!";
}
?>