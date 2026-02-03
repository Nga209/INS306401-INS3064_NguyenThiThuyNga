<?php
/**
 * utils.php
 * Reusable helper functions for sanitization and validation
 */

/**
 * Sanitize input data
 */
function sanitize($data) {
    return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
}

/**
 * Validate email format
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate string length
 */
function validateLength($str, $min, $max) {
    $length = strlen($str);
    return ($length >= $min && $length <= $max);
}

/**
 * Validate password
 * Rules:
 * - Minimum 8 characters
 * - At least one special character
 */
function validatePassword($pass) {
    if (strlen($pass) < 8) {
        return false;
    }

    // Check for special character
    return preg_match('/[\W]/', $pass);
}