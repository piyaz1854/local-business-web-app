<?php 
include "../includes/header.php"; 
$selectedRoom = $_GET['room_type'] ?? '';
?>

<section class="booking-page">

  <h2 class="booking-title">🎤 Book a Room</h2>

  <form id="roomForm" class="booking-form">

    <div class="form-grid">
      <input type="text" name="client_name" placeholder="Your Name" required>
      <input type="text" name="phone" placeholder="Phone" required>
      <input type="email" name="email" placeholder="Email">

      <input type="date" name="booking_date" required>
      <input type="time" name="start_time" required>

      <select name="duration" required>
        <option value="">Duration</option>
        <option value="1">1 hour</option>
        <option value="2">2 hours</option>
        <option value="3">3 hours</option>
      </select>

      <select name="room_type" required>
        <option value="Standard" <?= $selectedRoom === 'Standard' ? 'selected' : '' ?>>Standard</option>
        <option value="VIP" <?= $selectedRoom === 'VIP' ? 'selected' : '' ?>>VIP</option>
        <option value="Premium" <?= $selectedRoom === 'Premium' ? 'selected' : '' ?>>Premium</option>
      </select>

      <select name="theme">
        <option value="Classic">Classic</option>
        <option value="Neon">Neon</option>
        <option value="Retro">Retro</option>
        <option value="K-Pop">K-Pop</option>
        <option value="Rock">Rock</option>
      </select>

      <input type="number" name="guests" placeholder="Guests" min="1" required>
    </div>

    <textarea name="comment" placeholder="Comment (optional)"></textarea>

    <button type="submit" class="btn primary full">Reserve Room</button>
  </form>

  <p id="roomResult" class="result-text"></p>

</section>

<script>
document.getElementById("roomForm").addEventListener("submit", e => {
  e.preventDefault();

  fetch("../includes/room_booking_handler.php", {
    method: "POST",
    body: new FormData(e.target)
  })
  .then(r => r.json())
  .then(d => {
    document.getElementById("roomResult").innerText = d.message;
    if (d.success) e.target.reset();
  })
  .catch(() => {
    document.getElementById("roomResult").innerText = "Booking failed";
  });
});
</script>

<?php include "../includes/footer.php"; ?>
