<?php
/**
 * CSRF Protection Utility
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate CSRF token if it doesn't exist
 */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Returns current CSRF token
 *
 * @return string
 */
function csrf_token() {
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 *
 * @param string|null $token
 * @return bool
 */
function validate_csrf($token) {
    $valid = isset($_SESSION['csrf_token']) &&
             hash_equals($_SESSION['csrf_token'], $token ?? '');

    // Rotate token after successful validation
    if ($valid) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $valid;
}

/**
 * Require valid CSRF token or terminate request
 *
 * @return void
 */
function require_csrf() {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }
}