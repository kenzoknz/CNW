<%@ page contentType="text/html; charset=UTF-8" %>
<!DOCTYPE html>
<html>
<head>
    <title>Thêm User</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f0f0f0; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 500px; margin: 0 auto; }
        h1 { color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ddd; 
                                                   border-radius: 4px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; 
                 border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        a { color: #666; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thêm User Mới</h1>
        <form method="POST" action="<%= request.getContextPath() %>/user/add">
            <div class="form-group">
                <label>Tên:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <button type="submit">Thêm</button>
                <a href="<%= request.getContextPath() %>/user/">Hủy</a>
            </div>
        </form>
    </div>
</body>
</html>
