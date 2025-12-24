<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include "../includes/db.php";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель KARAFLOW</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <div>
                <h1 class="admin-title">Админ-панель KARAFLOW</h1>
                <div class="admin-user">
                    Вы вошли как: <strong><?= htmlspecialchars($_SESSION['admin_username'] ?? 'admin') ?></strong>
                    <a href="logout.php" class="logout-btn">Выйти</a>
                </div>
            </div>
        </div>
        
        <div class="admin-menu">
            <a href="songs.php" class="menu-card">
                <span class="menu-icon">🎵</span>
                <div class="menu-title">Управление песнями</div>
                <div class="menu-desc">Добавляйте, редактируйте и удаляйте песни в каталоге</div>
            </a>
            
            <a href="add_song.php" class="menu-card">
                <span class="menu-icon">➕</span>
                <div class="menu-title">Добавить песню</div>
                <div class="menu-desc">Быстро добавить новую песню в каталог</div>
            </a>
            
            <a href="bookings.php" class="menu-card">
                <span class="menu-icon">📋</span>
                <div class="menu-title">Бронирования</div>
                <div class="menu-desc">Просмотр всех бронирований комнат и столов</div>
            </a>
            
            <a href="reviews.php" class="menu-card">
                <span class="menu-icon">⭐</span>
                <div class="menu-title">Отзывы</div>
                <div class="menu-desc">Управление отзывами пользователей</div>
            </a>
        </div>
    </div>
    <script type="module" src="../assets/js/main.js"></script>
    <script type="module" src="../assets/js/data.js"></script>
    <script type="module" src="../assets/js/ui.js"></script>
    <script type="module" src="../assets/js/events.js"></script>
</body>

</html>