<?php include "../includes/header.php"; ?>

<h2>🍽️ Table Booking</h2>

<form id="tableForm">
  <input type="text" name="client_name" placeholder="Name" required>
  <input type="text" name="phone" placeholder="Phone" required>

  <input type="date" name="booking_date" required>
  <input type="time" name="booking_time" required>

  <input type="number" name="guests" placeholder="Guests" min="1" required>

  <select name="table_zone" required>
    <option value="">Select zone</option>
    <option value="Main Hall">Main Hall</option>
    <option value="Near Stage">Near Stage</option>
    <option value="VIP Zone">VIP Zone</option>
    <option value="Balcony">Balcony</option>
  </select>

  <select name="smoking">
    <option value="No">No smoking</option>
    <option value="Yes">Smoking</option>
  </select>

  <textarea name="comment" placeholder="Comment"></textarea>

  <button type="submit">Reserve Table</button>
</form>

<p id="tableResult"></p>

<script>
document.getElementById("tableForm").addEventListener("submit", e => {
  e.preventDefault();

  fetch("../includes/table_booking_handler.php", {
    method: "POST",
    body: new FormData(e.target)
  })
  .then(r => r.json())
  .then(d => {
    document.getElementById("tableResult").innerText = d.message;
  })
  .catch(() => {
    document.getElementById("tableResult").innerText = "❌ Error occurred";
  });
});
</script>

<?php include "../includes/footer.php"; ?>
