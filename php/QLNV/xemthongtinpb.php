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
    $sql = "SELECT * from phongban";
    $result = $conn->query($sql);
     echo '<table  border="1" cellspacing="0" cellpadding="10">';
   echo '<caption>Danh sách truy xuất</caption>';
   echo '<tr><th>IDPB</th><th>Tên phòng ban</th><th>Mô tả</th><th>Xem nhân viên</th></tr>';
   while ($row = mysqli_fetch_array($result)) {
       echo '<tr><td>' . $row['IDPB'] . '</td><td>' . $row['TenPB'] . '</td><td>' . $row['MoTa'] . '</td><td align="center"><a href="xemthongtinNVPB.php?IDPB=' . $row['IDPB'] . '">Xem</a></td></tr>';
   }
   echo '</table>';
   mysqli_free_result($result);
   $conn->close();
    ?>
</body>
</html>