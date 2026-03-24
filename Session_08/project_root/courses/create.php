<?php
// courses/create.php
// Form thêm khóa học mới, có validate & xử lý lỗi DB

require_once __DIR__ . '/../classes/Database.php';

$errors = [];
$title  = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // 1. Validate phía server
    if ($title === '') {
        $errors['title'] = 'Vui lòng nhập tiêu đề khóa học.';
    } elseif (strlen($title) < 3) {
        $errors['title'] = 'Tiêu đề khóa học phải có ít nhất 3 ký tự.';
    }

    // 2. Nếu không có lỗi validate thì xử lý DB
    if (empty($errors)) {
        try {
            $db = Database::getInstance();

            // Kiểm tra tiêu đề khóa học đã tồn tại chưa (tùy chọn, giúp tránh trùng lặp)
            $existing = $db->fetch('SELECT id FROM courses WHERE title = ?', [$title]);

            if ($existing) {
                $errors['title'] = 'Tiêu đề khóa học đã tồn tại.';
            } else {
                // Thêm bản ghi mới
                $db->insert('courses', [
                    'title'       => $title,
                    'description' => $description,
                ]);

                // Redirect về danh sách với thông báo success
                header('Location: index.php?success=1');
                exit;
            }
        } catch (Exception $e) {
            // Không show message nhạy cảm, chỉ báo lỗi chung
            $errors['general'] = 'Có lỗi xảy ra, vui lòng thử lại sau.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm khóa học</title>
    <style>
        .error { color: red; font-size: 14px; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; }
        input[type="text"], textarea { width: 100%; max-width: 400px; padding: 8px; }
        button { padding: 8px 16px; background: #4CAF50; color: #fff; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
        .cancel { margin-left: 10px; }
    </style>
</head>
<body>
<h1>Thêm khóa học mới</h1>

<?php if (!empty($errors['general'])): ?>
    <p class="error"><?= htmlspecialchars($errors['general']) ?></p>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label>Tiêu đề khóa học: <span style="color: red;">*</span></label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>">
        <?php if (!empty($errors['title'])): ?>
            <div class="error"><?= htmlspecialchars($errors['title']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Mô tả:</label><br>
        <textarea name="description" rows="5" cols="50"><?= htmlspecialchars($description) ?></textarea>
    </div>

    <button type="submit">Lưu khóa học</button>
    <a href="index.php" class="cancel">Hủy</a>
</form>

</body>
</html>