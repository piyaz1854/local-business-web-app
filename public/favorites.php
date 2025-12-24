<?php include "../includes/header.php"; ?>

<section class="songs-page">
  <h2 class="neon-title">❤️ My Favorite Songs</h2>
  
  <div id="favoritesContainer" class="songs-grid">
  </div>
  
  <div id="noFavorites" class="no-songs" style="display: none;">
    <p>You haven't added any songs to favorites yet.</p>
    <a href="songs.php" class="btn primary">Browse Songs</a>
  </div>
    <button onclick="window.history.back()" class="control-btn back">← Back to Songs
</section>

<script type="module" src="../assets/js/main.js"></script>
<script type="module" src="../assets/js/data.js"></script>
<script type="module" src="../assets/js/ui.js"></script>
<script type="module" src="../assets/js/events.js"></script>

<?php include "../includes/footer.php"; ?>