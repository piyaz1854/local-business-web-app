<?php include "../includes/header.php"; ?>

<section class="songs-page">
  <h2 class="neon-title">🎼 Song Catalog</h2>
  
  <div class="search-container">
    <input 
      type="text" 
      id="songSearch" 
      placeholder="🔍 Search songs by title or artist..." 
      class="search-input"
    >
    <button id="searchButton" class="search-btn" title="Search">🔍</button>
    <div id="searchSuggestions" class="suggestions"></div>
  </div>

  <div class="filters">
    <select id="genreFilter" class="filter-select">
      <option value="all">All Genres</option>
      <option value="Pop">Pop</option>
      <option value="Rock">Rock</option>
      <option value="Rap">Rap</option>
      <option value="K-Pop">K-Pop</option>
      <option value="R&B">R&B</option>
    </select>

    <select id="languageFilter" class="filter-select">
      <option value="all">All Languages</option>
      <option value="English">English</option>
      <option value="Russian">Russian</option>
      <option value="Kazakh">Kazakh</option>
      <option value="Korean">Korean</option>
    </select>

    <select id="sortFilter" class="filter-select">
      <option value="title_asc">Title A-Z</option>
      <option value="title_desc">Title Z-A</option>
      <option value="artist_asc">Artist A-Z</option>
      <option value="year_desc">Newest First</option>
      <option value="year_asc">Oldest First</option>
    </select>

    <button id="resetFilters" class="btn secondary">Reset</button>
    <a href="favorites.php" class="btn secondary">❤️ My Favorites</a>
  </div>

  <div id="songsContainer" class="songs-grid">
  </div>

  <div id="songStats" class="song-stats"></div>
</section>

<script type="module" src="../assets/js/main.js"></script>
<script type="module" src="../assets/js/data.js"></script>
<script type="module" src="../assets/js/ui.js"></script>
<script type="module" src="../assets/js/events.js"></script>

<?php include "../includes/footer.php"; ?>