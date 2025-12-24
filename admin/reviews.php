<?php
session_start();

include "../includes/db.php";

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM reviews WHERE id = $id");
    header('Location: reviews.php?deleted=1');
    exit;
}

$rating_filter = '';
$current_rating = null;

if (isset($_GET['rating']) && is_numeric($_GET['rating'])) {
    $rating_value = (int)$_GET['rating'];
    if ($rating_value >= 1 && $rating_value <= 5) {
        $rating_filter = "WHERE rating = $rating_value";
        $current_rating = $rating_value;
    }
}

$reviews_query = "SELECT * FROM reviews $rating_filter ORDER BY created_at DESC";
$reviews = mysqli_query($conn, $reviews_query);
$total_reviews = mysqli_num_rows($reviews);

$avg_query = "SELECT AVG(rating) as avg FROM reviews";
if ($rating_filter) {
    $avg_query .= " $rating_filter";
}
$avg_result = mysqli_query($conn, $avg_query);
$avg_row = mysqli_fetch_assoc($avg_result);
$avg_rating = $avg_row['avg'] ? round($avg_row['avg'], 1) : 0;

$rating_counts = [];
for ($i = 1; $i <= 5; $i++) {
    $count_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM reviews WHERE rating = $i");
    $count_row = mysqli_fetch_assoc($count_result);
    $rating_counts[$i] = $count_row['count'];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отзывы - Админка</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">
                <?php if ($current_rating): ?>
                    ⭐ Отзывы с рейтингом <?= $current_rating ?> звезд
                <?php else: ?>
                    ⭐ Все отзывы
                <?php endif; ?>
            </h1>
            <a href="index.php" class="back-link">← Назад в админку</a>
        </div>
        
        <?php if (isset($_GET['deleted'])): ?>
            <div class="message success">✅ Отзыв успешно удален!</div>
        <?php endif; ?>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-number"><?= $total_reviews ?></div>
                <div class="stat-label">Всего отзывов</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">🏆</div>
                <div class="stat-number"><?= $avg_rating ?>/5</div>
                <div class="stat-label">Средний рейтинг</div>
            </div>
        </div>
        
        <div class="filters">
            <a href="reviews.php" class="filter-btn <?= !isset($_GET['rating']) ? 'active' : '' ?>">
                Все (<?= array_sum($rating_counts) ?>)
            </a>
            <a href="reviews.php?rating=5" class="filter-btn <?= isset($_GET['rating']) && $_GET['rating'] == 5 ? 'active' : '' ?>">
                ⭐⭐⭐⭐⭐ (<?= $rating_counts[5] ?>)
            </a>
            <a href="reviews.php?rating=4" class="filter-btn <?= isset($_GET['rating']) && $_GET['rating'] == 4 ? 'active' : '' ?>">
                ⭐⭐⭐⭐ (<?= $rating_counts[4] ?>)
            </a>
            <a href="reviews.php?rating=3" class="filter-btn <?= isset($_GET['rating']) && $_GET['rating'] == 3 ? 'active' : '' ?>">
                ⭐⭐⭐ (<?= $rating_counts[3] ?>)
            </a>
            <a href="reviews.php?rating=2" class="filter-btn <?= isset($_GET['rating']) && $_GET['rating'] == 2 ? 'active' : '' ?>">
                ⭐⭐ (<?= $rating_counts[2] ?>)
            </a>
            <a href="reviews.php?rating=1" class="filter-btn <?= isset($_GET['rating']) && $_GET['rating'] == 1 ? 'active' : '' ?>">
                ⭐ (<?= $rating_counts[1] ?>)
            </a>
        </div>
        
        <div class="reviews-grid">
            <?php if ($total_reviews > 0): ?>
                <?php 
                mysqli_data_seek($reviews, 0);
                while ($review = mysqli_fetch_assoc($reviews)): 
                    $date = date('d.m.Y H:i', strtotime($review['created_at']));
                    $first_letter = mb_substr($review['name'], 0, 1, 'UTF-8');
                ?>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar" title="Аватар пользователя">
                                    <?= strtoupper($first_letter) ?>
                                </div>
                                <div>
                                    <div class="reviewer-name"><?= htmlspecialchars($review['name']) ?></div>
                                    <div class="review-stars">
                                        <?= str_repeat('⭐', $review['rating']) ?>
                                        <span class="rating-badge rating-<?= $review['rating'] ?>">
                                            <?= $review['rating'] ?>/5
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="review-id">ID: <?= $review['id'] ?></span>
                        </div>
                        
                        <div class="review-text">
                            <?= nl2br(htmlspecialchars($review['comment'])) ?>
                        </div>
                        
                        <div class="review-footer">
                            <span>📅 <?= $date ?></span>
                            <a href="reviews.php?delete=<?= $review['id'] ?><?= $current_rating ? '&rating=' . $current_rating : '' ?>" 
                               class="delete-review-btn"
                               onclick="return confirm('Удалить отзыв от <?= addslashes($review['name']) ?>?\nРейтинг: <?= $review['rating'] ?>/5')">
                                🗑️ Удалить
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-message">
                    <?php if ($current_rating): ?>
                        ⭐ Отзывов с рейтингом <?= $current_rating ?> звезд пока нет
                    <?php else: ?>
                        ⭐ Отзывов пока нет
                    <?php endif; ?>
                    <div style="margin-top: 15px; font-size: 14px; color: #666;">
                        <?php if ($current_rating): ?>
                            Пользователи еще не оставляли отзывы с таким рейтингом
                        <?php else: ?>
                            Пользователи еще не оставляли отзывы
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script type="module" src="../assets/js/main.js"></script>
    <script type="module" src="../assets/js/data.js"></script>
    <script type="module" src="../assets/js/ui.js"></script>
    <script type="module" src="../assets/js/events.js"></script>
</body>
</html>