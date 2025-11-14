<?php
/**
 * Update Student View
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật Sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/CNW23N12/MVC-Example/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .container {
            max-width: 600px;
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
        .form-group label {
            font-weight: 600;
            color: #000;
            margin-top: 10px;
            background: rgba(255, 255, 255, 0.95);
            padding: 5px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .form-control:focus {
            border-color: #2d6cdf;
            box-shadow: 0 0 0 0.2rem rgba(45, 108, 223, 0.25);
        }
        .form-control:disabled {
            background-color: #e9ecef;
        }
        .btn-submit {
            background: linear-gradient(135deg, #2d6cdf 0%, #2d8cdf 100%);
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
            margin-right: 10px;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #1e4f9c 0%, #1e6fbc 100%);
            color: white;
            text-decoration: none;
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
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .invalid-feedback {
            color: #dc3545;
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-edit"></i> Cập nhật thông tin Sinh viên</h3>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type'] ?? 'info'; ?>">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            <?php endif; ?>

            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $field => $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (isset($student)): ?>
                <form method="POST" action="/CNW23N12/MVC-Example/index.php?action=update&id=<?php echo $student->getId(); ?>">
                    <div class="form-group">
                        <label for="id">Mã sinh viên</label>
                        <input type="text" class="form-control" id="id" name="id" disabled
                               value="<?php echo htmlspecialchars($student->getId()); ?>">
                    </div>

                    <div class="form-group">
                        <label for="name">Tên sinh viên *</label>
                        <input type="text" class="form-control <?php echo isset($errors['Tên sinh viên']) ? 'is-invalid' : ''; ?>" 
                               id="name" name="name" required
                               value="<?php echo isset($input['name']) ? htmlspecialchars($input['name']) : htmlspecialchars($student->getName()); ?>">
                        <?php if (isset($errors['Tên sinh viên'])): ?>
                            <div class="invalid-feedback">
                                <?php echo htmlspecialchars($errors['Tên sinh viên']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="age">Tuổi *</label>
                        <input type="number" class="form-control <?php echo isset($errors['Tuổi']) ? 'is-invalid' : ''; ?>" 
                               id="age" name="age" min="1" max="100" required
                               value="<?php echo isset($input['age']) ? htmlspecialchars($input['age']) : htmlspecialchars($student->getAge()); ?>">
                        <?php if (isset($errors['Tuổi'])): ?>
                            <div class="invalid-feedback">
                                <?php echo htmlspecialchars($errors['Tuổi']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="university">Trường đại học *</label>
                        <input type="text" class="form-control <?php echo isset($errors['Trường đại học']) ? 'is-invalid' : ''; ?>" 
                               id="university" name="university" required
                               value="<?php echo isset($input['university']) ? htmlspecialchars($input['university']) : htmlspecialchars($student->getUniversity()); ?>">
                        <?php if (isset($errors['Trường đại học'])): ?>
                            <div class="invalid-feedback">
                                <?php echo htmlspecialchars($errors['Trường đại học']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="margin-top: 30px;">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                        <a href="/CNW23N12/MVC-Example/index.php" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> Sinh viên không tồn tại
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
