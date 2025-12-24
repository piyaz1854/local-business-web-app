<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include "../includes/db.php";

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM songs WHERE id = $id");
    $conn->query("DELETE FROM favorites WHERE song_id = $id");
    header('Location: songs.php?deleted=1');
    exit;
}

$search = $_GET['search'] ?? '';
$where = '';
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $where = "WHERE title LIKE '%$search_safe%' OR artist LIKE '%$search_safe%' OR genre LIKE '%$search_safe%'";
}

$songs = mysqli_query($conn, "SELECT * FROM songs $where ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление песнями</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">🎵 Управление песнями</h1>
            
            <div class="admin-actions">
                <form method="GET" class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" name="search" class="search-input" placeholder="Поиск песен..." 
                           value="<?= htmlspecialchars($search) ?>">
                </form>
                
                <a href="add_song.php" class="btn-admin btn-primary">➕ Добавить песню</a>
                <a href="index.php" class="btn-admin btn-secondary">← Назад в админку</a>
            </div>
        </div>
        
        <?php if (isset($_GET['deleted'])): ?>
            <div class="message success">✅ Песня успешно удалена!</div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="songs-table">
                <thead>
                    <tr>
                        <th width="50"><span class="table-header-icon">#</span> ID</th>
                        <th>Название</th>
                        <th>Исполнитель</th>
                        <th>Жанр</th>
                        <th>Год</th>
                        <th>Язык</th>
                        <th class="youtube-cell">YouTube ID</th>
                        <th width="150">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($songs) > 0): ?>
                        <?php while ($song = mysqli_fetch_assoc($songs)): ?>
                            <tr>
                                <td><?= $song['id'] ?></td>
                                <td><strong><?= htmlspecialchars($song['title']) ?></strong></td>
                                <td><?= htmlspecialchars($song['artist']) ?></td>
                                <td><?= htmlspecialchars($song['genre']) ?></td>
                                <td><?= $song['year'] ?></td>
                                <td><?= htmlspecialchars($song['language']) ?></td>
                                <td class="youtube-cell">
                                    <?php if ($song['youtube_id']): ?>
                                        <a href="https://youtube.com/watch?v=<?= $song['youtube_id'] ?>" 
                                           target="_blank" style="color: #ff6666;">
                                            <?= $song['youtube_id'] ?>
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #aaa;">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions-cell">
                                    <a href="edit_song.php?id=<?= $song['id'] ?>" 
                                    class="btn-action btn-view" title="Редактировать песню">✏️</a>
                                    
                                    <a href="songs.php?delete=<?= $song['id'] ?>" 
                                    class="btn-action btn-delete"
                                    onclick="return confirm('Удалить песню «<?= addslashes($song['title']) ?>»?')"
                                    title="Удалить песню">
                                        🗑️
                                    </a>
                                    
                                    <?php if (!empty($song['youtube_id'])): ?>
                                        <a href="../public/karaoke.php?song_id=<?= $song['id'] ?>" 
                                        target="_blank" 
                                        class="btn-action btn-test"
                                        title="Тестировать караоке">
                                            ▶️ Тест
                                        </a>
                                    <?php else: ?>
                                        <span class="btn-action btn-disabled" title="Нет YouTube ID">
                                            ⏸️ Нет ID
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="empty-message">
                                <?php if ($search): ?>
                                    🎵 Песни по запросу "<?= htmlspecialchars($search) ?>" не найдены
                                <?php else: ?>
                                    🎵 Песен пока нет. Добавьте первую!
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script type="module" src="../assets/js/main.js"></script>
    <script type="module" src="../assets/js/data.js"></script>
    <script type="module" src="../assets/js/ui.js"></script>
    <script type="module" src="../assets/js/events.js"></script>
</body>
</html>