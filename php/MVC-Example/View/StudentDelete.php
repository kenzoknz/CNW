<?php
/**
 * Delete Student View
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa Sinh viên</title>
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
        .btn-danger {
            background: #dc3545;
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
            font-weight: 600;
        }
        .btn-danger:hover {
            background: #c82333;
            color: white;
            text-decoration: none;
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
        .btn-back {
            background: #6c757d;
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
        }
        .btn-back:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .checkbox-col {
            text-align: center;
            width: 50px;
        }
        .selected-count {
            margin-top: 20px;
            padding: 10px;
            background-color: #e7f3ff;
            border-radius: 5px;
            border-left: 4px solid #2d6cdf;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">
                <i class="fas fa-trash"></i> Xóa sinh viên
            </h3>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type'] ?? 'info'; ?>">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            <?php endif; ?>

            <?php if (isset($students) && !empty($students)): ?>
                <form id="deleteForm" method="POST" action="/CNW23N12/MVC-Example/index.php?action=destroy">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-col">
                                        <input type="checkbox" id="checkAll" title="Chọn tất cả">
                                    </th>
                                    <th>Mã sinh viên</th>
                                    <th>Tên sinh viên</th>
                                    <th>Tuổi</th>
                                    <th>Trường đại học</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td class="checkbox-col">
                                            <input type="checkbox" name="ids[]" 
                                                   value="<?php echo htmlspecialchars($student->getId()); ?>"
                                                   class="student-checkbox">
                                        </td>
                                        <td><?php echo htmlspecialchars($student->getId()); ?></td>
                                        <td><?php echo htmlspecialchars($student->getName()); ?></td>
                                        <td><?php echo htmlspecialchars($student->getAge()); ?></td>
                                        <td><?php echo htmlspecialchars($student->getUniversity()); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="selected-count">
                        <strong>Số sinh viên được chọn: <span id="selectedCount">0</span></strong>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-danger" id="deleteBtn" disabled>
                            <i class="fas fa-trash"></i> Xóa được chọn
                        </button>
                        <a href="/CNW23N12/MVC-Example/index.php" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Không có dữ liệu sinh viên
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAll');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        const selectedCount = document.getElementById('selectedCount');
        const deleteBtn = document.getElementById('deleteBtn');
        const deleteForm = document.getElementById('deleteForm');

        // Check all
        checkAll?.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateCount();
        });

        // Update individual checkboxes
        studentCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateCount();
                // Update check all status
                const allChecked = Array.from(studentCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(studentCheckboxes).some(cb => cb.checked);
                if (checkAll) {
                    checkAll.checked = allChecked;
                    checkAll.indeterminate = someChecked && !allChecked;
                }
            });
        });

        // Update selected count
        function updateCount() {
            const checked = Array.from(studentCheckboxes).filter(cb => cb.checked).length;
            selectedCount.textContent = checked;
            deleteBtn.disabled = checked === 0;
        }

        // Form submission
        deleteForm?.addEventListener('submit', function(e) {
            const checked = Array.from(studentCheckboxes).filter(cb => cb.checked).length;
            if (checked === 0) {
                e.preventDefault();
                alert('Vui lòng chọn ít nhất một sinh viên để xóa');
                return;
            }
            if (!confirm('Bạn có chắc chắn muốn xóa ' + checked + ' sinh viên không?')) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>
