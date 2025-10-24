<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa Nhiều Nhân Viên</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="content-wrapper">
            <div class="user-info">Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?> | <a
                    href="logout.php">Đăng xuất</a></div>
            <a href="index.php" class="back-home">← Trở về trang chính</a>
            <h1>Xóa Nhiều Nhân Viên</h1>

            <?php

            if (isset($_REQUEST['message'])) {
                $message = htmlspecialchars($_REQUEST['message']);
                $messageClass = strpos($message, 'thành công') !== false ? 'success' : 'error';
                echo '<div class="message ' . $messageClass . '">' . $message . '</div>';
            }


            $conn = new mysqli("localhost", "root", "", "dulieu");
            $conn->set_charset("utf8");

            if ($conn->connect_error) {
                echo '<div class="message error">Kết nối thất bại: ' . $conn->connect_error . '</div>';
                exit();
            }


            $count_sql = "SELECT COUNT(*) as total FROM nhanvien";
            $count_result = $conn->query($count_sql);
            $total_employees = 0;
            if ($count_result && $row = $count_result->fetch_assoc()) {
                $total_employees = $row['total'];
            }

            $sql = "SELECT nv.IDNV, nv.HoTen, pb.TenPB, nv.DiaChi
                    FROM nhanvien nv
                    JOIN phongban pb ON nv.IDPB = pb.IDPB
                    ORDER BY nv.IDNV ASC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                echo '<form action="xulyxoatatca.php" method="post" id="deleteForm" onsubmit="return confirmDelete();">';

                echo '<div class="action-buttons mb-3"><button type="button" onclick="selectAll()" class="btn btn-secondary">Chọn tất cả</button> <button type="button" onclick="deselectAll()" class="btn btn-secondary">Bỏ chọn tất cả</button></div>';

                echo '<div class="table-container">';
                echo '<table>';
                echo '<caption>Danh sách nhân viên</caption>';
                echo '<thead><tr><th>Chọn</th><th>Mã NV</th><th>Họ tên</th><th>Phòng ban</th><th>Địa chỉ</th></tr></thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="text-center"><div class="checkbox-container"><input type="checkbox" name="selected_ids[]" value="' . htmlspecialchars($row['IDNV']) . '"></div></td>';
                    echo '<td>' . htmlspecialchars($row['IDNV']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['HoTen']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['TenPB']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['DiaChi']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
                echo '</div>';


                echo '<div class="action-buttons mt-3"><button type="submit" name="action" value="Xóa Đã Chọn" class="btn btn-danger">Xóa đã chọn</button> <button type="submit" name="action" value="Xóa Tất Cả" class="btn btn-danger" onclick="document.getElementById(\'delete_all\').value=\'1\';">Xóa tất cả</button><input type="hidden" name="delete_all" id="delete_all" value="0"></div>';
                echo '</form>';

                $result->free_result();
            } else {
                echo '<div class="message info">Không có dữ liệu nhân viên!</div>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script>

        function selectAll() {
            var checkboxes = document.getElementsByName('selected_ids[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        }


        function deselectAll() {
            var checkboxes = document.getElementsByName('selected_ids[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
        }


        function confirmDelete() {
            var form = document.getElementById('deleteForm');
            var deleteAll = document.getElementById('delete_all').value;
            var checkboxes = document.getElementsByName('selected_ids[]');


            var anySelected = false;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    anySelected = true;
                    break;
                }
            }


            if (deleteAll === '1') {
                return confirm('Bạn có chắc chắn muốn XÓA TẤT CẢ nhân viên không? Hành động này không thể hoàn tác!');
            }


            if (!anySelected) {
                alert('Vui lòng chọn ít nhất một nhân viên để xóa.');
                return false;
            }


            return confirm('Bạn có chắc chắn muốn xóa các nhân viên đã chọn không?');
        }
    </script>
</body>

</html>