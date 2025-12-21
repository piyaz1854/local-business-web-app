<?php
// НИКАКИХ include, header, html — ТОЛЬКО PHP

echo "Trying MySQL connection...\n<br>";

$host = "127.0.0.1";
$port = 3306;
$user = "root";
$pass = "";
$db   = "karaflow_db";

$conn = @mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
  die("❌ mysqli_connect_error: " . mysqli_connect_error());
}

echo "✅ Connected successfully!<br>";
echo "Server info: " . mysqli_get_server_info($conn);
