<?php
include "../includes/header.php";

$tableName = $_GET['table_name'] ?? '';
$zone = $_GET['zone'] ?? '';
$capacity = (int)($_GET['capacity'] ?? 0);

if (!$tableName || !$zone || $capacity <= 0) {
  echo "<p style='color:red;text-align:center'>Invalid table selection</p>";
  include "../includes/footer.php";
  exit;
}
?>

<section class="booking-page">
  <h2 class="booking-title">🍽 Table Booking</h2>

  <form id="tableForm" class="booking-form">

    <input type="hidden" name="table_name" value="<?= htmlspecialchars($tableName) ?>">
    <input type="hidden" name="table_zone" value="<?= htmlspecialchars($zone) ?>">
    <input type="hidden" name="capacity" value="<?= $capacity ?>">

    <div class="form-grid">

      <input type="text" value="<?= htmlspecialchars($tableName) ?>" readonly>
      <input type="text" value="<?= htmlspecialchars($zone) ?>" readonly>
      <input type="text" value="Max <?= $capacity ?> people" readonly>

      <input type="text" name="client_name" placeholder="Your Name" required>
      <input type="text" name="phone" placeholder="Phone" required>
      <input type="email" name="email" placeholder="Email">

      <input type="date" name="booking_date" required>
      <input type="time" name="booking_time" required>

      <input
        type="number"
        id="guestCount"
        name="guests"
        min="1"
        max="<?= $capacity ?>"
        placeholder="Guests"
        required
      >

    </div>

    <p id="capacityWarning" class="warning-text"></p>

    <textarea name="comment" placeholder="Comment (optional)"></textarea>

    <button id="submitBtn" class="btn full">Reserve Table</button>
    <p id="tableResult" class="result-text"></p>

  </form>
</section>

<script>
const g = document.getElementById("guestCount");
const w = document.getElementById("capacityWarning");
const b = document.getElementById("submitBtn");
const max = <?= $capacity ?>;

g.addEventListener("input", () => {
  if (+g.value > max) {
    w.textContent = "⚠ Maximum allowed: " + max + " guests";
    b.disabled = true;
  } else {
    w.textContent = "";
    b.disabled = false;
  }
});
</script>

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
  });
});
</script>

<?php include "../includes/footer.php"; ?>
