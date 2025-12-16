<?php
header('Content-Type: application/json');
session_start();
include '../db.php';

// Проверка сессии (простая защита админки)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Получаем бронирования кабинок
$roomSql = "SELECT * FROM bookings ORDER BY booking_date DESC, booking_time DESC";
$roomStmt = $pdo->query($roomSql);
$roomBookings = $roomStmt->fetchAll(PDO::FETCH_ASSOC);

// Получаем бронирования столов
$tableSql = "SELECT * FROM table_bookings ORDER BY booking_date DESC";
$tableStmt = $pdo->query($tableSql);
$tableBookings = $tableStmt->fetchAll(PDO::FETCH_ASSOC);

// Объединяем в один ответ
echo json_encode([
    'room_bookings' => $roomBookings,
    'table_bookings' => $tableBookings
]);
?>