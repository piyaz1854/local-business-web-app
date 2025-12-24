<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include "../includes/db.php";

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
        $error = 'Please fill in all required fields correctly';
    } else {
        $check = mysqli_query($conn, 
            "SELECT id FROM songs WHERE title = '" . mysqli_real_escape_string($conn, $title) . "' 
             AND artist = '" . mysqli_real_escape_string($conn, $artist) . "'"
        );
        
        if (mysqli_num_rows($check) > 0) {
            $error = 'This song is already in the catalog';
        } else {
            $stmt = $conn->prepare("INSERT INTO songs (title, artist, genre, year, duration, language, youtube_id) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssisss", $title, $artist, $genre, $year, $duration, $language, $youtube_id);
            
            if ($stmt->execute()) {
                $success = 'Song added successfully!';
                $_POST = [];
            } else {
                $error = 'Database error: ' . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Song</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">+ Add New Song</h1>
        </div>
        
        <?php if ($success): ?>
            <div class="message success">✅<?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error">❌<?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required" for="title">Song Title:</label>
                        <input type="text" id="title" name="title" class="form-control" 
                               value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required" for="artist">Artist:</label>
                        <input type="text" id="artist" name="artist" class="form-control" 
                               value="<?= htmlspecialchars($_POST['artist'] ?? '') ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required" for="genre">Genre:</label>
                        <select id="genre" name="genre" class="form-control" required>
                            <option value="">Select a genre</option>
                            <option value="Pop" <?= ($_POST['genre'] ?? '') === 'Pop' ? 'selected' : '' ?>>Pop</option>
                            <option value="Rock" <?= ($_POST['genre'] ?? '') === 'Rock' ? 'selected' : '' ?>>Rock</option>
                            <option value="Rap" <?= ($_POST['genre'] ?? '') === 'Rap' ? 'selected' : '' ?>>Rap</option>
                            <option value="K-Pop" <?= ($_POST['genre'] ?? '') === 'K-Pop' ? 'selected' : '' ?>>K-Pop</option>
                            <option value="Hip-Hop" <?= ($_POST['genre'] ?? '') === 'Hip-Hop' ? 'selected' : '' ?>>Hip-Hop</option>
                            <option value="Other" <?= ($_POST['genre'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required" for="year">Release Year:</label>
                        <input type="number" id="year" name="year" class="form-control" 
                               min="1900" max="<?= date('Y') ?>" 
                               value="<?= htmlspecialchars($_POST['year'] ?? date('Y') - 1) ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required" for="duration">Duration:</label>
                        <input type="text" id="duration" name="duration" class="form-control" 
                               placeholder="MM:SS, e.g.: 03:45"
                               value="<?= htmlspecialchars($_POST['duration'] ?? '') ?>" required>
                        <span class="form-help">Format: minutes:seconds (e.g., 03:45)</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required" for="language">Language:</label>
                        <select id="language" name="language" class="form-control" required>
                            <option value="">Select a language</option>
                            <option value="English" <?= ($_POST['language'] ?? '') === 'English' ? 'selected' : '' ?>>English</option>
                            <option value="Russian" <?= ($_POST['language'] ?? '') === 'Russian' ? 'selected' : '' ?>>Russian</option>
                            <option value="Kazakh" <?= ($_POST['language'] ?? '') === 'Kazakh' ? 'selected' : '' ?>>Kazakh</option>
                            <option value="Korean" <?= ($_POST['language'] ?? '') === 'Korean' ? 'selected' : '' ?>>Korean</option>
                            <option value="Other" <?= ($_POST['language'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="youtube_id">YouTube ID:</label>
                    <input type="text" id="youtube_id" name="youtube_id" class="form-control" 
                           placeholder="For example: liTfD88dbCo"
                           value="<?= htmlspecialchars($_POST['youtube_id'] ?? '') ?>">
                    <span class="form-help">
                        YouTube video ID (the part after watch?v= in the URL).
                    </span>
                </div>
                
                <div class="form-actions">
                    <div>
                        <a href="songs.php" class="btn-admin btn-secondary">← Back to list</a>
                        <a href="index.php" class="btn-admin btn-secondary">Back to dashboard</a>
                    </div>
                    
                    <button type="submit" class="btn-admin btn-primary">💾 Save Song</button>
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
