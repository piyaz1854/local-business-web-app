<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include "../includes/db.php";

$song_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($song_id <= 0) {
    header('Location: songs.php');
    exit;
}

$song = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM songs WHERE id = $song_id"));

if (!$song) {
    header('Location: songs.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $artist = trim($_POST['artist'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $duration = trim($_POST['duration'] ?? '');
    $language = trim($_POST['language'] ?? '');
    $youtube_id = trim($_POST['youtube_id'] ?? '');
    
    if (empty($title) || empty($artist) || empty($genre) || $year < 1900 || $year > date('Y')) {
        $error = 'Пожалуйста, заполните все обязательные поля корректно';
    } else {
        $check = mysqli_query($conn, 
            "SELECT id FROM songs WHERE title = '" . mysqli_real_escape_string($conn, $title) . "' 
             AND artist = '" . mysqli_real_escape_string($conn, $artist) . "'
             AND id != $song_id"
        );
        
        if (mysqli_num_rows($check) > 0) {
            $error = 'Эта песня уже есть в каталоге';
        } else {
            $stmt = $conn->prepare("UPDATE songs SET title = ?, artist = ?, genre = ?, year = ?, 
                                   duration = ?, language = ?, youtube_id = ? WHERE id = ?");
            $stmt->bind_param("sssisssi", $title, $artist, $genre, $year, $duration, $language, $youtube_id, $song_id);
            
            if ($stmt->execute()) {
                $success = 'Песня успешно обновлена!';
                $song = array_merge($song, [
                    'title' => $title,
                    'artist' => $artist,
                    'genre' => $genre,
                    'year' => $year,
                    'duration' => $duration,
                    'language' => $language,
                    'youtube_id' => $youtube_id
                ]);
            } else {
                $error = 'Ошибка базы данных: ' . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать песню</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">✏️ Редактировать песню</h1>
            <div class="song-info">
                Редактирование: <strong><?= htmlspecialchars($song['title']) ?></strong> 
                — <strong><?= htmlspecialchars($song['artist']) ?></strong>
                (ID: <?= $song['id'] ?>)
            </div>
        </div>
        
        <?php if ($success): ?>
            <div class="message success">✅ <?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error">❌ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required" for="title">Название песни:</label>
                        <input type="text" id="title" name="title" class="form-control" 
                               value="<?= htmlspecialchars($song['title']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required" for="artist">Исполнитель:</label>
                        <input type="text" id="artist" name="artist" class="form-control" 
                               value="<?= htmlspecialchars($song['artist']) ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required" for="genre">Жанр:</label>
                        <select id="genre" name="genre" class="form-control" required>
                            <option value="">Выберите жанр</option>
                            <option value="Pop" <?= $song['genre'] === 'Pop' ? 'selected' : '' ?>>Pop</option>
                            <option value="Rock" <?= $song['genre'] === 'Rock' ? 'selected' : '' ?>>Rock</option>
                            <option value="Rap" <?= $song['genre'] === 'Rap' ? 'selected' : '' ?>>Rap</option>
                            <option value="K-Pop" <?= $song['genre'] === 'K-Pop' ? 'selected' : '' ?>>K-Pop</option>
                            <option value="Hip-Hop" <?= $song['genre'] === 'Hip-Hop' ? 'selected' : '' ?>>Hip-Hop</option>
                            <option value="Other" <?= $song['genre'] === 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required" for="year">Год выпуска:</label>
                        <input type="number" id="year" name="year" class="form-control" 
                               min="1900" max="<?= date('Y') ?>" 
                               value="<?= $song['year'] ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required" for="duration">Длительность:</label>
                        <input type="text" id="duration" name="duration" class="form-control" 
                               placeholder="MM:SS, например: 03:45"
                               value="<?= htmlspecialchars($song['duration']) ?>" required>
                        <span class="form-help">Формат: минуты:секунды (например: 03:45)</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required" for="language">Язык:</label>
                        <select id="language" name="language" class="form-control" required>
                            <option value="">Выберите язык</option>
                            <option value="English" <?= $song['language'] === 'English' ? 'selected' : '' ?>>English</option>
                            <option value="Russian" <?= $song['language'] === 'Russian' ? 'selected' : '' ?>>Russian</option>
                            <option value="Kazakh" <?= $song['language'] === 'Kazakh' ? 'selected' : '' ?>>Kazakh</option>
                            <option value="Korean" <?= $song['language'] === 'Korean' ? 'selected' : '' ?>>Korean</option>
                            <option value="Other" <?= $song['language'] === 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="youtube_id">YouTube ID:</label>
                    <input type="text" id="youtube_id" name="youtube_id" class="form-control" 
                           placeholder="Например: liTfD88dbCo"
                           value="<?= htmlspecialchars($song['youtube_id']) ?>">
                    <span class="form-help">
                        ID видео на YouTube (после watch?v= в ссылке)
                    </span>
                    
                    <?php if ($song['youtube_id']): ?>
                        <div class="youtube-preview">
                            Текущая ссылка: 
                            <a href="https://youtube.com/watch?v=<?= $song['youtube_id'] ?>" 
                               target="_blank">
                                https://youtube.com/watch?v=<?= $song['youtube_id'] ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-actions">
                    <div>
                        <a href="songs.php" class="btn-admin btn-secondary">← Назад к списку</a>
                        <a href="index.php" class="btn-admin btn-secondary">В админку</a>
                        <?php if (!empty($song['youtube_id'])): ?>
                            <a href="../public/karaoke.php?id=<?= $song['id'] ?>" target="_blank" class="btn-test-large">🎤 Тест</a>
                        <?php else: ?>
                            <span class="btn-disabled-large">⏸️ Добавьте YouTube ID для теста</span>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn-admin btn-primary">💾 Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
    
    <script type="module" src="../assets/js/main.js"></script>
    <script type="module" src="../assets/js/data.js"></script>
    <script type="module" src="../assets/js/ui.js"></script>
    <script type="module" src="../assets/js/events.js"></script>

</body>
</html>