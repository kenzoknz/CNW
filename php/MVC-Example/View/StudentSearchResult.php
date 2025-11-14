<?php
/**
 * Search Result View
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/CNW23N12/MVC-Example/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .container {
            max-width: 800px;
            margin-top: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #2d6cdf 0%, #2d8cdf 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        .card-header h3 {
            margin: 0;
            font-size: 24px;
        }
        .student-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .info-item {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #2d6cdf;
        }
        .info-item label {
            font-weight: 600;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        .info-item value {
            color: #666;
            font-size: 16px;
        }
        .btn-back {
            background: #6c757d;
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-back:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Kết quả tìm kiếm</h3>
        </div>
        <div class="card-body">
            <?php if (isset($student)): ?>
                <div class="student-info">
                    <div class="info-item">
                        <label>Mã sinh viên:</label>
                        <value><?php echo htmlspecialchars($student->getId()); ?></value>
                    </div>
                    <div class="info-item">
                        <label>Tên sinh viên:</label>
                        <value><?php echo htmlspecialchars($student->getName()); ?></value>
                    </div>
                    <div class="info-item">
                        <label>Tuổi:</label>
                        <value><?php echo htmlspecialchars($student->getAge()); ?></value>
                    </div>
                    <div class="info-item">
                        <label>Trường đại học:</label>
                        <value><?php echo htmlspecialchars($student->getUniversity()); ?></value>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <a href="/CNW23N12/MVC-Example/index.php" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> Sinh viên không tìm thấy
                </div>
                <a href="/CNW23N12/MVC-Example/index.php" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
