<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm Nhân viên</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        h1 { 
            text-align: center; 
            color: #333; 
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: 600;
        }
        
        h2 {
            color: #333;
            margin: 20px 0;
            font-size: 1.5rem;
            font-weight: 500;
        }
        
        .search-form { 
            margin: 30px 0; 
            padding: 25px;
            background: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .search-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: end;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .search-group {
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }
        
        .search-group label {
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }
        
        .search-form input[type="text"], .search-form select { 
            padding: 12px 15px; 
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .search-form input[type="text"]:focus, .search-form select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .search-form input[type="submit"] { 
            padding: 12px 25px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
            min-width: 120px;
        }
        
        .search-form input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-clear {
            padding: 12px 25px;
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            display: inline-block;
            min-width: 120px;
        }
        
        .btn-clear:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        th, td { 
            padding: 15px; 
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        
        th { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        .no-results {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 30px;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>TÌM KIẾM NHÂN VIÊN</h1>

        <div class="search-form">
            <form action="timkiem.php" method="GET">
                <div class="search-row">
                    <div class="search-group">
                        <label>Tìm theo tên/ID:</label>
                        <input type="text" name="query" placeholder="Nhập IDNV hoặc tên nhân viên..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    </div>
                    <div class="search-group">
                        <label>Phòng ban:</label>
                        <select name="phongban">
                            <option value="">-- Tất cả phòng ban --</option>
                            <?php
                            require 'config.php';
                            $sql_pb = "SELECT * FROM phongban ORDER BY Tenpb";
                            $result_pb = $conn->query($sql_pb);
                            if ($result_pb->num_rows > 0) {
                                while($row_pb = $result_pb->fetch_assoc()) {
                                    $selected = (isset($_GET['phongban']) && $_GET['phongban'] == $row_pb['IDPB']) ? 'selected' : '';
                                    echo "<option value='" . $row_pb['IDPB'] . "' $selected>" . htmlspecialchars($row_pb['Tenpb']) . "</option>";
                                }
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="search-group">
                        <label>Địa chỉ:</label>
                        <input type="text" name="diachi" placeholder="Tìm theo địa chỉ..." value="<?php echo isset($_GET['diachi']) ? htmlspecialchars($_GET['diachi']) : ''; ?>">
                    </div>
                </div>
                <div style="text-align: center;">
                    <input type="submit" value="🔍 Tìm kiếm">
                    <a href="timkiem.php" class="btn-clear">🔄 Xóa bộ lọc</a>
                </div>
            </form>
        </div>

    <?php
    // Thực hiện tìm kiếm khi nhấn nút tìm kiếm (có submit) hoặc có tiêu chí tìm kiếm
    $hasSubmit = isset($_GET['query']) || isset($_GET['phongban']) || isset($_GET['diachi']);
    $hasSearchCriteria = (isset($_GET['query']) && !empty($_GET['query'])) || 
                        (isset($_GET['phongban']) && !empty($_GET['phongban'])) || 
                        (isset($_GET['diachi']) && !empty($_GET['diachi']));

    if ($hasSubmit) {
        require 'config.php';
        
        $search_query = isset($_GET['query']) ? $_GET['query'] : '';
        $phongban = isset($_GET['phongban']) ? $_GET['phongban'] : '';
        $diachi = isset($_GET['diachi']) ? $_GET['diachi'] : '';
        
        // Xây dựng câu SQL động
        $sql = "SELECT nv.*, pb.Tenpb FROM nhanvien nv LEFT JOIN phongban pb ON nv.IDPB = pb.IDPB WHERE 1=1";
        $conditions = array();
        $params = array();
        $types = "";

        if (!empty($search_query)) {
            $conditions[] = "(nv.Hoten LIKE ? OR nv.IDNV LIKE ?)";
            $search_term = "%" . $search_query . "%";
            $params[] = $search_term;
            $params[] = $search_term;
            $types .= "ss";
        }

        if (!empty($phongban)) {
            $conditions[] = "nv.IDPB = ?";
            $params[] = $phongban;
            $types .= "s";
        }

        if (!empty($diachi)) {
            $conditions[] = "nv.Diachi LIKE ?";
            $diachi_term = "%" . $diachi . "%";
            $params[] = $diachi_term;
            $types .= "s";
        }

        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY nv.IDNV";

        if ($stmt = $conn->prepare($sql)) {
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            // Hiển thị tiêu chí tìm kiếm
            $search_info = array();
            if (!empty($search_query)) $search_info[] = "Tên/ID: '" . htmlspecialchars($search_query) . "'";
            if (!empty($phongban)) {
                $pb_name_sql = "SELECT Tenpb FROM phongban WHERE IDPB = ?";
                $pb_stmt = $conn->prepare($pb_name_sql);
                $pb_stmt->bind_param("s", $phongban);
                $pb_stmt->execute();
                $pb_result = $pb_stmt->get_result();
                $pb_name = $pb_result->fetch_assoc()['Tenpb'];
                $search_info[] = "Phòng ban: '" . htmlspecialchars($pb_name) . "'";
                $pb_stmt->close();
            }
            if (!empty($diachi)) $search_info[] = "Địa chỉ: '" . htmlspecialchars($diachi) . "'";

            // Nếu không có tiêu chí tìm kiếm cụ thể nào, hiển thị "Tất cả nhân viên"
            if (empty($search_info)) {
                echo "<h2>Kết quả tìm kiếm: Tất cả nhân viên</h2>";
            } else {
                echo "<h2>Kết quả tìm kiếm (" . implode(", ", $search_info) . "):</h2>";
            }
            
            echo "<table><tr><th>IDNV</th><th>Họ Tên</th><th>Phòng Ban</th><th>Địa chỉ</th></tr>";
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["IDNV"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Hoten"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Tenpb"] ? $row["Tenpb"] : $row["IDPB"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Diachi"]) . "</td>";
                    echo "</tr>";
                }
                echo "<tr><td colspan='4' style='text-align: center; padding: 15px; background: #e8f5e8; color: #2d5a2d; font-weight: 500;'>Tìm thấy " . $result->num_rows . " kết quả</td></tr>";
            } else {
                echo "<tr><td colspan='4' class='no-results'>Không tìm thấy kết quả nào phù hợp với tiêu chí tìm kiếm.</td></tr>";
            }
            echo "</table>";
            
            $stmt->close();
        }
        $conn->close();
    } else {
        echo "<div style='text-align: center; padding: 30px; color: #666; font-style: italic;'>";
        echo "💡 Vui lòng nhập ít nhất một tiêu chí tìm kiếm để bắt đầu.";
        echo "</div>";
    }
    ?>

        <div style="text-align: center;">
            <a href="admin_dashboard.php" class="back-link">Quay lại Trang quản trị</a>
            <a href="xemthongtinnv.php" class="back-link" style="margin-left: 10px;">👤 Xem tất cả nhân viên</a>
        </div>
    </div>
</body>
</html>