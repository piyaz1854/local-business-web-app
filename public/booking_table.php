<?php include "../includes/header.php"; ?>

<section class="booking-page">

  <h1 class="booking-title">🍽 Table Booking</h1>
  <p class="booking-subtitle">Reserve a table and enjoy the night</p>

  <form id="tableForm" class="booking-form">

    <div class="form-grid">

      <input type="text" name="client_name" placeholder="Your Name" required>
      <input type="text" name="phone" placeholder="Phone" required>
      <input type="email" name="email" placeholder="Email (optional)">

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

    </div>

    <textarea name="comment" placeholder="Comment (optional)"></textarea>

    <button type="submit" class="btn full">Reserve Table</button>

    <p id="tableResult" class="result-text"></p>

  </form>

</section>

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
    if (d.success) e.target.reset();
  })
  .catch(() => {
    document.getElementById("tableResult").innerText = "❌ Error occurred";
  });
});
</script>

<?php include "../includes/footer.php"; ?>
