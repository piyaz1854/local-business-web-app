<?php
header('Content-Type: application/json');
include '../db.php';

$sql = "SELECT * FROM menu_items";
$stmt = $pdo->query($sql);
$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($menu);
?>