package com.example.model.dao;

import com.example.model.bean.Student;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class StudentDAO {
    private String jdbcURL = "jdbc:mysql://localhost:3306/dulieu";
    private String jdbcUsername = "root";
    private String jdbcPassword = "";

    private static final String SELECT_ALL_STUDENTS = "SELECT * FROM sinhvien";
    private static final String SELECT_STUDENT_BY_ID = "SELECT * FROM sinhvien WHERE id = ?";
    private static final String INSERT_STUDENT = "INSERT INTO sinhvien (id, name, age, university) VALUES (?, ?, ?, ?)";
    private static final String UPDATE_STUDENT = "UPDATE sinhvien SET name = ?, age = ?, university = ? WHERE id = ?";
    private static final String DELETE_STUDENT = "DELETE FROM sinhvien WHERE id = ?";
    private static final String CHECK_ID_EXISTS = "SELECT COUNT(*) FROM sinhvien WHERE id = ?";

    protected Connection getConnection() {
        Connection connection = null;
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            connection = DriverManager.getConnection(jdbcURL, jdbcUsername, jdbcPassword);
        } catch (SQLException | ClassNotFoundException e) {
            e.printStackTrace();
        }
        return connection;
    }

    public List<Student> selectAllStudents() {
        List<Student> students = new ArrayList<>();
        try (Connection connection = getConnection();
             PreparedStatement preparedStatement = connection.prepareStatement(SELECT_ALL_STUDENTS)) {
            ResultSet rs = preparedStatement.executeQuery();
            while (rs.next()) {
                String id = rs.getString("id");
                String name = rs.getString("name");
                int age = rs.getInt("age");
                String university = rs.getString("university");
                students.add(new Student(id, name, age, university));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return students;
    }

    public Student selectStudent(String id) {
        Student student = null;
        try (Connection connection = getConnection();
             PreparedStatement preparedStatement = connection.prepareStatement(SELECT_STUDENT_BY_ID)) {
            preparedStatement.setString(1, id);
            ResultSet rs = preparedStatement.executeQuery();
            if (rs.next()) {
                String name = rs.getString("name");
                int age = rs.getInt("age");
                String university = rs.getString("university");
                student = new Student(id, name, age, university);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return student;
    }

    public boolean insertStudent(Student student) {
        boolean rowInserted = false;
        try (Connection connection = getConnection();
             PreparedStatement preparedStatement = connection.prepareStatement(INSERT_STUDENT)) {
            preparedStatement.setString(1, student.getId());
            preparedStatement.setString(2, student.getName());
            preparedStatement.setInt(3, student.getAge());
            preparedStatement.setString(4, student.getUniversity());
            rowInserted = preparedStatement.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return rowInserted;
    }

    public boolean updateStudent(Student student) {
        boolean rowUpdated = false;
        try (Connection connection = getConnection();
             PreparedStatement preparedStatement = connection.prepareStatement(UPDATE_STUDENT)) {
            preparedStatement.setString(1, student.getName());
            preparedStatement.setInt(2, student.getAge());
            preparedStatement.setString(3, student.getUniversity());
            preparedStatement.setString(4, student.getId());
            rowUpdated = preparedStatement.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return rowUpdated;
    }

    public boolean deleteStudent(String id) {
        boolean rowDeleted = false;
        try (Connection connection = getConnection();
             PreparedStatement preparedStatement = connection.prepareStatement(DELETE_STUDENT)) {
            preparedStatement.setString(1, id);
            rowDeleted = preparedStatement.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return rowDeleted;
    }

    public boolean checkIdExists(String id) {
        try (Connection connection = getConnection();
             PreparedStatement preparedStatement = connection.prepareStatement(CHECK_ID_EXISTS)) {
            preparedStatement.setString(1, id);
            ResultSet rs = preparedStatement.executeQuery();
            if (rs.next()) {
                return rs.getInt(1) > 0;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }
}
