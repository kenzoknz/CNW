<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html>
<head>
    <title>Sửa Thông Tin Sinh Viên</title>
    <link rel="stylesheet" href="<%= request.getContextPath() %>/css/style.css">
    <script>
        function validateForm() {
            var name = document.getElementById('name').value.trim();
            var age = document.getElementById('age').value;
            
            if (name === '' || age === '') {
                alert('Vui lòng điền đầy đủ thông tin!');
                return false;
            }
            
            if (age < 16 || age > 100) {
                alert('Tuổi phải từ 16 đến 100!');
                return false;
            }
            
            return true;
        }
    </script>
</head>
<body>
    <div class="container container-small">
        <h1>Sửa Thông Tin Sinh Viên</h1>
        
        <c:if test="${not empty error}">
            <div class="message error">${error}</div>
        </c:if>
        
        <c:if test="${empty student}">
            <div class="message error">Không tìm thấy sinh viên!</div>
            <div class="button-group">
                <a href="<%= request.getContextPath() %>/student?action=list" class="btn btn-secondary">Quay lại</a>
            </div>
        </c:if>
        
        <c:if test="${not empty student}">
            <form action="<%= request.getContextPath() %>/student?action=edit" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="id">Mã sinh viên:</label>
                    <input type="text" id="id" name="id" value="${student.id}" disabled>
                    <input type="hidden" name="id" value="${student.id}">
                </div>
                
                <div class="form-group">
                    <label for="name">Họ tên: <span class="required">*</span></label>
                    <input type="text" id="name" name="name" required 
                           value="${student.name}" placeholder="Nhập họ tên sinh viên">
                </div>
                
                <div class="form-group">
                    <label for="age">Tuổi: <span class="required">*</span></label>
                    <input type="number" id="age" name="age" required min="16" max="100" 
                           value="${student.age}" placeholder="Nhập tuổi (16-100)">
                </div>
                
                <div class="form-group">
                    <label for="university">Trường:</label>
                    <input type="text" id="university" name="university" 
                           value="${student.university}" placeholder="Nhập tên trường (không bắt buộc)">
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="<%= request.getContextPath() %>/student?action=list" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </c:if>
    </div>
</body>
</html>
