<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <?php
    $conn = new mysqli("localhost", "root", "", "dulieu");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    echo "Kết nối thành công!<br>";
    $sql = "SELECT nv.IDNV, nv.HoTen, pb.TenPB, nv.DiaChi
            FROM nhanvien nv
            JOIN phongban pb ON nv.IDPB = pb.IDPB"
            ;
    $result = $conn->query($sql);
    echo '<table  border="1" cellspacing="0" cellpadding="10">';
    echo '<caption>Danh sách truy xuất</caption>';
    echo '<tr><th>IDNV</th><th>Họ tên</th><th>Phòng ban</th><th>Địa chỉ</th></tr>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<tr><td>' . $row['IDNV'] .
            '</td><td>' . $row['HoTen'] .
            '</td><td>' . $row['TenPB'] .
            '</td><td>' . $row['DiaChi'] .
            '</td></tr>';
    }
    echo '</table>';
    mysqli_free_result($result);
    $conn->close();
    ?>
</body>

</html>