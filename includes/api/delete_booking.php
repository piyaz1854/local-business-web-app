<?php
header('Content-Type: application/json');
session_start();
include '../db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$type = $_GET['type'];
$id = (int)$_GET['id'];

if ($type === 'room') {
    $sql = "DELETE FROM bookings WHERE id = ?";
} elseif ($type === 'table') {
    $sql = "DELETE FROM table_bookings WHERE id = ?";
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid type']);
    exit;
}

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

echo json_encode(['success' => true, 'message' => 'Booking deleted']);
?>