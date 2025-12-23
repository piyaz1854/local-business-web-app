<?php
$host = "127.0.0.1";
$user = "root";
$pass = "Abltasher1700";
$db   = "karaflow_db";
$port = 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed: " . mysqli_connect_error()
    ]);
    exit;
}
