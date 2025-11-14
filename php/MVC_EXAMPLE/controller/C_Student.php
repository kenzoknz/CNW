<?php
include_once("../model/M_Student.php");
class Ctrl_Student
{
    public function invoke()
    {

        if (isset($_GET['action']) && $_GET['action'] == 'add') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $this->addStudent();
            } else {

                include_once("../view/InsertStudent.html");
            }
        } else if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $this->updateStudent();
            } else {

                if (isset($_GET['stid'])) {
                    $modelStudent = new Model_Student();
                    $student = $modelStudent->getStudentDetail($_GET['stid']);
                    include_once("../view/EditStudent.html");
                } else {
                    header("Location: C_Student.php");
                    exit();
                }
            }
        } else if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            if (isset($_GET['stid'])) {
                $modelStudent = new Model_Student();
                $student = $modelStudent->getStudentDetail($_GET['stid']);
                include_once("../view/DeleteStudent.html");
            } else {
                header("Location: C_Student.php");
                exit();
            }
        } else if (isset($_GET['action']) && $_GET['action'] == 'confirmdelete') {
            if (isset($_GET['stid'])) {
                $this->confirmDeleteStudent($_GET['stid']);
            } else {
                header("Location: C_Student.php");
                exit();
            }
        }

        // Kiểm tra action AJAX check ID
        else if (isset($_GET['action']) && $_GET['action'] == 'checkid') {
            $this->checkIdExists();
        }
        // Kiểm tra action tìm kiếm
        else if (isset($_GET['action']) && $_GET['action'] == 'search') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $this->searchStudent();
            } else {

                include_once("../view/SearchStudent.html");
            }
        } else if (isset($_GET['stid'])) {
            $modelStudent = new Model_Student();
            $student = $modelStudent->getStudentDetail($_GET['stid']);
            include_once("../view/StudentDetail.html");
        } else {
            $modelStudent = new Model_Student();
            $allStudents = $modelStudent->getAllStudents();
            include_once("../view/StudentList.html");
        }
    }


    private function addStudent()
    {

        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
        $university = isset($_POST['university']) ? trim($_POST['university']) : '';


        $errors = array();
        if (empty($id)) {
            $errors[] = "ID sinh viên không được để trống";
        }
        if (empty($name)) {
            $errors[] = "Họ và tên không được để trống";
        }
        if ($age < 16 || $age > 100) {
            $errors[] = "Tuổi phải từ 16 đến 100";
        }
        if (empty($university)) {
            $errors[] = "Trường đại học không được để trống";
        }


        if (!empty($id)) {
            $modelStudent = new Model_Student();
            if ($modelStudent->isIdExists($id)) {
                $errors[] = "ID sinh viên '$id' đã tồn tại";
            }
        }


        if (!empty($errors)) {
            $errorMessage = implode("<br>", $errors);
            include_once("../view/InsertStudent.html");
            echo "<script>alert('Có lỗi:\\n" . str_replace("<br>", "\\n", $errorMessage) . "');</script>";
            return;
        }


        $modelStudent = new Model_Student();
        $result = $modelStudent->insertStudent($id, $name, $age, $university);

        if ($result) {

            header("Location: C_Student.php");
            exit();
        } else {

            include_once("../view/InsertStudent.html");
            echo "<script>alert('Có lỗi xảy ra khi thêm sinh viên. Vui lòng thử lại.');</script>";
        }
    }


    private function searchStudent()
    {

        $searchField = isset($_POST['searchField']) ? trim($_POST['searchField']) : '';
        $searchBy = isset($_POST['searchBy']) ? trim($_POST['searchBy']) : '';


        $errors = array();
        if (empty($searchField)) {
            $errors[] = "Từ khóa tìm kiếm không được để trống";
        }
        if (empty($searchBy)) {
            $errors[] = "Vui lòng chọn tiêu chí tìm kiếm";
        }


        $allowedFields = array('id', 'name', 'age', 'university');
        if (!in_array($searchBy, $allowedFields)) {
            $errors[] = "Tiêu chí tìm kiếm không hợp lệ";
        }


        if ($searchBy == 'age' && !is_numeric($searchField)) {
            $errors[] = "Khi tìm theo tuổi, vui lòng nhập số";
        }


        if (!empty($errors)) {
            $errorMessage = implode("<br>", $errors);
            include_once("../view/SearchStudent.html");
            echo "<script>alert('Có lỗi:\\n" . str_replace("<br>", "\\n", $errorMessage) . "');</script>";
            return;
        }


        $modelStudent = new Model_Student();
        $searchResults = $modelStudent->searchStudents($searchField, $searchBy);


        $searchKeyword = $searchField;
        $searchCriteria = $searchBy;


        include_once("../view/SearchStudent.html");
    }


    private function updateStudent()
    {

        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
        $university = isset($_POST['university']) ? trim($_POST['university']) : '';


        $errors = array();
        if (empty($id)) {
            $errors[] = "ID sinh viên không được để trống";
        }
        if (empty($name)) {
            $errors[] = "Họ và tên không được để trống";
        }
        if ($age < 16 || $age > 100) {
            $errors[] = "Tuổi phải từ 16 đến 100";
        }
        if (empty($university)) {
            $errors[] = "Trường đại học không được để trống";
        }


        if (!empty($errors)) {
            $errorMessage = implode("<br>", $errors);
            $modelStudent = new Model_Student();
            $student = $modelStudent->getStudentDetail($id);
            include_once("../view/EditStudent.html");
            echo "<script>alert('Có lỗi:\\n" . str_replace("<br>", "\\n", $errorMessage) . "');</script>";
            return;
        }


        $modelStudent = new Model_Student();
        $result = $modelStudent->updateStudent($id, $name, $age, $university);

        if ($result) {

            header("Location: C_Student.php?stid=" . urlencode($id));
            exit();
        } else {

            $student = $modelStudent->getStudentDetail($id);
            include_once("../view/EditStudent.html");
            echo "<script>alert('Có lỗi xảy ra khi cập nhật thông tin sinh viên. Vui lòng thử lại.');</script>";
        }
    }


    private function confirmDeleteStudent($studentId)
    {

        $modelStudent = new Model_Student();
        $student = $modelStudent->getStudentDetail($studentId);

        if ($student == null) {
            header("Location: C_Student.php");
            exit();
        }


        $result = $modelStudent->deleteStudent($studentId);

        if ($result) {

            echo "<script>
                alert('Đã xóa sinh viên \"" . addslashes($student->getName()) . "\" thành công!');
                window.location.href = 'C_Student.php';
            </script>";
        } else {

            echo "<script>
                alert('Có lỗi xảy ra khi xóa sinh viên. Vui lòng thử lại.');
                window.location.href = 'C_Student.php';
            </script>";
        }
    }

    // Method kiểm tra ID tồn tại (AJAX)
    private function checkIdExists()
    {
        header('Content-Type: application/json');

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = trim($_GET['id']);
            $modelStudent = new Model_Student();
            $exists = $modelStudent->isIdExists($id);

            echo json_encode(['exists' => $exists]);
        } else {
            echo json_encode(['exists' => false]);
        }
        exit();
    }
}


$C_Student = new Ctrl_Student();
$C_Student->invoke();
?>