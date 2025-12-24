<?php
header("Content-Type: application/json");
require_once "db.php";

$client_name  = trim($_POST["client_name"] ?? "");
$phone        = trim($_POST["phone"] ?? "");
$email        = trim($_POST["email"] ?? null);
$booking_date = $_POST["booking_date"] ?? "";
$start_time   = $_POST["start_time"] ?? "";
$duration     = (int)($_POST["duration"] ?? 0);
$room_type = trim($_POST["room_type"] ?? "");
$guests       = (int)($_POST["guests"] ?? 0);
$comment      = trim($_POST["comment"] ?? null);

$allowed_room_types = ["Standard", "VIP", "Premium"];

if (
    $client_name === "" ||
    $phone === "" ||
    $booking_date === "" ||
    $start_time === "" ||
    $duration <= 0 ||
    $guests <= 0 ||
    !in_array($room_type, $allowed_room_types)
) {
    echo json_encode([
        "success" => false,
        "message" => "❌ Invalid input data",
        "debug" => $_POST
    ]);
    exit;
}

$sql = "
INSERT INTO room_bookings
(client_name, phone, email, booking_date, start_time, duration, room_type, guests, comment)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssssisis",
    $client_name,
    $phone,
    $email,
    $booking_date,
    $start_time,
    $duration,
    $room_type,
    $guests,
    $comment
);

mysqli_stmt_execute($stmt);

echo json_encode([
    "success" => true,
    "message" => "✅ Room booked successfully"
]);
