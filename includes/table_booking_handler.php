<?php
require_once "db.php";
header("Content-Type: application/json");

try {
    $stmt = $conn->prepare("
        INSERT INTO table_bookings
        (client_name, phone, booking_date, booking_time, guests, table_zone, smoking, comment)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssisss",
        $_POST['client_name'],
        $_POST['phone'],
        $_POST['booking_date'],
        $_POST['booking_time'],
        $_POST['guests'],
        $_POST['table_zone'],
        $_POST['smoking'],
        $_POST['comment']
    );

    $stmt->execute();

    echo json_encode([
        "status" => "success",
        "message" => "✅ Table booked successfully!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "❌ Booking failed"
    ]);
}
