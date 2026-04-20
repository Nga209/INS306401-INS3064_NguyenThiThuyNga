<!-- app/Views/requests/show.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết yêu cầu #<?= $request->id ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 10px; }
        .info { background: #e9ecef; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .info p { margin: 10px 0; }
        .status { font-size: 18px; font-weight: bold; margin: 20px 0; }
        .status-pending { color: #ffc107; }
        .status-progress { color: #17a2b8; }
        .status-done { color: #28a745; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select { padding: 10px; margin-right: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .back { display: inline-block; margin-top: 20px; color: #007bff; text-decoration: none; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chi tiết yêu cầu #<?= $request->id ?></h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <div class="info">
            <p><strong>Tiêu đề:</strong> <?= htmlspecialchars($request->title) ?></p>
            <p><strong>Mô tả:</strong></p>
            <p><?= nl2br(htmlspecialchars($request->description)) ?></p>
            <p><strong>Người tạo:</strong> <?= $request->user_id ?></p>
            <p><strong>Ngày tạo:</strong> <?= $request->created_at ?></p>
            <p><strong>Cập nhật lần cuối:</strong> <?= $request->updated_at ?></p>
        </div>
        
        <div class="status">
            <strong>Trạng thái hiện tại:</strong>
            <span class="status-<?= strtolower(str_replace(' ', '-', $request->status)) ?>">
                <?= $request->status ?>
            </span>
        </div>
        
        <?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['staff', 'admin'])): ?>
            <form method="POST" action="/index.php?action=updateStatus&id=<?= $request->id ?>">
                <label for="status">Cập nhật trạng thái:</label>
                <select name="status" id="status">
                    <option value="Pending" <?= $request->status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="In Progress" <?= $request->status == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="Done" <?= $request->status == 'Done' ? 'selected' : '' ?>>Done</option>
                </select>
                <button type="submit">Cập nhật</button>
            </form>
        <?php endif; ?>
        
        <a href="/index.php?action=index" class="back">← Quay lại danh sách</a>
    </div>
</body>
</html>