<?php
// courses/edit.php
// Sửa thông tin khóa học theo id, có validate & kiểm tra trùng tiêu đề

require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

// Lấy id từ query string
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$errors = [];

// Lấy khóa học hiện tại
try {
    $course = $db->fetch('SELECT * FROM courses WHERE id = ?', [$id]);
    if (!$course) {
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    die('Không lấy được dữ liệu khóa học.');
}

$title       = $course['title'];
$description = $course['description'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validate
    if ($title === '') {
        $errors['title'] = 'Vui lòng nhập tiêu đề khóa học.';
    } elseif (strlen($title) < 3) {
        $errors['title'] = 'Tiêu đề khóa học phải có ít nhất 3 ký tự.';
    }

    if (empty($errors)) {
        try {
            // Kiểm tra tiêu đề trùng nhưng không phải bản ghi hiện tại
            $existing = $db->fetch(
                'SELECT id FROM courses WHERE title = ? AND id <> ?',
                [$title, $id]
            );

            if ($existing) {
                $errors['title'] = 'Tiêu đề khóa học đã thuộc về khóa học khác.';
            } else {
                $db->update('courses', [
                    'title'       => $title,
                    'description' => $description,
                ], 'id = ?', [$id]);

                header('Location: index.php?updated=1');
                exit;
            }
        } catch (Exception $e) {
            $errors['general'] = 'Có lỗi khi cập nhật, vui lòng thử lại.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa khóa học</title>
    <style>
        .error { color: red; font-size: 14px; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; }
        input[type="text"], textarea { width: 100%; max-width: 400px; padding: 8px; }
        button { padding: 8px 16px; background: #2196F3; color: #fff; border: none; cursor: pointer; }
        button:hover { background: #0b7dda; }
        .cancel { margin-left: 10px; }
    </style>
</head>
<body>
<h1>Sửa khóa học</h1>

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

    <button type="submit">Cập nhật</button>
    <a href="index.php" class="cancel">Hủy</a>
</form>

</body>
</html>