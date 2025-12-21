<?php include "../includes/header.php"; ?>

<section class="hero">
  <div class="hero-content">
    <h1>KARAFLOW</h1>
    <p class="tagline">Feel the music. Sing your soul.</p>

    <div class="hero-buttons">
      <a href="booking_room.php" class="btn primary">🎤 Book a Room</a>
      <a href="songs.php" class="btn secondary">🎶 Songs</a>
    </div>
  </div>
</section>

<section class="why">
  <h2>Why KARAFLOW?</h2>
  <div class="features">
    <div class="feature">🎧 Studio-quality sound</div>
    <div class="feature">🛋️ Private rooms</div>
    <div class="feature">🌌 Neon atmosphere</div>
  </div>
</section>

<section class="rooms">
  <h2>Choose Your Room</h2>

  <div class="room-cards">
    <div class="card" style="background-image:url('../assets/images/image6.png')">
      <h3>Standard</h3>
    </div>
    <div class="card" style="background-image:url('../assets/images/image7.png')">
      <h3>VIP</h3>
    </div>
    <div class="card" style="background-image:url('../assets/images/image8.png')">
      <h3>Premium</h3>
    </div>
  </div>


  <a href="booking_room.php" class="btn primary center">Reserve Now</a>
</section>

<section class="songs-preview">
  <h2>Popular Songs</h2>
  <div id="songs"></div>
</section>

<script type="module" src="../assets/js/events.js?v=2"></script>


<?php include "../includes/footer.php"; ?>
