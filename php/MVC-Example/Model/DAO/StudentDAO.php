<?php
// StudentDAO: Thực hiện các truy vấn cơ bản đối với Student entity
namespace Model\DAO;
use Model\Entity\Student;
use PDO;
use PDOException;

class StudentDAO
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Student $student)
    {
        try {
            $sql = "INSERT INTO sinhvien (id, name, age, university) VALUES (:id, :name, :age, :university)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $student->getId());
            $stmt->bindValue(':name', $student->getName());
            $stmt->bindValue(':age', $student->getAge());
            $stmt->bindValue(':university', $student->getUniversity());
            return $stmt->execute();
        } catch (PDOException $e) {
            // Bắt lỗi duplicate key (ID trùng)
            if ($e->getCode() == 23000) {
                throw new PDOException("Mã sinh viên '{$student->getId()}' đã tồn tại!");
            }
            throw new PDOException("Lỗi thêm sinh viên: " . $e->getMessage());
        }
    }

    public function read($id)
    {
        try {
            $sql = "SELECT * FROM sinhvien WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Student($row['id'], $row['name'], $row['age'], $row['university']);
            }
            return null;
        } catch (PDOException $e) {
            throw new PDOException("Lỗi tìm kiếm sinh viên: " . $e->getMessage());
        }
    }

    public function update(Student $student)
    {
        try {
            $sql = "UPDATE sinhvien SET name = :name, age = :age, university = :university WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $student->getId());
            $stmt->bindValue(':name', $student->getName());
            $stmt->bindValue(':age', $student->getAge());
            $stmt->bindValue(':university', $student->getUniversity());
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException("Lỗi cập nhật sinh viên: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM sinhvien WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException("Lỗi xóa sinh viên: " . $e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM sinhvien";
            $stmt = $this->pdo->query($sql);
            $sinhvien = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sinhvien[] = new Student($row['id'], $row['name'], $row['age'], $row['university']);
            }
            return $sinhvien;
        } catch (PDOException $e) {
            throw new PDOException("Lỗi lấy danh sách sinh viên: " . $e->getMessage());
        }
    }
}