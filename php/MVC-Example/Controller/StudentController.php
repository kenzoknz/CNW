<?php

namespace Controller;

use Controller\BaseController;
use Model\DAO\StudentDAO;
use Model\Entity\Student;
use Service\ValidationService;

/**
 * StudentController - Handles all student-related operations
 */
class StudentController extends BaseController
{
    private $studentDAO;
    private $validator;

    public function __construct($pdo)
    {
        parent::__construct($pdo);
        $this->studentDAO = new StudentDAO($pdo);
        $this->validator = new ValidationService();
    }

    /**
     * List all students
     */
    public function index()
    {
        try {
            $students = $this->studentDAO->getAll();
            $this->render('StudentList', [
                'students' => $students
            ]);
        } catch (\PDOException $e) {
            $this->setMessage('error', 'Lỗi: ' . $e->getMessage());
            $this->render('StudentList', ['students' => []]);
        }
    }

    /**
     * Show create form
     */
    public function create()
    {
        $this->render('StudentCreate');
    }

    /**
     * Store new student
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=create');
            return;
        }

        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $age = $_POST['age'] ?? '';
        $university = $_POST['university'] ?? '';

        // Validate input
        $this->validator->clear();
        $this->validator->required($id, 'Mã sinh viên');
        $this->validator->required($name, 'Tên sinh viên');
        $this->validator->required($age, 'Tuổi');
        $this->validator->required($university, 'Trường đại học');
        
        if ($this->validator->hasErrors()) {
            $errors = $this->validator->getErrors();
            $this->setMessage('error', 'Vui lòng kiểm tra lại dữ liệu');
            $this->render('StudentCreate', [
                'errors' => $errors,
                'input' => ['id' => $id, 'name' => $name, 'age' => $age, 'university' => $university]
            ]);
            return;
        }

        // Create student
        $student = new Student($id, $name, $age, $university);
        try {
            if ($this->studentDAO->create($student)) {
                $this->setMessage('success', 'Thêm sinh viên thành công!');
                $this->redirect('index.php?action=view');
            } else {
                $this->setMessage('error', 'Lỗi: Không thể thêm sinh viên!');
                $this->render('StudentCreate', [
                    'input' => ['id' => $id, 'name' => $name, 'age' => $age, 'university' => $university]
                ]);
            }
        } catch (\PDOException $e) {
            $this->setMessage('error', 'Lỗi: ' . $e->getMessage());
            $this->render('StudentCreate', [
                'input' => ['id' => $id, 'name' => $name, 'age' => $age, 'university' => $university]
            ]);
        }
    }

    /**
     * Show search form and handle search
     */
    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            
            if (!$id) {
                $this->setMessage('error', 'Vui lòng nhập mã sinh viên');
                $this->render('StudentSearch');
                return;
            }

            try {
                $student = $this->studentDAO->read($id);
                if ($student) {
                    $this->render('StudentSearchResult', [
                        'student' => $student
                    ]);
                } else {
                    $this->setMessage('error', 'Không tìm thấy sinh viên!');
                    $this->render('StudentSearch');
                }
            } catch (\PDOException $e) {
                $this->setMessage('error', 'Lỗi: ' . $e->getMessage());
                $this->render('StudentSearch');
            }
        } else {
            $this->render('StudentSearch');
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        try {
            $student = $this->studentDAO->read($id);
            if (!$student) {
                $this->setMessage('error', 'Sinh viên không tồn tại!');
                $this->redirect('index.php?action=view');
                return;
            }

            $this->render('StudentUpdate', [
                'student' => $student
            ]);
        } catch (\PDOException $e) {
            $this->setMessage('error', 'Lỗi: ' . $e->getMessage());
            $this->redirect('index.php?action=view');
        }
    }

    /**
     * Update student
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=edit&id=' . $id);
            return;
        }

        try {
            $student = $this->studentDAO->read($id);
            if (!$student) {
                $this->setMessage('error', 'Sinh viên không tồn tại!');
                $this->redirect('index.php?action=view');
                return;
            }

            $name = $_POST['name'] ?? '';
            $age = $_POST['age'] ?? '';
            $university = $_POST['university'] ?? '';

            // Validate input
            $this->validator->clear();
            $this->validator->required($name, 'Tên sinh viên');
            $this->validator->required($age, 'Tuổi');
            $this->validator->required($university, 'Trường đại học');
            
            if ($this->validator->hasErrors()) {
                $errors = $this->validator->getErrors();
                $this->setMessage('error', 'Vui lòng kiểm tra lại dữ liệu');
                $this->render('StudentUpdate', [
                    'student' => $student,
                    'errors' => $errors,
                    'input' => ['name' => $name, 'age' => $age, 'university' => $university]
                ]);
                return;
            }

            // Update student
            $updatedStudent = new Student($id, $name, $age, $university);
            if ($this->studentDAO->update($updatedStudent)) {
                $this->setMessage('success', 'Cập nhật thông tin sinh viên thành công!');
                $this->redirect('index.php?action=view');
            } else {
                $this->setMessage('error', 'Lỗi: Không thể cập nhật!');
                $this->render('StudentUpdate', [
                    'student' => $student,
                    'input' => ['name' => $name, 'age' => $age, 'university' => $university]
                ]);
            }
        } catch (\PDOException $e) {
            $this->setMessage('error', 'Lỗi: ' . $e->getMessage());
            $this->redirect('index.php?action=view');
        }
    }

    /**
     * Show delete form
     */
    public function delete()
    {
        try {
            $students = $this->studentDAO->getAll();
            $this->render('StudentDelete', [
                'students' => $students
            ]);
        } catch (\PDOException $e) {
            $this->setMessage('error', 'Lỗi: ' . $e->getMessage());
            $this->render('StudentDelete', ['students' => []]);
        }
    }

    /**
     * Delete student
     */
    public function destroy($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=delete');
            return;
        }

        try {
            // Handle bulk delete from form
            if (isset($_POST['ids']) && is_array($_POST['ids']) && !empty($_POST['ids'])) {
                $deletedCount = 0;
                $failedCount = 0;
                
                foreach ($_POST['ids'] as $studentId) {
                    try {
                        if ($this->studentDAO->delete($studentId)) {
                            $deletedCount++;
                        } else {
                            $failedCount++;
                        }
                    } catch (\PDOException $e) {
                        $failedCount++;
                    }
                }
                
                if ($deletedCount > 0) {
                    $this->setMessage('success', "Đã xóa $deletedCount sinh viên thành công!");
                }
                if ($failedCount > 0) {
                    $this->setMessage('error', "Lỗi: $failedCount sinh viên không xóa được!");
                }
                
                $this->redirect('index.php?action=view');
                return;
            }

            // Handle single delete by ID parameter
            if (!$id && isset($_POST['id'])) {
                $id = $_POST['id'];
            }

            if (!$id) {
                $this->setMessage('error', 'Vui lòng chọn sinh viên để xóa');
                $this->redirect('index.php?action=delete');
                return;
            }

            $student = $this->studentDAO->read($id);
            if (!$student) {
                $this->setMessage('error', 'Sinh viên không tồn tại!');
                $this->redirect('index.php?action=view');
                return;
            }

            if ($this->studentDAO->delete($id)) {
                $this->setMessage('success', 'Xóa sinh viên thành công!');
                $this->redirect('index.php?action=view');
            } else {
                $this->setMessage('error', 'Lỗi: Không thể xóa!');
                $this->redirect('index.php?action=view');
            }
        } catch (\PDOException $e) {
            $this->setMessage('error', 'Lỗi: ' . $e->getMessage());
            $this->redirect('index.php?action=view');
        }
    }
}


