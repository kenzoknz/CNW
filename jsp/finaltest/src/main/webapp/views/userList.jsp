<%@ page contentType="text/html; charset=UTF-8" %>
<%@ page import="java.util.List" %>
<%@ page import="com.example.model.User" %>
<!DOCTYPE html>
<html>
<head>
    <title>Danh sách User</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f0f0f0; }
        .container { background: white; padding: 30px; border-radius: 8px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #333; color: white; padding: 12px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f5f5f5; }
        a { color: #007bff; text-decoration: none; margin-right: 10px; }
        a:hover { text-decoration: underline; }
        .btn { padding: 8px 15px; background: #28a745; color: white; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Danh sách User</h1>
        <a href="<%= request.getContextPath() %>/user/add" class="btn">+ Thêm User</a>
        <a href="<%= request.getContextPath() %>/">Trang chủ</a>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Thao tác</th>
            </tr>
            <%
                List<User> users = (List<User>) request.getAttribute("users");
                if (users != null) {
                    for (User user : users) {
            %>
            <tr>
                <td><%= user.getId() %></td>
                <td><%= user.getName() %></td>
                <td><%= user.getEmail() %></td>
                <td>
                    <a href="<%= request.getContextPath() %>/user/delete/<%= user.getId() %>" 
                       onclick="return confirm('Xóa user này?')">Xóa</a>
                </td>
            </tr>
            <%
                    }
                }
            %>
        </table>
    </div>
</body>
</html>
