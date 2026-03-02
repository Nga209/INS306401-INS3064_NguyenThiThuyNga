<?php
session_start();

// Cấu hình cơ bản
define('SITE_NAME', 'User Profile System');
define('MAX_LOGIN_ATTEMPTS', 3);
define('ALLOWED_AVATAR_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('MAX_AVATAR_SIZE', 2 * 1024 * 1024); // 2MB
define('BLOCK_DURATION', 300); // 5 phút

// Kiểm tra session
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = [];
}

// Kiểm tra chế độ ẩn danh
function isIncognito() {
    return !isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT']);
}
?>