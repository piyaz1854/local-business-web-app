<?php
header("Content-Type: application/json");
require_once "db.php";

// Получаем данные
$client_name  = $_POST["client_name"] ?? "";
$phone        = $_POST["phone"] ?? "";
$email        = $_POST["email"] ?? null;
$booking_date = $_POST["booking_date"] ?? "";
$start_time   = $_POST["start_time"] ?? "";
$duration     = (int)($_POST["duration"] ?? 0);
$room_type    = $_POST["room_type"] ?? "";
$guests       = (int)($_POST["guests"] ?? 0);
$theme        = $_POST["theme"] ?? "Classic";
$comment      = $_POST["comment"] ?? null;

// Валидация
$allowed_room_types = ["Standard", "VIP", "Premium"];
$allowed_themes = ["Classic", "Neon", "Retro", "K-Pop", "Rock"];

if (
    empty($client_name) ||
    empty($phone) ||
    empty($booking_date) ||
    empty($start_time) ||
    $duration <= 0 ||
    $guests <= 0 ||
    !in_array($room_type, $allowed_room_types) ||
    !in_array($theme, $allowed_themes)
) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid input data"
    ]);
    exit;
}

// SQL
$sql = "INSERT INTO room_bookings 
(client_name, phone, email, booking_date, start_time, duration, room_type, guests, theme, comment)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "SQL prepare failed"
    ]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "sssssissss",
    $client_name,
    $phone,
    $email,
    $booking_date,
    $start_time,
    $duration,
    $room_type,
    $guests,
    $theme,
    $comment
);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "success" => true,
        "message" => "Room booked successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}

mysqli_stmt_close($stmt);
