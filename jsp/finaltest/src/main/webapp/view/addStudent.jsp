<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html>
<head>
    <title>Thêm Sinh Viên</title>
    <link rel="stylesheet" href="<%= request.getContextPath() %>/css/style.css">
    <script>
        function checkIdExists() {
            var id = document.getElementById('id').value;
            var errorDiv = document.getElementById('idError');
            
            if (id.trim() === '') {
                errorDiv.style.display = 'none';
                return;
            }
            
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<%= request.getContextPath() %>/student?action=checkid&id=' + encodeURIComponent(id), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText === 'exists') {
                        errorDiv.textContent = '⚠️ Mã sinh viên đã tồn tại!';
                        errorDiv.style.display = 'block';
                    } else {
                        errorDiv.style.display = 'none';
                    }
                }
            };
            xhr.send();
        }
        
        function validateForm() {
            var id = document.getElementById('id').value.trim();
            var name = document.getElementById('name').value.trim();
            var age = document.getElementById('age').value;
            
            if (id === '' || name === '' || age === '') {
                alert('Vui lòng điền đầy đủ thông tin!');
                return false;
            }
            
            if (age < 16 || age > 100) {
                alert('Tuổi phải từ 16 đến 100!');
                return false;
            }
            
            var errorDiv = document.getElementById('idError');
            if (errorDiv.style.display === 'block') {
                alert('Mã sinh viên đã tồn tại!');
                return false;
            }
            
            return true;
        }
    </script>
</head>
<body>
    <div class="container container-small">
        <h1>Thêm Sinh Viên Mới</h1>
        
        <c:if test="${not empty error}">
            <div class="message error">${error}</div>
        </c:if>
        
        <form action="<%= request.getContextPath() %>/student?action=add" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="id">Mã sinh viên: <span class="required">*</span></label>
                <input type="text" id="id" name="id" required onblur="checkIdExists()" 
                       value="${param.id}" placeholder="Nhập mã sinh viên">
                <div id="idError" class="error-text" style="display:none;"></div>
            </div>
            
            <div class="form-group">
                <label for="name">Họ tên: <span class="required">*</span></label>
                <input type="text" id="name" name="name" required 
                       value="${param.name}" placeholder="Nhập họ tên sinh viên">
            </div>
            
            <div class="form-group">
                <label for="age">Tuổi: <span class="required">*</span></label>
                <input type="number" id="age" name="age" required min="16" max="100" 
                       value="${param.age}" placeholder="Nhập tuổi (16-100)">
            </div>
            
            <div class="form-group">
                <label for="university">Trường:</label>
                <input type="text" id="university" name="university" 
                       value="${param.university}" placeholder="Nhập tên trường (không bắt buộc)">
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="<%= request.getContextPath() %>/student?action=list" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</body>
</html>
