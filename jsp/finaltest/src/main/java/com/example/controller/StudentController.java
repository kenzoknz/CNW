package com.example.controller;

import com.example.model.bean.Student;
import com.example.model.bo.StudentBO;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.List;

public class StudentController extends HttpServlet {
    private StudentBO studentBO;

    @Override
    public void init() {
        studentBO = new StudentBO();
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        String action = request.getParameter("action");
        
        if (action == null) {
            action = "list";
        }
        
        switch (action) {
            case "list":
                listStudents(request, response);
                break;
            case "add":
                showAddForm(request, response);
                break;
            case "edit":
                showEditForm(request, response);
                break;
            case "delete":
                deleteStudent(request, response);
                break;
            case "detail":
                showDetail(request, response);
                break;
            case "search":
                searchStudents(request, response);
                break;
            case "checkid":
                checkId(request, response);
                break;
            default:
                listStudents(request, response);
                break;
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        request.setCharacterEncoding("UTF-8");
        String action = request.getParameter("action");
        
        if (action == null) {
            action = "list";
        }
        
        switch (action) {
            case "add":
                addStudent(request, response);
                break;
            case "edit":
                updateStudent(request, response);
                break;
            default:
                listStudents(request, response);
                break;
        }
    }

    private void listStudents(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        List<Student> students = studentBO.getAllStudents();
        request.setAttribute("students", students);
        request.getRequestDispatcher("/view/studentList.jsp").forward(request, response);
    }

    private void showAddForm(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        request.getRequestDispatcher("/view/addStudent.jsp").forward(request, response);
    }

    private void showEditForm(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String id = request.getParameter("id");
        Student student = studentBO.getStudentById(id);
        request.setAttribute("student", student);
        request.getRequestDispatcher("/view/editStudent.jsp").forward(request, response);
    }

    private void showDetail(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String id = request.getParameter("id");
        Student student = studentBO.getStudentById(id);
        request.setAttribute("student", student);
        request.getRequestDispatcher("/view/studentDetail.jsp").forward(request, response);
    }

    private void addStudent(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String id = request.getParameter("id");
        String name = request.getParameter("name");
        int age = Integer.parseInt(request.getParameter("age"));
        String university = request.getParameter("university");

        Student student = new Student(id, name, age, university);
        boolean success = studentBO.addStudent(student);
        
        if (success) {
            request.setAttribute("message", "Thêm sinh viên thành công!");
        } else {
            request.setAttribute("error", "Thêm sinh viên thất bại!");
        }
        
        response.sendRedirect(request.getContextPath() + "/student?action=list");
    }

    private void updateStudent(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String id = request.getParameter("id");
        String name = request.getParameter("name");
        int age = Integer.parseInt(request.getParameter("age"));
        String university = request.getParameter("university");

        Student student = new Student(id, name, age, university);
        boolean success = studentBO.updateStudent(student);
        
        if (success) {
            request.setAttribute("message", "Cập nhật thành công!");
        } else {
            request.setAttribute("error", "Cập nhật thất bại!");
        }
        
        response.sendRedirect(request.getContextPath() + "/student?action=detail&id=" + id);
    }

    private void deleteStudent(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String id = request.getParameter("id");
        studentBO.deleteStudent(id);
        response.sendRedirect(request.getContextPath() + "/student?action=list");
    }

    private void searchStudents(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String keyword = request.getParameter("keyword");
        List<Student> students = studentBO.searchStudents(keyword);
        request.setAttribute("students", students);
        request.setAttribute("keyword", keyword);
        request.getRequestDispatcher("/view/searchStudent.jsp").forward(request, response);
    }

    private void checkId(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("application/json");
        response.setCharacterEncoding("UTF-8");
        
        String id = request.getParameter("id");
        boolean exists = studentBO.checkIdExists(id);
        
        String json = "{\"exists\": " + exists + "}";
        response.getWriter().write(json);
    }
}
