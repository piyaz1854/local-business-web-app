<?php
header('Content-Type: application/json');
session_start();
include '../db.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

$input = json_decode(file_get_contents('php://input'), true);

// Валидация
if (
    !isset($input['name']) || empty($input['name']) ||
    !isset($input['phone']) || empty($input['phone']) ||
    !isset($input['date']) || empty($input['date']) ||
    !isset($input['time']) || empty($input['time']) ||
    !isset($input['type']) || !in_array($input['type'], ['small', 'medium', 'large'])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

// Проверяем доступность кабинки на это время
$checkSql = "SELECT id FROM bookings WHERE room_type = ? AND booking_date = ? AND booking_time = ?";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([$input['type'], $input['date'], $input['time']]);

if ($checkStmt->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'Room already booked for this time']);
    exit;
}

// Вставляем
$sql = "INSERT INTO bookings (client_name, phone, booking_date, booking_time, room_type, theme) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        htmlspecialchars($input['name']),
        htmlspecialchars($input['phone']),
        $input['date'],
        $input['time'],
        $input['type'],
        $input['theme'] ?? ''
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Room booked successfully!',
        'booking_id' => $pdo->lastInsertId()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>