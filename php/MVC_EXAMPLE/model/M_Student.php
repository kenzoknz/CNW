<?php
include_once("E_Student.php");
class Model_Student {
    public function __construct(){}
    public function getAllStudents(){
        $link = mysqli_connect("localhost", "root", "", "dulieu");
        $query = "SELECT * FROM students";
        $result = mysqli_query($link, $query);
        $i = 0;
        while ($row = mysqli_fetch_array($result)){
            $student = new Entity_Student($row['id'], $row['name'], $row['age'], $row['university']);
            $students[$i++] = $student; 
        }
        return $students;
    }
    public function getStudentDetail($stid){
        $allStudents = $this->getAllStudents();
        return $allStudents[$stid];
    }

}

?>