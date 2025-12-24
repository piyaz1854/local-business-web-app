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

  <div class="why-cards">
    <div class="why-card" style="background-image:url('../assets/images/image12.png')">
      <div class="why-overlay">
        <h3>Studio-quality sound</h3>
        <p>Professional audio systems for perfect vocals</p>
      </div>
    </div>

    <div class="why-card" style="background-image:url('../assets/images/image13.png')">
      <div class="why-overlay">
        <h3>Private rooms</h3>
        <p>Your own space — no strangers, only your vibe</p>
      </div>
    </div>

    <div class="why-card" style="background-image:url('../assets/images/image14.png')">
      <div class="why-overlay">
        <h3>Neon atmosphere</h3>
        <p>Lights, mood and energy of the night</p>
      </div>
    </div>
  </div>
</section>


<section class="rooms">
  <h2>Choose Your Room</h2>
   
  <div class="room-cards">

    <a href="booking_room.php?room_type=Standard"
       class="room-card standard"
       style="background-image:url('../assets/images/image6.png')">
      <div class="room-overlay"></div>
      <h3>Standard</h3>
      <p>Comfort • Best Value</p>
    </a>

    <a href="booking_room.php?room_type=VIP"
       class="room-card vip"
       style="background-image:url('../assets/images/image7.png')">
      <div class="room-overlay"></div>
      <h3>VIP</h3>
      <p>Private • Premium Sound</p>
    </a>

    <a href="booking_room.php?room_type=Premium"
       class="room-card premium"
       style="background-image:url('../assets/images/image8.png')">
      <div class="room-overlay"></div>
      <h3>Premium</h3>
      <p>Luxury • Ultimate Experience</p>
    </a>

  </div>

  <a href="booking_room.php" class="btn primary center">Reserve Now</a>
</section>

<section class="songs-preview">
  <h2>Popular Songs</h2>
  <div id="songs"></div>
</section>

<script type="module" src="../assets/js/main.js"></script>
<script type="module" src="../assets/js/data.js"></script>
<script type="module" src="../assets/js/ui.js"></script>
<script type="module" src="../assets/js/events.js"></script>

<?php include "../includes/footer.php"; ?>