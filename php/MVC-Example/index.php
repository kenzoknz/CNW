<?php
/**
 * MVC-Example - Entry Point
 * File này là điểm vào của ứng dụng, xử lý routing và khởi tạo các component cần thiết
 */

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session start
session_start();

// Autoloader
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/';
    
    // Xác định thư mục dựa trên namespace
    if (strpos($class, 'Controller\\') === 0) {
        $relative_class = substr($class, strlen('Controller\\'));
        $file = $base_dir . 'Controller/' . str_replace('\\', '/', $relative_class) . '.php';
    } elseif (strpos($class, 'Model\\') === 0) {
        $relative_class = substr($class, strlen('Model\\'));
        $file = $base_dir . 'Model/' . str_replace('\\', '/', $relative_class) . '.php';
    } elseif (strpos($class, 'Service\\') === 0) {
        $relative_class = substr($class, strlen('Service\\'));
        $file = $base_dir . 'Service/' . str_replace('\\', '/', $relative_class) . '.php';
    } else {
        return false;
    }
    
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});

// Database configuration
require_once __DIR__ . '/config.php';

// Check for action parameter (legacy routing)
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $controller = new \Controller\StudentController($pdo);
    
    switch ($action) {
        case 'index':
        case 'view':
            $controller->index();
            break;
        case 'create':
            $controller->create();
            break;
        case 'store':
            $controller->store();
            break;
        case 'edit':
            $controller->edit($_GET['id'] ?? null);
            break;
        case 'update':
            $controller->update($_GET['id'] ?? null);
            break;
        case 'delete':
            $controller->delete();
            break;
        case 'destroy':
            $controller->destroy($_GET['id'] ?? null);
            break;
        case 'search':
            $controller->search();
            break;
        default:
            $controller->index();
    }
    exit;
}

// Default: show student list
$controller = new \Controller\StudentController($pdo);
$controller->index();
