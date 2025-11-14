<%@ page contentType="text/html; charset=UTF-8" %>
<!DOCTYPE html>
<html>
<head>
    <title>Quản Lý Sinh Viên</title>
    <link rel="stylesheet" href="<%= request.getContextPath() %>/css/style.css">
</head>
<body>
    <div class="container container-small">
        <h1>Hệ Thống Quản Lý Sinh Viên</h1>
        <ul class="menu">
            <li><a href="<%= request.getContextPath() %>/student?action=list">Danh sách sinh viên</a></li>
            <li><a href="<%= request.getContextPath() %>/student?action=add">Thêm sinh viên mới</a></li>
            <li><a href="<%= request.getContextPath() %>/student?action=search">Tìm kiếm sinh viên</a></li>
        </ul>
    </div>
</body>
</html>

