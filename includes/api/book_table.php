<?php
header('Content-Type: application/json');
session_start();
include '../db.php';

// Разрешаем запросы с других доменов (для разработки)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Получаем JSON-данные из запроса
$input = json_decode(file_get_contents('php://input'), true);

// Валидация данных
if (
    !isset($input['name']) || empty($input['name']) ||
    !isset($input['phone']) || empty($input['phone']) ||
    !isset($input['date']) || empty($input['date']) ||
    !isset($input['guests']) || $input['guests'] < 1 || $input['guests'] > 5 ||
    !isset($input['table']) || $input['table'] < 1 || $input['table'] > 10 ||
    !isset($input['payment']) || !in_array($input['payment'], ['cash', 'card', 'online'])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

// Проверяем, не забронирован ли уже стол на эту дату
$checkSql = "SELECT id FROM table_bookings WHERE table_number = ? AND booking_date = ?";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([$input['table'], $input['date']]);

if ($checkStmt->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'Table already booked for this date']);
    exit;
}

// Вставляем бронирование
$sql = "INSERT INTO table_bookings (client_name, phone, booking_date, guests, table_number, payment_method) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        htmlspecialchars($input['name']),
        htmlspecialchars($input['phone']),
        $input['date'],
        $input['guests'],
        $input['table'],
        $input['payment']
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Table booked successfully!',
        'booking_id' => $pdo->lastInsertId()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>