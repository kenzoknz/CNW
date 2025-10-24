<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$conn = new mysqli("localhost", "root", "", "dulieu");
$conn->set_charset("utf8");


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


$idpb = "";
$tenpb = "";
$mota = "";
$message = "";

if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}

if (isset($_GET['IDPB'])) {
    $idpb = $_GET['IDPB'];


    $sql = "SELECT * FROM phongban WHERE IDPB = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idpb);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idpb = $row['IDPB'];
        $tenpb = $row['TenPB'];
        $mota = $row['MoTa'];
    } else {
        $message = "Không tìm thấy phòng ban với mã " . htmlspecialchars($idpb);
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật phòng ban</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Cập nhật thông tin phòng ban</h2>

            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'thành công') !== false ? 'success' : 'error'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="xulycapnhat.php" method="POST">
                <div class="form-group">
                    <label for="IDPB">Mã phòng ban:</label>
                    <input type="text" id="IDPB" name="IDPB" value="<?php echo htmlspecialchars($idpb); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="TenPB">Tên phòng ban:</label>
                    <input type="text" id="TenPB" name="TenPB" value="<?php echo htmlspecialchars($tenpb); ?>" required>
                </div>

                <div class="form-group">
                    <label for="MoTa">Mô tả:</label>
                    <textarea id="MoTa" name="MoTa" required><?php echo htmlspecialchars($mota); ?></textarea>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="capnhat.php" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>