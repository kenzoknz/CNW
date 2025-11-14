<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html>
<head>
    <title>Danh Sách Sinh Viên</title>
    <link rel="stylesheet" href="<%= request.getContextPath() %>/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Danh Sách Sinh Viên</h1>
        
        <c:if test="${not empty message}">
            <div class="message success">${message}</div>
        </c:if>
        <c:if test="${not empty error}">
            <div class="message error">${error}</div>
        </c:if>
        
        <div class="toolbar">
            <a href="<%= request.getContextPath() %>/" class="btn btn-info">Trang chủ</a>
            <a href="<%= request.getContextPath() %>/student?action=add" class="btn btn-success">Thêm mới</a>
            <a href="<%= request.getContextPath() %>/student?action=search" class="btn btn-warning">Tìm kiếm</a>
        </div>
        
        <c:choose>
            <c:when test="${empty students}">
                <p class="empty-state">Không có sinh viên nào trong danh sách.</p>
            </c:when>
            <c:otherwise>
                <table>
                    <thead>
                        <tr>
                            <th>Mã SV</th>
                            <th>Họ tên</th>
                            <th>Tuổi</th>
                            <th>Trường</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <c:forEach var="student" items="${students}">
                            <tr>
                                <td>${student.id}</td>
                                <td>${student.name}</td>
                                <td>${student.age}</td>
                                <td>${student.university}</td>
                                <td class="text-center actions">
                                    <a href="<%= request.getContextPath() %>/student?action=detail&id=${student.id}" class="btn btn-info">Xem</a>
                                    <a href="<%= request.getContextPath() %>/student?action=edit&id=${student.id}" class="btn btn-warning">Sửa</a>
                                    <a href="<%= request.getContextPath() %>/student?action=delete&id=${student.id}" class="btn btn-danger" 
                                       onclick="return confirm('Bạn có chắc muốn xóa sinh viên ${student.name}?')">Xóa</a>
                                </td>
                            </tr>
                        </c:forEach>
                    </tbody>
                </table>
                <p class="text-center text-muted">Tổng số: <strong>${students.size()}</strong> sinh viên</p>
            </c:otherwise>
        </c:choose>
    </div>
</body>
</html>
