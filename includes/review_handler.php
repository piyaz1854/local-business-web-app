<?php
header('Content-Type: application/json');
require_once "db.php";

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
// GET — LOAD LAST 5 REVIEWS
// ==============================
$result = $conn->query(
    "SELECT name, rating, comment, created_at
     FROM reviews
     ORDER BY created_at DESC
     LIMIT 5"
);

$html = "";

while ($row = $result->fetch_assoc()) {

    $name = htmlspecialchars($row['name']);
    $comment = nl2br(htmlspecialchars($row['comment']));
    $date = htmlspecialchars($row['created_at']);
    $stars = str_repeat("⭐", (int)$row['rating']);

    $html .= "
    <div class='review-card'>
        <div class='review-header'>
            <strong>{$name}</strong>
            <span class='review-stars'>{$stars}</span>
        </div>
        <p>{$comment}</p>
        <small>{$date}</small>
    </div>
    ";
}

echo json_encode([
    "html" => $html
]);
