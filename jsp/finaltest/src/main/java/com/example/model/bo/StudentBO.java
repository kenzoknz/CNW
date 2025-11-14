package com.example.model.bo;

import com.example.model.bean.Student;
import com.example.model.dao.StudentDAO;
import java.util.List;
public class StudentBO {
    private StudentDAO studentDAO;

    public StudentBO() {
        this.studentDAO = new StudentDAO();
    }

    public List<Student> getAllStudents() {
        return studentDAO.selectAllStudents();
    }

    public Student getStudentById(String id) {
        return studentDAO.selectStudent(id);
    }

    public boolean addStudent(Student student) {
        // Validation logic
        if (student.getId() == null || student.getId().trim().isEmpty()) {
            return false;
        }
        if (student.getName() == null || student.getName().trim().isEmpty()) {
            return false;
        }
        if (student.getAge() < 16 || student.getAge() > 100) {
            return false;
        }
        if (studentDAO.checkIdExists(student.getId())) {
            return false;
        }
        return studentDAO.insertStudent(student);
    }

    public boolean updateStudent(Student student) {
        // Validation logic
        if (student.getId() == null || student.getId().trim().isEmpty()) {
            return false;
        }
        if (student.getName() == null || student.getName().trim().isEmpty()) {
            return false;
        }
        if (student.getAge() < 16 || student.getAge() > 100) {
            return false;
        }
        return studentDAO.updateStudent(student);
    }

    public boolean deleteStudent(String id) {
        if (id == null || id.trim().isEmpty()) {
            return false;
        }
        return studentDAO.deleteStudent(id);
    }

    public boolean checkIdExists(String id) {
        return studentDAO.checkIdExists(id);
    }

    public List<Student> searchStudents(String keyword) {
        List<Student> allStudents = studentDAO.selectAllStudents();
        if (keyword == null || keyword.trim().isEmpty()) {
            return allStudents;
        }
        
        List<Student> result = new java.util.ArrayList<>();
        String lowerKeyword = keyword.toLowerCase();
        for (Student student : allStudents) {
            if (student.getId().toLowerCase().contains(lowerKeyword) ||
                student.getName().toLowerCase().contains(lowerKeyword) ||
                student.getUniversity().toLowerCase().contains(lowerKeyword)) {
                result.add(student);
            }
        }
        return result;
    }
}
