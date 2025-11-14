<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html>
<head>
    <title>Chi Tiết Sinh Viên</title>
    <link rel="stylesheet" href="<%= request.getContextPath() %>/css/style.css">
</head>
<body>
    <div class="container container-small">
        <h1>Chi Tiết Sinh Viên</h1>
        
        <c:if test="${empty student}">
            <div class="message error">Không tìm thấy sinh viên!</div>
            <div class="button-group">
                <a href="<%= request.getContextPath() %>/student?action=list" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </c:if>
        
        <c:if test="${not empty student}">
            <div class="detail-box">
                <div class="detail-row">
                    <span class="label">Mã sinh viên:</span>
                    <span class="value">${student.id}</span>
                </div>
                
                <div class="detail-row">
                    <span class="label">Họ tên:</span>
                    <span class="value">${student.name}</span>
                </div>
                
                <div class="detail-row">
                    <span class="label">Tuổi:</span>
                    <span class="value">${student.age}</span>
                </div>
                
                <div class="detail-row">
                    <span class="label">Trường:</span>
                    <span class="value">
                        <c:choose>
                            <c:when test="${empty student.university or student.university eq ''}">
                                <i class="text-muted">(Chưa cập nhật)</i>
                            </c:when>
                            <c:otherwise>
                                ${student.university}
                            </c:otherwise>
                        </c:choose>
                    </span>
                </div>
            </div>
            
            <div class="button-group">
                <a href="<%= request.getContextPath() %>/student?action=list" class="btn btn-primary">Danh sách</a>
                <a href="<%= request.getContextPath() %>/student?action=edit&id=${student.id}" class="btn btn-warning">Sửa</a>
                <a href="<%= request.getContextPath() %>/student?action=delete&id=${student.id}" class="btn btn-danger" 
                   onclick="return confirm('Bạn có chắc muốn xóa sinh viên ${student.name}?')">Xóa</a>
            </div>
        </c:if>
    </div>
</body>
</html>
