<?php include "../includes/header.php"; ?>

<h2>🎤 Book a Room</h2>

<form id="roomForm">
  <input type="text" name="client_name" placeholder="Name" required>
  <input type="text" name="phone" placeholder="Phone" required>
  <input type="email" name="email" placeholder="Email">

  <input type="date" name="booking_date" required>
  <input type="time" name="start_time" required>

  <select name="duration" required>
    <option value="">Select duration</option>
    <option value="1">1 hour</option>
    <option value="2">2 hours</option>
    <option value="3">3 hours</option>
  </select>

  <select name="room_type" required>
    <option value="Standard">Standard</option>
    <option value="VIP">VIP</option>
    <option value="Premium">Premium</option>
  </select>

  <select name="theme">
    <option value="Classic">Classic</option>
    <option value="Neon">Neon</option>
    <option value="Retro">Retro</option>
    <option value="K-Pop">K-Pop</option>
    <option value="Rock">Rock</option>
  </select>

  <input type="number" name="guests" placeholder="Guests" min="1" required>
  <textarea name="comment" placeholder="Comment"></textarea>

  <button type="submit">Book</button>
</form>

<p id="roomResult"></p>

<script>
document.getElementById("roomForm").addEventListener("submit", e => {
  e.preventDefault();

  fetch("../includes/room_booking_handler.php", {
    method: "POST",
    body: new FormData(e.target)
  })
  .then(r => {
    if (!r.ok) throw new Error("HTTP error");
    return r.json();
  })
  .then(d => {
    document.getElementById("roomResult").innerText = d.message;
    if (d.success) e.target.reset();
  })
  .catch(err => {
    document.getElementById("roomResult").innerText = "Booking failed";
    console.error(err);
  });
});
</script>

<?php include "../includes/footer.php"; ?>
