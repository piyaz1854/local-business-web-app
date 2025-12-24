<?php include "../includes/header.php"; ?>

<section class="rooms-page">
  <h2 class="neon-title">🎤 Choose Your Room</h2>

  <div class="room-filters">
    <select id="typeFilter">
      <option value="all">All types</option>
      <option value="Standard">Standard</option>
      <option value="VIP">VIP</option>
      <option value="Premium">Premium</option>
    </select>

    <select id="capacityFilter">
      <option value="0">Any capacity</option>
      <option value="6">6+ people</option>
      <option value="8">8+ people</option>
      <option value="10">10+ people</option>
      <option value="12">12+ people</option>
      <option value="15">15+ people</option>
    </select>
  </div>

  <div class="rooms-grid"></div>
</section>

<script src="../assets/js/booking_data.js"></script>
<script src="../assets/js/booking_ui.js"></script>
<script src="../assets/js/booking_events.js"></script>

<?php include "../includes/footer.php"; ?>
