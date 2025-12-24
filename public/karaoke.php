<?php 
include "../includes/header.php"; 
include "../includes/db.php";

$song_id = isset($_GET['song_id']) ? (int)$_GET['song_id'] : 0;

$song = null;
if ($song_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM songs WHERE id = ?");
    $stmt->bind_param("i", $song_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $song = $result->fetch_assoc();
}

if (!$song) {
    header("Location: songs.php");
    exit();
}

$search_query = urlencode($song['title'] . ' ' . $song['artist'] . ' karaoke version');

if (!empty($song['youtube_id']) && $song['youtube_id'] !== 'NULL') {
    $youtube_url = "https://www.youtube.com/embed/{$song['youtube_id']}?autoplay=1&controls=1&rel=0";
} else {
    $youtube_url = "https://www.youtube.com/embed?listType=search&list={$search_query}&autoplay=1&controls=1&rel=0";
}
?>

<section class="karaoke-simple">
    <div class="simple-header">
        <h1>🎤 <?= htmlspecialchars($song['title']) ?></h1>
        <h2><?= htmlspecialchars($song['artist']) ?></h2>
    </div>

    <div class="youtube-fullscreen">
        <iframe 
            id="youtubePlayer"
            width="100%" 
            height="600" 
            src="<?= $youtube_url ?>" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
    </div>

    <div class="simple-controls">
        <button id="favoriteBtn" onclick="toggleFavorite(<?= $song_id ?>)" class="control-btn favorite">
            🤍 Add to Favorites
        </button>
        <button onclick="window.history.back()" class="control-btn back">
            ← Back to Songs
        </button>
    </div>
</section>

<style>
.karaoke-simple {
    padding: 20px;
    min-height: 100vh;
    background: #000;
}

.simple-header {
    text-align: center;
    padding: 20px;
    background: rgba(255, 0, 255, 0.1);
    border-radius: 10px;
    margin-bottom: 20px;
}

.simple-header h1 {
    color: #ff00ff;
    font-size: 2rem;
    margin-bottom: 10px;
    text-shadow: 0 0 10px rgba(255, 0, 255, 0.7);
}

.simple-header h2 {
    color: #ffccff;
    font-size: 1.5rem;
    margin-bottom: 15px;
    opacity: 0.9;
}

.back-link {
    color: #aaa;
    text-decoration: none;
    font-size: 14px;
    display: inline-block;
    margin-top: 10px;
}

.back-link:hover {
    color: #ff00ff;
    text-decoration: underline;
}

.youtube-fullscreen {
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 30px rgba(255, 0, 255, 0.3);
    margin: 20px 0;
}

.youtube-fullscreen iframe {
    display: block;
}

.simple-controls {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.control-btn {
    padding: 12px 25px;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    min-width: 120px;
}

.control-btn.favorite {
    background: linear-gradient(135deg, #ff3366, #ff0066);
    color: white;
}

.control-btn.favorite.active {
    background: linear-gradient(135deg, #ff0000, #cc0000);
    box-shadow: 0 0 20px rgba(255, 0, 0, 0.7);
}

.control-btn.back {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 0, 255, 0.5);
}

.control-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(255, 0, 255, 0.5);
}
</style>

<script type="module" src="../assets/js/main.js"></script>
<script type="module" src="../assets/js/data.js"></script>
<script type="module" src="../assets/js/ui.js"></script>
<script type="module" src="../assets/js/events.js"></script>

<?php include "../includes/footer.php"; ?>