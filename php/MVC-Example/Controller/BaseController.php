<?php
/**
 * Base Controller
 */

namespace Controller;

class BaseController
{
    protected $pdo;
    protected $view_data = [];
    protected $message = '';
    protected $messageType = 'success'; // success, error, warning, info

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Render view
     */
    protected function render($viewName, $data = [])
    {
        $this->view_data = array_merge($this->view_data, $data);
        
        // Tạo các biến từ array view_data
        foreach ($this->view_data as $key => $value) {
            $$key = $value;
        }

        // Thêm message nếu có
        if ($this->message) {
            $message = $this->message;
            $messageType = $this->messageType;
        }

        // Include view file
        $viewPath = __DIR__ . '/../View/' . $viewName . '.php';
        
        if (!file_exists($viewPath)) {
            http_response_code(404);
            die("View không tìm thấy: " . $viewPath);
        }
        
        include $viewPath;
    }

    /**
     * Set message
     */
    protected function setMessage($type = 'success', $message = '')
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }

    /**
     * Redirect
     */
    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    /**
     * Json response
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
