<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm nhân viên</title>
</head>
<body>
    <form action="xulytimkiem.php" method="POST">
        Vui lòng nhập giá trị cần tìm:
        <input type="text" name="searchField" placeholder="Nhập giá trị cần tìm..." required>
        <input type="submit" value="Tìm kiếm">
        <br>
        <input type="radio" name="searchBy" value="IDNV" checked> IDNV
        <input type="radio" name="searchBy" value="HoTen"> Họ tên
        <input type="radio" name="searchBy" value="DiaChi"> Địa chỉ
    </form>
    <br>
    
   
</body>
</html>