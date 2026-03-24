<?php
// courses/index.php
// Hiển thị danh sách khóa học, link sang thêm/sửa/xóa

require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

// Lấy tất cả khóa học, sắp xếp mới nhất lên trước
$courses = $db->fetchAll('SELECT * FROM courses ORDER BY created_at DESC');

// Đọc message đơn giản qua query string
$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = 'Thêm khóa học thành công!';
} elseif (isset($_GET['updated'])) {
    $successMessage = 'Cập nhật khóa học thành công!';
} elseif (isset($_GET['deleted'])) {
    $successMessage = 'Xóa khóa học thành công!';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khóa học</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #2196F3; color: #fff; }
        .btn { padding: 4px 8px; text-decoration: none; border-radius: 3px; }
        .btn-add { background: #4CAF50; color: #fff; }
        .btn-edit { background: #2196F3; color: #fff; }
        .btn-delete { background: #f44336; color: #fff; }
    </style>
</head>
<body>
<h1>Quản lý khóa học</h1>

<?php if ($successMessage): ?>
    <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>

<p>
    <a href="create.php" class="btn btn-add">+ Thêm khóa học</a>
    <a href="../index.php" style="margin-left: 10px;">← Về trang chính</a>
</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề khóa học</th>
            <th>Mô tả</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= $course['id'] ?></td>
            <td><?= htmlspecialchars($course['title']) ?></td>
            <td><?= htmlspecialchars($course['description'] ?? '—') ?></td>
            <td><?= $course['created_at'] ?></td>
            <td>
                <a href="edit.php?id=<?= $course['id'] ?>" class="btn btn-edit">Sửa</a>
                <a href="delete.php?id=<?= $course['id'] ?>" class="btn btn-delete"
                   onclick="return confirm('Bạn chắc chắn muốn xóa khóa học này?');">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php if (empty($courses)): ?>
        <tr>
            <td colspan="5" style="text-align: center;">Chưa có khóa học nào. Hãy <a href="create.php">thêm khóa học đầu tiên</a>.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>