<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include "../includes/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KARAFLOW Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <div>
                <h1 class="admin-title">KARAFLOW Admin Panel</h1>
                <div class="admin-user">
                    Logged in as: <strong><?= htmlspecialchars($_SESSION['admin_username'] ?? 'admin') ?></strong>
                    <a href="logout.php" class="logout-btn">Log out</a>
                </div>
            </div>
        </div>
        
        <div class="admin-menu">
            <a href="songs.php" class="menu-card">
                <span class="menu-icon">🎵</span>
                <div class="menu-title">Manage Songs</div>
                <div class="menu-desc">Add, edit, and delete songs in the catalog</div>
            </a>
            
            <a href="add_song.php" class="menu-card">
                <span class="menu-icon">➕</span>
                <div class="menu-title">Add Song</div>
                <div class="menu-desc">Quickly add a new song to the catalog</div>
            </a>
            
            <a href="bookings.php" class="menu-card">
                <span class="menu-icon">📋</span>
                <div class="menu-title">Bookings</div>
                <div class="menu-desc">View all room and table bookings</div>
            </a>
            
            <a href="reviews.php" class="menu-card">
                <span class="menu-icon">⭐</span>
                <div class="menu-title">Reviews</div>
                <div class="menu-desc">Manage user reviews</div>
            </a>
        </div>
    </div>
    <script type="module" src="../assets/js/main.js"></script>
    <script type="module" src="../assets/js/data.js"></script>
    <script type="module" src="../assets/js/ui.js"></script>
    <script type="module" src="../assets/js/events.js"></script>
</body>

</html>
