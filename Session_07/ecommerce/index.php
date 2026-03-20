<?php
// File: index.php
require_once 'Database.php';

// Lấy kết nối database
$db = Database::getInstance()->getConnection();

try {
    // Lấy danh sách categories cho dropdown
    $categories = $db->query("SELECT * FROM categories ORDER BY category_name")->fetchAll();
    
    // Xử lý filter từ GET request
    $search = $_GET['search'] ?? '';
    $category_id = $_GET['category_id'] ?? '';
    
    // Xây dựng câu SQL động
    $sql = "SELECT 
                p.id,
                p.name AS product_name,
                p.price,
                p.stock,
                c.category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE 1=1";
    
    $params = [];
    
    // Thêm điều kiện tìm kiếm theo tên
    if (!empty($search)) {
        $sql .= " AND p.name LIKE :search";
        $params[':search'] = "%$search%";
    }
    
    // Thêm điều kiện lọc theo category
    if (!empty($category_id)) {
        $sql .= " AND p.category_id = :category_id";
        $params[':category_id'] = $category_id;
    }
    
    // Sắp xếp và thực thi
    $sql .= " ORDER BY p.id DESC";
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
    
} catch (PDOException $e) {
    die("❌ Lỗi: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        body {
            background: #f8f9fc;
            padding: 30px;
        }
        
        .container {
            max-width: 1600px;
            margin: 0 auto;
        }
        
        /* Header - Tối giản & Sang trọng */
        .header {
            background: #ffffff;
            padding: 40px;
            border-radius: 24px;
            margin-bottom: 40px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid #f0f0f0;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 500;
            color: #1a1a1a;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
        }
        
        .header p {
            color: #808080;
            font-size: 15px;
            font-weight: 300;
            letter-spacing: 0.3px;
        }
        
        .header-divider {
            width: 60px;
            height: 2px;
            background: #eaeaea;
            margin-top: 24px;
        }
        
        /* Stats Cards - Tinh tế */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: #ffffff;
            padding: 28px;
            border-radius: 20px;
            border: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            border-color: #d0d0d0;
            background: #fcfcfc;
        }
        
        .stat-icon {
            font-size: 32px;
            margin-bottom: 20px;
            color: #4a4a4a;
        }
        
        .stat-number {
            font-size: 34px;
            font-weight: 300;
            color: #1a1a1a;
            line-height: 1.2;
            margin-bottom: 8px;
        }
        
        .stat-label {
            color: #808080;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 400;
        }
        
        .stat-card.warning {
            background: #fcfcfc;
            border-left: 4px solid #d4a5a5;
        }
        
        .stat-card.warning .stat-number {
            color: #8b5e5e;
        }
        
        /* Filter Form - Tối giản */
        .filter-form {
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 40px;
            border: 1px solid #f0f0f0;
        }
        
        .filter-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        
        .filter-group {
            flex: 1;
            min-width: 250px;
        }
        
        .filter-group label {
            display: block;
            margin-bottom: 10px;
            color: #666;
            font-size: 13px;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        
        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e8e8e8;
            border-radius: 12px;
            font-size: 14px;
            color: #333;
            background: #ffffff;
            transition: all 0.2s;
        }
        
        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: #b0b0b0;
            background: #ffffff;
        }
        
        .filter-group input::placeholder {
            color: #b0b0b0;
            font-weight: 300;
        }
        
        .filter-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            letter-spacing: 0.3px;
        }
        
        .btn-primary {
            background: #2c2c2c;
            color: #ffffff;
            border: 1px solid #2c2c2c;
        }
        
        .btn-primary:hover {
            background: #1a1a1a;
            border-color: #1a1a1a;
        }
        
        .btn-secondary {
            background: transparent;
            color: #666;
            border: 1px solid #e0e0e0;
        }
        
        .btn-secondary:hover {
            background: #f5f5f5;
            border-color: #d0d0d0;
        }
        
        /* Products Table - Sang trọng */
        .table-container {
            background: #ffffff;
            border-radius: 24px;
            padding: 30px;
            border: 1px solid #f0f0f0;
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
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        td {
            padding: 20px 16px;
            border-bottom: 1px solid #f8f8f8;
            color: #444;
            font-size: 14px;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover td {
            background-color: #fafafa;
        }
        
        .product-id {
            color: #808080;
            font-size: 13px;
            font-family: 'SF Mono', monospace;
        }
        
        .product-name {
            font-weight: 500;
            color: #1a1a1a;
            font-size: 15px;
        }
        
        .price {
            color: #2c2c2c;
            font-weight: 500;
            font-size: 15px;
        }
        
        .category {
            display: inline-block;
            padding: 6px 16px;
            background: #f5f5f5;
            color: #666;
            font-size: 12px;
            border-radius: 40px;
            letter-spacing: 0.3px;
        }
        
        .stock {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 500;
            min-width: 70px;
            text-align: center;
        }
        
        .stock-high {
            background: #f0f7f0;
            color: #5a7a5a;
        }
        
        .stock-medium {
            background: #faf4e8;
            color: #9a7a5a;
        }
        
        .stock-low {
            background: #fdf2f2;
            color: #b15a5a;
        }
        
        /* Low stock row - Tinh tế */
        .low-stock-row {
            background: #fdf9f9;
        }
        
        .low-stock-row:hover td {
            background: #fcf5f5 !important;
        }
        
        .low-stock-row .stock-low {
            background: #f5e5e5;
            color: #a15a5a;
            font-weight: 500;
        }
        
        .warning-badge {
            display: inline-block;
            margin-left: 12px;
            padding: 4px 12px;
            background: #f5f5f5;
            color: #8b5e5e;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 30px;
        }
        
        /* No data */
        .no-data {
            text-align: center;
            padding: 80px 20px;
            color: #b0b0b0;
            font-size: 15px;
            background: #fafafa;
            border-radius: 16px;
        }
        
        .no-data small {
            display: block;
            margin-top: 12px;
            color: #c0c0c0;
            font-size: 13px;
        }
        
        /* Footer */
        .footer-info {
            text-align: center;
            margin-top: 40px;
            padding: 24px;
            color: #b0b0b0;
            font-size: 12px;
            border-top: 1px solid #f0f0f0;
        }
        
        .footer-info p {
            margin: 4px 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 16px;
            }
            
            .header {
                padding: 30px;
            }
            
            .filter-grid {
                flex-direction: column;
            }
            
            .filter-group {
                width: 100%;
            }
            
            .filter-actions {
                width: 100%;
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            th, td {
                padding: 16px 12px;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f5f5f5;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #d0d0d0;
            border-radius: 8px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #b0b0b0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header tối giản -->
        <div class="header">
            <h1>Product Admin Dashboard</h1>
            <p>Quản lý sản phẩm · Theo dõi tồn kho</p>
            <div class="header-divider"></div>
        </div>
        
        <?php
        // Tính toán thống kê
        $totalProducts = count($products);
        $totalStock = 0;
        $lowStockCount = 0;
        $totalValue = 0;
        
        foreach ($products as $p) {
            $totalStock += $p['stock'];
            $totalValue += $p['price'] * $p['stock'];
            if ($p['stock'] < 10) $lowStockCount++;
        }
        ?>
        
        <!-- Stats Cards tinh tế -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-number"><?= $totalProducts ?></div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-number"><?= number_format($totalStock) ?></div>
                <div class="stat-label">Lượng tồn kho</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-number"><?= number_format($totalValue / 1000000, 1) ?>M</div>
                <div class="stat-label">Giá trị kho</div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-icon">⚠️</div>
                <div class="stat-number"><?= $lowStockCount ?></div>
                <div class="stat-label">Cần nhập thêm</div>
            </div>
        </div>
        
        <!-- Filter Form tối giản -->
        <div class="filter-form">
            <form method="GET">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label>Tìm kiếm</label>
                        <input type="text" 
                               name="search" 
                               placeholder="Tên sản phẩm..."
                               value="<?= htmlspecialchars($search) ?>">
                    </div>
                    
                    <div class="filter-group">
                        <label>Danh mục</label>
                        <select name="category_id">
                            <option value="">Tất cả</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" 
                                        <?= $category_id == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">Áp dụng</button>
                        <a href="?" class="btn btn-secondary">Đặt lại</a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Products Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th>Tồn kho</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="5" class="no-data">
                                Không tìm thấy sản phẩm
                                <br>
                                <small>Thử thay đổi điều kiện lọc</small>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr class="<?= $product['stock'] < 10 ? 'low-stock-row' : '' ?>">
                                <td>
                                    <span class="product-id">#<?= str_pad($product['id'], 3, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td>
                                    <span class="product-name">
                                        <?= htmlspecialchars($product['product_name']) ?>
                                    </span>
                                    <?php if ($product['stock'] < 10): ?>
                                        <span class="warning-badge">Low stock</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="price">
                                        <?= number_format($product['price'], 0, ',', '.') ?>đ
                                    </span>
                                </td>
                                <td>
                                    <span class="category">
                                        <?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $stockClass = 'stock-high';
                                    if ($product['stock'] < 5) {
                                        $stockClass = 'stock-low';
                                    } elseif ($product['stock'] < 20) {
                                        $stockClass = 'stock-medium';
                                    }
                                    ?>
                                    <span class="stock <?= $stockClass ?>">
                                        <?= $product['stock'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Footer nhẹ nhàng -->
        <div class="footer-info">
            <p>⚡ Tồn kho dưới 10 sản phẩm được đánh dấu</p>
            <p>Prepared Statements · Bảo mật SQL Injection</p>
        </div>
    </div>
</body>
</html>