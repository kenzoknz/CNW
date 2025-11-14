<?php
/**
 * Student List View
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/CNW23N12/MVC-Example/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .container {
            max-width: 1000px;
            margin-top: 20px;
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
        .btn-group-custom {
            margin: 20px 0;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2d6cdf 0%, #2d8cdf 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1e4f9c 0%, #1e6fbc 100%);
        }
        table {
            margin-top: 20px;
        }
        th {
            background-color: #2d6cdf;
            color: white;
            font-weight: 600;
            border-bottom: 2px solid #1e4f9c;
            padding: 12px;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">
                <i class="fas fa-users"></i> Danh sách Sinh viên
            </h3>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type'] ?? 'info'; ?>">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            <?php endif; ?>

            <div class="btn-group-custom">
                <a href="/CNW23N12/MVC-Example/index.php?action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm sinh viên
                </a>
                <a href="/CNW23N12/MVC-Example/index.php?action=search" class="btn btn-info">
                    <i class="fas fa-search"></i> Tìm kiếm
                </a>
                <a href="/CNW23N12/MVC-Example/index.php?action=delete" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Xóa
                </a>
            </div>

            <?php if (isset($students) && !empty($students)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã sinh viên</th>
                                <th>Tên sinh viên</th>
                                <th>Tuổi</th>
                                <th>Trường đại học</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student->getId()); ?></td>
                                    <td><?php echo htmlspecialchars($student->getName()); ?></td>
                                    <td><?php echo htmlspecialchars($student->getAge()); ?></td>
                                    <td><?php echo htmlspecialchars($student->getUniversity()); ?></td>
                                    <td>
                                        <a href="/CNW23N12/MVC-Example/index.php?action=edit&id=<?php echo $student->getId(); ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Không có dữ liệu sinh viên
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
