package com.example.controller;

import com.example.model.User;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class UserController extends HttpServlet {
    private static List<User> users = new ArrayList<>();

    static {
        users.add(new User(1, "Nguyen Van A", "a@example.com"));
        users.add(new User(2, "Tran Thi B", "b@example.com"));
        users.add(new User(3, "Le Van C", "c@example.com"));
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        String pathInfo = request.getPathInfo();
        
        if (pathInfo == null || pathInfo.equals("/")) {
            listUsers(request, response);
        } else if (pathInfo.equals("/add")) {
            request.getRequestDispatcher("/views/addUser.jsp").forward(request, response);
        } else if (pathInfo.startsWith("/delete/")) {
            int id = Integer.parseInt(pathInfo.substring(8));
            deleteUser(id);
            response.sendRedirect(request.getContextPath() + "/user/");
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        String name = request.getParameter("name");
        String email = request.getParameter("email");
        
        int newId = users.size() > 0 ? users.get(users.size() - 1).getId() + 1 : 1;
        users.add(new User(newId, name, email));
        
        response.sendRedirect(request.getContextPath() + "/user/");
    }

    private void listUsers(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        request.setAttribute("users", users);
        request.getRequestDispatcher("/views/userList.jsp").forward(request, response);
    }

    private void deleteUser(int id) {
        users.removeIf(u -> u.getId() == id);
    }
}
