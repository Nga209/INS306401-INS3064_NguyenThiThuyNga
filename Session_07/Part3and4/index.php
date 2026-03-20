<?php
// File: index.php
require_once 'Database.php';

$db = Database::getInstance()->getConnection();

try {
    // Lấy danh sách categories
    $categories = $db->query("SELECT * FROM categories ORDER BY category_name")->fetchAll();
    
    // Xử lý filter
    $search = $_GET['search'] ?? '';
    $category_id = $_GET['category_id'] ?? '';
    
    // Xây dựng câu SQL
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
    
    if (!empty($search)) {
        $sql .= " AND p.name LIKE :search";
        $params[':search'] = "%$search%";
    }
    
    if (!empty($category_id)) {
        $sql .= " AND p.category_id = :category_id";
        $params[':category_id'] = $category_id;
    }
    
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
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
        
        <!-- Stats Cards -->
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
        
        <!-- Filter Form -->
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
                            <option value="">Tất cả danh mục</option>
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
                                <td class="price">
                                    <?= number_format($product['price'], 0, ',', '.') ?>đ
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
        
        <!-- Footer -->
        <div class="footer-info">
            <p>⚡ Tồn kho dưới 10 sản phẩm được đánh dấu</p>
            <p><a href="top_customers.php" style="color: #64748b; text-decoration: none; border-bottom: 1px dashed #cbd5e1;">Xem Top 3 Khách Hàng VIP →</a></p>
        </div>
    </div>
</body>
</html>