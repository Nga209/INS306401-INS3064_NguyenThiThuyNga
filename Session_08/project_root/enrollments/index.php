<?php
// enrollments/index.php
// Danh sách đăng ký học

require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

// Lấy danh sách đăng ký kèm thông tin sinh viên và khóa học
$sql = 'SELECT e.id,
               s.name  AS student_name,
               s.email,
               c.title AS course_title,
               e.enrolled_at
        FROM enrollments e
        JOIN students s ON e.student_id = s.id
        JOIN courses  c ON e.course_id  = c.id
        ORDER BY e.enrolled_at DESC';

$enrollments = $db->fetchAll($sql);

// Đọc thông báo từ query string
$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = 'Thêm đăng ký thành công!';
} elseif (isset($_GET['deleted'])) {
    $successMessage = 'Hủy đăng ký thành công!';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đăng ký học</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #ff9800; color: #fff; }
        .btn { padding: 4px 8px; text-decoration: none; border-radius: 3px; }
        .btn-add { background: #4CAF50; color: #fff; }
        .btn-delete { background: #f44336; color: #fff; }
    </style>
</head>
<body>
<h1>Quản lý đăng ký học</h1>

<?php if ($successMessage): ?>
    <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>

<p>
    <a href="create.php" class="btn btn-add">+ Thêm đăng ký</a>
    <a href="../index.php" style="margin-left: 10px;">← Về trang chính</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sinh viên</th>
            <th>Email</th>
            <th>Khóa học</th>
            <th>Thời gian đăng ký</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($enrollments as $enroll): ?>
        <tr>
            <td><?= $enroll['id'] ?></td>
            <td><?= htmlspecialchars($enroll['student_name']) ?></td>
            <td><?= htmlspecialchars($enroll['email']) ?></td>
            <td><?= htmlspecialchars($enroll['course_title']) ?></td>
            <td><?= $enroll['enrolled_at'] ?></td>
            <td>
                <a href="delete.php?id=<?= $enroll['id'] ?>" class="btn btn-delete"
                   onclick="return confirm('Bạn chắc chắn muốn hủy đăng ký này?');">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php if (empty($enrollments)): ?>
        <tr>
            <td colspan="6" style="text-align: center;">Chưa có đăng ký nào. Hãy <a href="create.php">thêm đăng ký mới</a>.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>