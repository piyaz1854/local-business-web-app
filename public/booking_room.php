<?php 
include "../includes/header.php"; 

// ===============================
// GET DATA FROM URL (FROM choose-room.php)
// ===============================
$roomName = $_GET['room_name'] ?? '';
$roomType = $_GET['room_type'] ?? '';
$capacity = (int)($_GET['capacity'] ?? 0);

// ===============================
// VALIDATION
// ===============================
if ($roomName === '' || $roomType === '' || $capacity <= 0) {
  echo "<p style='color:red;text-align:center'>Invalid room selection.</p>";
  include "../includes/footer.php";
  exit;
}
?>

<section class="booking-page">

  <h2 class="booking-title">🎤 Book a Room</h2>

  <form id="roomForm" class="booking-form">

    <!-- ===============================
         DATA SENT TO SERVER
    =============================== -->
    <input type="hidden" name="room_type" value="<?= htmlspecialchars($roomType) ?>">

    <div class="form-grid">

      <!-- ===============================
           DISPLAY ONLY (NOT SENT)
      =============================== -->
      <input type="text" value="<?= htmlspecialchars($roomName) ?>" readonly>
      <input type="text" value="<?= htmlspecialchars($roomType) ?>" readonly>
      <input type="text" value="Max <?= $capacity ?> people" readonly>

      <!-- ===============================
           CLIENT INFO
      =============================== -->
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

      <!-- ===============================
           GUEST COUNT
      =============================== -->
      <input 
        type="number"
        id="guestCount"
        name="guests"
        placeholder="Guests"
        min="1"
        required
      >
    </div>

    <p id="capacityWarning" class="warning-text"></p>

    <textarea name="comment" placeholder="Comment (optional)"></textarea>

    <button type="submit" id="submitBtn" class="btn primary full">
      Reserve Room
    </button>
  </form>

  <p id="roomResult" class="result-text"></p>
</section>

<!-- ===============================
     CAPACITY CHECK (FRONTEND)
=============================== -->
<script>
const guestInput = document.getElementById("guestCount");
const warning = document.getElementById("capacityWarning");
const submitBtn = document.getElementById("submitBtn");
const maxCapacity = <?= $capacity ?>;

guestInput.addEventListener("input", () => {
  const guests = Number(guestInput.value);

  if (guests > maxCapacity) {
    warning.textContent =
      "⚠ Too many guests for this room. Maximum allowed is " + maxCapacity + ".";
    submitBtn.disabled = true;
    submitBtn.style.opacity = "0.5";
  } else {
    warning.textContent = "";
    submitBtn.disabled = false;
    submitBtn.style.opacity = "1";
  }
});
</script>

<!-- ===============================
     AJAX SUBMIT
=============================== -->
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
  .catch(err => {
    console.error(err);
    document.getElementById("roomResult").innerText =
      "❌ Server error. Check console.";
  });
});
</script>

<?php include "../includes/footer.php"; ?>
