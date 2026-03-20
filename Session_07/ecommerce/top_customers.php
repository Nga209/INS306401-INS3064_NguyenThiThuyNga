<?php
// File: top_customers.php
require_once 'Database.php';

// Lấy kết nối database
$db = Database::getInstance()->getConnection();

try {
    // Câu lệnh SQL lấy top 3 khách hàng chi tiêu nhiều nhất
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
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    // Lấy tất cả kết quả
    $customers = $stmt->fetchAll();
    
} catch (PDOException $e) {
    // Xử lý lỗi
    die("❌ Lỗi truy vấn: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 Khách Hàng VIP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: #ffffff;
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03), 0 2px 10px rgba(0, 0, 0, 0.02);
            max-width: 1000px;
            width: 100%;
            border: 1px solid #f0f0f0;
        }
        
        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 48px;
        }
        
        .header h1 {
            color: #1a1a1a;
            font-size: 32px;
            font-weight: 500;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }
        
        .header-subtitle {
            color: #808080;
            font-size: 16px;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .header-divider {
            width: 60px;
            height: 2px;
            background: #e0e0e0;
            margin: 24px auto 0;
        }
        
        /* Table Styles */
        .table-wrapper {
            margin: 40px 0 32px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 20px 16px;
            color: #666;
            font-weight: 400;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #eaeaea;
        }
        
        td {
            padding: 24px 16px;
            border-bottom: 1px solid #f5f5f5;
            color: #333;
            font-size: 15px;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover td {
            background-color: #fafafa;
        }
        
        /* Rank Styles */
        .rank-cell {
            width: 80px;
        }
        
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 18px;
            font-weight: 400;
        }
        
        .rank-1 .rank-badge {
            background: #f5f5f5;
            color: #666;
        }
        
        .rank-2 .rank-badge {
            background: #f5f5f5;
            color: #666;
        }
        
        .rank-3 .rank-badge {
            background: #f5f5f5;
            color: #666;
        }
        
        /* Customer Info */
        .customer-name {
            font-weight: 500;
            color: #1a1a1a;
            font-size: 16px;
        }
        
        .vip-badge {
            display: inline-block;
            margin-left: 12px;
            padding: 4px 12px;
            background: #f0f0f0;
            color: #666;
            font-size: 11px;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 30px;
        }
        
        .customer-email {
            color: #808080;
            font-size: 14px;
        }
        
        /* Money Style */
        .money {
            font-weight: 500;
            color: #2c2c2c;
            font-size: 17px;
            letter-spacing: 0.2px;
        }
        
        /* Order Count */
        .order-count {
            display: inline-block;
            padding: 6px 16px;
            background: #f5f5f5;
            color: #666;
            font-size: 13px;
            border-radius: 40px;
            white-space: nowrap;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid #f0f0f0;
        }
        
        .footer a {
            display: inline-block;
            padding: 14px 40px;
            background: transparent;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 0.5px;
            border: 1px solid #e0e0e0;
            border-radius: 40px;
            transition: all 0.2s ease;
        }
        
        .footer a:hover {
            background: #f5f5f5;
            border-color: #d0d0d0;
            color: #333;
        }
        
        /* No Data */
        .no-data {
            text-align: center;
            padding: 80px 20px;
            color: #999;
            font-size: 15px;
            background: #fafafa;
            border-radius: 16px;
        }
        
        .no-data small {
            display: block;
            margin-top: 12px;
            color: #bbb;
            font-size: 13px;
        }
        
        /* Stats Summary */
        .stats-summary {
            display: flex;
            justify-content: center;
            gap: 48px;
            margin: 32px 0 24px;
            padding: 24px;
            background: #fafafa;
            border-radius: 16px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-label {
            color: #808080;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .stat-value {
            color: #333;
            font-size: 26px;
            font-weight: 300;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .container {
                padding: 24px;
            }
            
            .stats-summary {
                flex-direction: column;
                gap: 24px;
            }
            
            th, td {
                padding: 16px 12px;
                font-size: 14px;
            }
            
            .money {
                font-size: 15px;
            }
            
            .order-count {
                padding: 4px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header với phong cách tối giản -->
        <div class="header">
            <h1>Top 3 Khách Hàng</h1>
            <div class="header-subtitle">Chi tiêu cao nhất</div>
            <div class="header-divider"></div>
        </div>
        
        <?php if (empty($customers)): ?>
            <div class="no-data">
                <span style="font-size: 32px; display: block; margin-bottom: 16px;">🕳️</span>
                Không có dữ liệu khách hàng
                <small>Thêm dữ liệu vào bảng users và orders</small>
            </div>
        <?php else: 
            // Tính tổng chi tiêu trung bình
            $totalSpentAll = array_sum(array_column($customers, 'total_spent'));
            $avgSpent = $totalSpentAll / count($customers);
        ?>
            
            <!-- Stats Summary tối giản -->
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
                    <div class="stat-label">Tổng đơn hàng</div>
                    <div class="stat-value"><?= array_sum(array_column($customers, 'order_count')) ?></div>
                </div>
            </div>
            
            <!-- Bảng dữ liệu tối giản -->
            <div class="table-wrapper">
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
                            <tr class="rank-<?= $rank ?>">
                                <td class="rank-cell">
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
                                <td class="money">
                                    <?= number_format($customer['total_spent'], 0, ',', '.') ?>đ
                                </td>
                                <td>
                                    <span class="order-count">
                                        <?= $customer['order_count'] ?> đơn hàng
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Footer tối giản -->
            <div class="footer">
                <a href="index.php">Xem Product Admin →</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>