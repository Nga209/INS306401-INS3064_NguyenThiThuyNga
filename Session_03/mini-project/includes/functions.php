<?php
session_start();

// Milestone 3: Access Control
function checkLoggedIn() {
    if (!isset($_SESSION['user_logged_in'])) {
        header("Location: login.php");
        exit();
    }
}

// Checklist: XSS Protection
function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>