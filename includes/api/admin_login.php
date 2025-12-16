<?php
header('Content-Type: application/json');
session_start();

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['password'])) {
    echo json_encode(['success' => false]);
    exit;
}

// Простая проверка (в реальном проекте используйте password_hash!)
if ($input['password'] === 'admin123') {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_login_time'] = time();
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>