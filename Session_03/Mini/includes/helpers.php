<?php
// Hàm xử lý input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Hàm validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Hàm validate password
function validatePassword($password) {
    return preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/', $password);
}

// Kiểm tra login attempts
function isBlocked($email) {
    if (!isset($_SESSION['login_attempts'][$email])) {
        return false;
    }
    
    $attempts = $_SESSION['login_attempts'][$email];
    if (count($attempts) >= MAX_LOGIN_ATTEMPTS) {
        $lastAttempt = end($attempts);
        if (time() - $lastAttempt < BLOCK_DURATION) {
            return true;
        } else {
            // Reset sau khi hết thời gian block
            unset($_SESSION['login_attempts'][$email]);
        }
    }
    return false;
}

// Thêm login attempt
function addLoginAttempt($email) {
    if (!isset($_SESSION['login_attempts'][$email])) {
        $_SESSION['login_attempts'][$email] = [];
    }
    $_SESSION['login_attempts'][$email][] = time();
}

// Lấy thông báo lỗi
function getErrorMessage() {
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
        return $error;
    }
    return '';
}

// Lấy thông báo thành công
function getSuccessMessage() {
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
        return $success;
    }
    return '';
}
?>