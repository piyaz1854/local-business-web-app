<?php
session_start();

// Простая авторизация админа (в реальном проекте нужно хэшировать пароль!)
function adminLogin($password) {
    $admin_pass = 'admin123'; // Простой пароль для демо
    if ($password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_login_time'] = time();
        return true;
    }
    return false;
}

function adminLogout() {
    session_unset();
    session_destroy();
}

function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Автоматический выход через 1 час
if (isset($_SESSION['admin_login_time']) && (time() - $_SESSION['admin_login_time'] > 3600)) {
    adminLogout();
}
?>