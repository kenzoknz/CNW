<%@ page contentType="text/html; charset=UTF-8" %                                <td>${student.id}</td>
                                <td>${student.name}</td>
                                <td>${student.age}</td>
                                <td>${student.university}</td>
                                <td class="text-center actions">
                                    <a href="<%= request.getContextPath() %>/student?action=detail&id=${student.id}" class="btn btn-info">Xem</a>
                                    <a href="<%= request.getContextPath() %>/student?action=edit&id=${student.id}" class="btn btn-warning">Sửa</a>
                                    <a href="<%= request.getContextPath() %>/student?action=delete&id=${student.id}" class="btn btn-danger" 
                                       onclick="return confirm('Bạn có chắc muốn xóa sinh viên ${student.name}?')">Xóa</a>glib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html>
<head>
    <title>Tìm Kiếm Sinh Viên</title>
    <link rel="stylesheet" href="<%= request.getContextPath() %>/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Tìm Kiếm Sinh Viên</h1>
        
        <div class="search-box">
            <form action="<%= request.getContextPath() %>/student" method="get">
                <input type="hidden" name="action" value="search">
                
                <div class="form-group">
                    <label for="keyword">Từ khóa tìm kiếm (Mã SV, Họ tên hoặc Trường):</label>
                    <input type="text" id="keyword" name="keyword" 
                           value="${param.keyword}" placeholder="Nhập từ khóa...">
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="<%= request.getContextPath() %>/student?action=list" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
        
        <c:if test="${not empty param.keyword}">
            <c:choose>
                <c:when test="${empty students}">
                    <div class="message info">Không tìm thấy sinh viên nào với từ khóa "<strong>${param.keyword}</strong>"</div>
                </c:when>
                <c:otherwise>
                    <h2>Kết quả tìm kiếm: <span style="color: #007bff;">${students.size()}</span> sinh viên</h2>
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
                                    <td style="text-align: center;" class="actions">
                                        <a href="<%= request.getContextPath() %>/student?action=detail&id=${student.id}" class="btn btn-info">👁️ Xem</a>
                                        <a href="<%= request.getContextPath() %>/student?action=edit&id=${student.id}" class="btn btn-warning">✏️ Sửa</a>
                                        <a href="<%= request.getContextPath() %>/student?action=delete&id=${student.id}" class="btn btn-danger" 
                                           onclick="return confirm('Bạn có chắc muốn xóa sinh viên ${student.name}?')">🗑️ Xóa</a>
                                    </td>
                                </tr>
                            </c:forEach>
                        </tbody>
                    </table>
                </c:otherwise>
            </c:choose>
        </c:if>
    </div>
</body>
</html>
