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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2196F3;
        }
        
        .button-group {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        th {
            background: #2196F3;
            color: white;
            font-weight: 600;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-add {
            background: #4CAF50;
            color: white;
        }
        
        .btn-add:hover {
            background: #45a049;
            transform: translateY(-1px);
        }
        
        .btn-edit {
            background: #2196F3;
            color: white;
            padding: 5px 12px;
            font-size: 13px;
        }
        
        .btn-edit:hover {
            background: #0b7dda;
        }
        
        .btn-delete {
            background: #f44336;
            color: white;
            padding: 5px 12px;
            font-size: 13px;
            margin-left: 5px;
        }
        
        .btn-delete:hover {
            background: #da190b;
        }
        
        .btn-home {
            background: #9e9e9e;
            color: white;
        }
        
        .btn-home:hover {
            background: #757575;
            transform: translateY(-1px);
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }
        
        .action-buttons {
            white-space: nowrap;
        }
        
        .empty-row {
            text-align: center;
            color: #999;
            padding: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📚 Quản lý khóa học</h1>

    <?php if ($successMessage): ?>
        <div class="success-message">
            ✓ <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php endif; ?>

    <div class="button-group">
        <a href="create.php" class="btn btn-add">+ Thêm khóa học</a>
        <a href="../index.php" style="margin-left: 10px;">← Về trang chính</a>
    </div>

    <?php if (empty($courses)): ?>
        <div class="empty-row">
            <p>Chưa có khóa học nào. Hãy <a href="create.php" style="color: #2196F3;">thêm khóa học đầu tiên</a>!</p>
        </div>
    <?php else: ?>
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
                    <td class="action-buttons">
                        <a href="edit.php?id=<?= $course['id'] ?>" class="btn btn-edit">✏️ Sửa</a>
                        <a href="delete.php?id=<?= $course['id'] ?>" class="btn btn-delete"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này?');">🗑️ Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>