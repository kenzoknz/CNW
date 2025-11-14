<?php
// File: controllers/C_Student.php - Controller Student

require_once 'models/M_Student.php';

class C_Student {
    private $model;

    public function __construct() {
        $this->model = new M_Student();
    }

    // Hiển thị danh sách sinh viên
    public function index() {
        $keyword = $_GET['keyword'] ?? '';
        $age = $_GET['age'] ?? '';
        
        // Nếu có tiêu chí tìm kiếm
        if ($keyword || $age) {
            $students = $this->model->searchStudents($keyword, $age);
        } else {
            $students = $this->model->getAllStudents();
        }
        include 'views/StudentList.html';
    }

    // Hiển thị trang tìm kiếm
    public function search() {
        $name = $_GET['name'] ?? '';
        $university = $_GET['university'] ?? '';
        $age = $_GET['age'] ?? '';
        $ageFrom = $_GET['age_from'] ?? '';
        $ageTo = $_GET['age_to'] ?? '';
        
        // Nếu có bất kỳ tiêu chí tìm kiếm nào
        if ($name || $university || $age || $ageFrom || $ageTo) {
            $students = $this->model->searchStudentsAdvanced($name, $university, $age, $ageFrom, $ageTo);
        }
        include 'views/SearchStudent.html';
    }

    // Hiển thị chi tiết sinh viên
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $student = $this->model->getStudentById($id);
        include 'views/StudentDetail.html';
    }

    // Hiển thị form thêm sinh viên
    public function add() {
        include 'views/AddStudent.html';
    }

    // Xử lý thêm sinh viên
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student = new E_Student(null, $_POST['name'], $_POST['age'], $_POST['university']);
            $this->model->addStudent($student);
            header('Location: index.php?success=add');
            exit;
        }
    }

    // Hiển thị form sửa sinh viên
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $student = $this->model->getStudentById($id);
        include 'views/EditStudent.html';
    }

    // Xử lý cập nhật sinh viên
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student = new E_Student($_POST['id'], $_POST['name'], $_POST['age'], $_POST['university']);
            $this->model->updateStudent($student);
            header('Location: index.php?success=update');
            exit;
        }
    }

    // Xóa sinh viên
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $student = $this->model->getStudentById($id);
        include 'views/DeleteStudent.html';
    }

    // Xác nhận xóa sinh viên
    public function confirmDelete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $this->model->deleteStudent($id);
            header('Location: index.php?success=delete');
            exit;
        }
    }
}
?>
