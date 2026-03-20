<?php
// File: top_customers.php
require_once 'Database.php';

$db = Database::getInstance()->getConnection();

try {
    $sql = "SELECT 
                u.name AS customer_name,
                u.email,
                SUM(o.total_amount) AS total_spent,
                COUNT(o.id) AS order_count
            FROM users u
            INNER JOIN orders o ON u.id = o.user_id
            GROUP BY u.id, u.name, u.email
            ORDER BY total_spent DESC
            LIMIT 3";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $customers = $stmt->fetchAll();
    
} catch (PDOException $e) {
    die("❌ Lỗi truy vấn: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 Khách Hàng VIP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="display: flex; justify-content: center;">
        <div class="vip-container">
            <!-- VIP Header -->
            <div class="vip-header">
                <h1>Top 3 Khách Hàng</h1>
                <div class="vip-subtitle">Chi tiêu cao nhất</div>
                <div class="vip-divider"></div>
            </div>
            
            <?php if (empty($customers)): ?>
                <div class="no-data">
                    <span style="font-size: 36px; display: block; margin-bottom: 16px;">🕳️</span>
                    Không có dữ liệu khách hàng
                    <small>Thêm dữ liệu vào bảng users và orders</small>
                </div>
            <?php else: 
                $totalSpentAll = array_sum(array_column($customers, 'total_spent'));
                $avgSpent = $totalSpentAll / count($customers);
            ?>
                
                <!-- Stats Summary -->
                <div class="stats-summary">
                    <div class="stat-item">
                        <div class="stat-label">Tổng chi tiêu</div>
                        <div class="stat-value"><?= number_format($totalSpentAll, 0, ',', '.') ?>đ</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Trung bình</div>
                        <div class="stat-value"><?= number_format($avgSpent, 0, ',', '.') ?>đ</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Tổng đơn</div>
                        <div class="stat-value"><?= array_sum(array_column($customers, 'order_count')) ?></div>
                    </div>
                </div>
                
                <!-- VIP Table -->
                <div class="table-container" style="padding: 20px 0; border: none; box-shadow: none;">
                    <table>
                        <thead>
                            <tr>
                                <th>Hạng</th>
                                <th>Khách hàng</th>
                                <th>Email</th>
                                <th>Tổng chi tiêu</th>
                                <th>Số đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $index => $customer): 
                                $rank = $index + 1;
                            ?>
                                <tr>
                                    <td>
                                        <div class="rank-badge"><?= $rank ?></div>
                                    </td>
                                    <td>
                                        <span class="customer-name">
                                            <?= htmlspecialchars($customer['customer_name']) ?>
                                        </span>
                                        <?php if ($rank == 1): ?>
                                            <span class="vip-badge">VIP</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="customer-email">
                                        <?= htmlspecialchars($customer['email']) ?>
                                    </td>
                                    <td class="price">
                                        <?= number_format($customer['total_spent'], 0, ',', '.') ?>đ
                                    </td>
                                    <td>
                                        <span class="order-count">
                                            <?= $customer['order_count'] ?> đơn
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Footer -->
                <div class="footer-info" style="margin-top: 20px;">
                    <a href="index.php" class="btn btn-secondary" style="padding: 12px 40px;">← Quay lại Dashboard</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>