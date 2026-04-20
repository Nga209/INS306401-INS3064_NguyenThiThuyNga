<!-- app/Views/requests/index.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách yêu cầu</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        tr:hover { background: #f5f5f5; }
        .status-pending { background: #ffc107; color: #000; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .status-progress { background: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .status-done { background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px; }
        .btn:hover { background: #0056b3; }
        .logout { background: #dc3545; margin-left: 10px; }
        .logout:hover { background: #c82333; }
        .nav { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></strong> (<?= $_SESSION['user_role'] ?? 'student' ?>)</span>
            <a href="/index.php?action=logout" class="btn logout" style="float: right;">Đăng xuất</a>
            <div style="clear: both;"></div>
        </div>
        
        <h1>Danh sách yêu cầu</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <div><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($requests)): ?>
            <p>Chưa có yêu cầu nào.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $req): ?>
                    <tr>
                        <td><?= $req->id ?></td>
                        <td><?= htmlspecialchars($req->title) ?></td>
                        <td>
                            <span class="status-<?= strtolower(str_replace(' ', '-', $req->status)) ?>">
                                <?= $req->status ?>
                            </span>
                        </td>
                        <td><?= $req->created_at ?></td>
                        <td>
                            <a href="/index.php?action=show&id=<?= $req->id ?>">Xem chi tiết</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <a href="/index.php?action=create" class="btn">+ Tạo yêu cầu mới</a>
    </div>
</body>
</html>