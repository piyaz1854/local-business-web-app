<?php
header('Content-Type: application/json');
require_once "db.php"; // ← подключение к БД

// ==============================
// POST — ADD REVIEW
// ==============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $rating = intval($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($name === '') {
        $name = 'Anonymous';
    }

    if ($rating < 1 || $rating > 5 || $comment === '') {
        echo json_encode([
            "success" => false,
            "message" => "❌ Please fill all required fields"
        ]);
        exit;
    }
    $stmt = $conn->prepare(
        "INSERT INTO reviews (name, rating, comment) VALUES (?, ?, ?)"
    );

    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "❌ DB prepare error"
        ]);
        exit;
    }

    $stmt->bind_param("sis", $name, $rating, $comment);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "✅ Review submitted successfully"
    ]);
    exit;
}

// ==============================
// GET — LOAD REVIEWS
// ==============================
$result = $conn->query(
    "SELECT name, rating, comment, created_at 
     FROM reviews 
     ORDER BY created_at DESC"
);

$html = "";

while ($row = $result->fetch_assoc()) {
    $stars = str_repeat("⭐", $row['rating']);

    $html .= "
    <div class='review-card'>
        <div class='review-header'>
            <strong>{$row['name']}</strong>
            <span class='review-stars'>{$stars}</span>
        </div>
        <p>{$row['comment']}</p>
        <small>{$row['created_at']}</small>
    </div>
    ";
}

echo json_encode([
    "html" => $html
]);
