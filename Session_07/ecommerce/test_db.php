<?php
// File: test_db.php
require_once 'Database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "Kết nối database thành công!";
    
    // Kiểm tra query đơn giản
    $stmt = $db->query("SELECT COUNT(*) as total FROM users");
    $result = $stmt->fetch();
    echo "<br> Tổng số users: " . $result['total'];
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>