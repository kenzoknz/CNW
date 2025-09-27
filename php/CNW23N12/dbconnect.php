<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thử chọt dữ liệu</title>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "root", "", "dulieu");
   // mysqli_select_db($conn,"dulieu");
// $username   = "root";        
// $password   = "";            
// $dbname     = "dulieu";      

// // Tạo kết nối
// $conn = new mysqli($servername, $username, $password, $dbname);
// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
# echo "Kết nối thành công!<br>";
    $sql = "SELECT * FROM table1";
    $result = $conn->query($sql);
    // $result = $conn
   echo '<table  border="1" cellspacing="0" cellpadding="10">';
   echo '<caption>Danh sách truy xuất</caption>';
   echo '<tr><th>ID</th><th>Họ tên</th><th>Ngày sinh</th><th>Nghề nghiệp</th></tr>';
//    while ($row=mysqli_fetch_array($result)){
//     $maso = $row['maso'];
//     $hoten = $row['hoten'];
//     $ngaysinh = $row['ngaysinh'];
//     $nghenghiep = $row['nghenghiep'];   
//     echo "<tr><td>$maso</td><td>$hoten</td><td>$ngaysinh</td><td>$nghenghiep</td></tr>";    
//    }
   while ($row=mysqli_fetch_array($result)){
    echo '<tr><td>'.$row['maso'].'</td><td>'.$row['hoten'].'</td><td>'.$row['ngaysinh'].'</td><td>'.$row['nghenghiep'].'</td></tr>';
   }
   echo '</table>';
   mysqli_free_result($result);
    $conn->close();
    ?>    
</body>
</html>
