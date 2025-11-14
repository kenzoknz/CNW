<%@ page contentType="text/html; charset=UTF-8" %>
<!DOCTYPE html>
<html>
<head>
    <title>MVC Test App</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f0f0f0; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; }
        h1 { color: #333; }
        a { display: inline-block; padding: 10px 20px; background: #007bff; color: white; 
            text-decoration: none; border-radius: 5px; margin: 10px 0; }
        a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>MVC Test Application</h1>
        <p>Ứng dụng JSP MVC đơn giản với Tomcat 9 Cargo</p>
        <a href="<%= request.getContextPath() %>/user/">Danh sách User</a>
        <a href="<%= request.getContextPath() %>/user/add">Thêm User</a>
    </div>
</body>
</html>

