<?php
// courses/delete.php
// Xóa khóa học, đã có confirm() bên client
// Lưu ý: do ON DELETE CASCADE, khi xóa khóa học sẽ tự động xóa các enrollment liên quan

require_once __DIR__ . '/../classes/Database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $db = Database::getInstance();
    
    // (Tùy chọn) Kiểm tra xem khóa học có tồn tại không trước khi xóa
    $course = $db->fetch('SELECT id FROM courses WHERE id = ?', [$id]);
    if (!$course) {
        header('Location: index.php');
        exit;
    }
    
    $db->delete('courses', 'id = ?', [$id]);
} catch (Exception $e) {
    // Log lỗi nếu cần, có thể redirect với thông báo lỗi
    // error_log('Delete course failed: ' . $e->getMessage());
}

header('Location: index.php?deleted=1');
exit;