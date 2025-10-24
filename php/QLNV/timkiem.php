<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm nhân viên</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="content-wrapper">
            <a href="index.php" class="back-home">← Quay về trang chính</a>
            <h1>Tìm kiếm nhân viên</h1>

            <div class="form-container">
                <form action="xulytimkiem.php" method="POST">
                    <div class="form-group">
                        <label for="searchField">Vui lòng nhập giá trị cần tìm:</label>
                        <input type="text" id="searchField" name="searchField" placeholder="Nhập giá trị cần tìm..." required>
                    </div>
                    <div class="form-group">
                        <label>Search by:</label>
                        <label><input type="radio" name="searchBy" value="IDNV" checked> IDNV</label>
                        <label><input type="radio" name="searchBy" value="HoTen"> Họ tên</label>
                        <label><input type="radio" name="searchBy" value="DiaChi"> Địa chỉ</label>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>