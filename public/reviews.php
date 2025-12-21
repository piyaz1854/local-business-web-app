<?php include "../includes/header.php"; ?>

<h2>⭐ Reviews</h2>

<form id="reviewForm">
  <input type="text" name="name" placeholder="Name" required>
  <select name="rating">
    <option value="5">★★★★★</option>
    <option value="4">★★★★</option>
    <option value="3">★★★</option>
  </select>
  <textarea name="comment" placeholder="Comment"></textarea>
  <button>Send</button>
</form>

<p id="reviewResult"></p>

<script>
document.getElementById("reviewForm").addEventListener("submit", e => {
  e.preventDefault();

  fetch("../includes/review_handler.php", {
    method: "POST",
    body: new FormData(e.target)
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById("reviewResult").innerText = data.message;
  });
});
</script>

<?php include "../includes/footer.php"; ?>
