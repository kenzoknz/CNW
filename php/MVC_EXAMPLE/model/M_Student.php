<?php
include_once("E_Student.php");
class Model_Student
{
    public function __construct()
    {
    }
    public function getAllStudents()
    {
        $link = mysqli_connect("localhost", "root", "", "dulieu");
        $query = "SELECT * FROM sinhvien";
        $result = mysqli_query($link, $query);
        $students = array();
        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            $student = new Entity_Student($row['id'], $row['name'], $row['age'], $row['university']);
            $students[$i++] = $student;
        }
        mysqli_close($link);
        return $students;
    }
    public function getStudentDetail($stid)
    {
        $link = mysqli_connect("localhost", "root", "", "dulieu");
        $query = "SELECT * FROM sinhvien WHERE id = " . intval($stid);
        $result = mysqli_query($link, $query);
        if ($row = mysqli_fetch_array($result)) {
            $student = new Entity_Student($row['id'], $row['name'], $row['age'], $row['university']);
            mysqli_close($link);
            return $student;
        }
        mysqli_close($link);
        return null;
    }


    public function insertStudent($id, $name, $age, $university)
    {
        $link = mysqli_connect("localhost", "root", "", "dulieu");


        $query = "INSERT INTO sinhvien (id, name, age, university) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "ssis", $id, $name, $age, $university);


            $result = mysqli_stmt_execute($stmt);


            mysqli_stmt_close($stmt);
            mysqli_close($link);

            return $result;
        } else {
            mysqli_close($link);
            return false;
        }
    }


    public function isIdExists($id)
    {
        $link = mysqli_connect("localhost", "root", "", "dulieu");
        $query = "SELECT COUNT(*) as count FROM sinhvien WHERE id = ?";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);
            mysqli_close($link);

            return $row['count'] > 0;
        }

        mysqli_close($link);
        return false;
    }


    public function searchStudents($searchField, $searchBy)
    {
        $link = mysqli_connect("localhost", "root", "", "dulieu");


        $allowedFields = array('id', 'name', 'age', 'university');
        if (!in_array($searchBy, $allowedFields)) {
            mysqli_close($link);
            return array();
        }


        if ($searchBy == 'age') {

            $query = "SELECT * FROM sinhvien WHERE $searchBy = ?";
            $stmt = mysqli_prepare($link, $query);

            if ($stmt) {
                $ageValue = intval($searchField);
                mysqli_stmt_bind_param($stmt, "i", $ageValue);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $students = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $student = new Entity_Student($row['id'], $row['name'], $row['age'], $row['university']);
                    $students[] = $student;
                }

                mysqli_stmt_close($stmt);
                mysqli_close($link);
                return $students;
            }
        } else {

            $query = "SELECT * FROM sinhvien WHERE $searchBy LIKE ?";
            $stmt = mysqli_prepare($link, $query);

            if ($stmt) {
                $likeSearchField = "%" . $searchField . "%";
                mysqli_stmt_bind_param($stmt, "s", $likeSearchField);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $students = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $student = new Entity_Student($row['id'], $row['name'], $row['age'], $row['university']);
                    $students[] = $student;
                }

                mysqli_stmt_close($stmt);
                mysqli_close($link);
                return $students;
            }
        }

        mysqli_close($link);
        return array();
    }


    public function updateStudent($id, $name, $age, $university)
    {
        $link = mysqli_connect("localhost", "root", "", "dulieu");


        $query = "UPDATE sinhvien SET name = ?, age = ?, university = ? WHERE id = ?";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "siss", $name, $age, $university, $id);


            $result = mysqli_stmt_execute($stmt);


            mysqli_stmt_close($stmt);
            mysqli_close($link);

            return $result;
        } else {
            mysqli_close($link);
            return false;
        }
    }


    public function deleteStudent($id)
    {
        $link = mysqli_connect("localhost", "root", "", "dulieu");


        $query = "DELETE FROM sinhvien WHERE id = ?";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "s", $id);


            $result = mysqli_stmt_execute($stmt);


            mysqli_stmt_close($stmt);
            mysqli_close($link);

            return $result;
        } else {
            mysqli_close($link);
            return false;
        }
    }

}

?>