<?php include "../includes/header.php"; ?>

<section class="reviews-section" style="background:url('../assets/images/image3.jpg') center/cover no-repeat;">
  <div class="reviews-overlay">

    <h2 class="neon-title">⭐ Reviews</h2>

    <!-- FORM -->
    <form class="reviews-form" id="reviewForm" novalidate>

      <!-- ANONYMOUS -->
      <label class="anon-check">
        <input type="checkbox" id="anonymous" name="anonymous" value="1">
        <span>Post as anonymous</span>
      </label>

      <!-- NAME -->
      <div id="nameField">
        <input 
          type="text"
          name="name"
          id="reviewName"
          placeholder="Your name"
          required
        >
      </div>
      <!-- RATING -->
      <select name="rating" required>
        <option value="">Rating</option>
        <option value="5">★★★★★</option>
        <option value="4">★★★★☆</option>
        <option value="3">★★★☆☆</option>
        <option value="2">★★☆☆☆</option>
        <option value="1">★☆☆☆☆</option>
      </select>

      <!-- COMMENT -->
      <textarea
        name="comment"
        placeholder="Your review"
        required
      ></textarea>

      <!-- BUTTON -->
      <button type="submit" class="btn neon-btn">
        Send Review
      </button>

    </form>

    <p id="reviewResult" class="result-text"></p>

    <!-- REVIEWS LIST -->
    <div id="reviewsList" class="reviews-list"></div>

  </div>
</section>

<script>
/* ===============================
   ANONYMOUS TOGGLE
================================ */
const anon = document.getElementById('anonymous');
const nameField = document.getElementById('nameField');
const nameInput = document.getElementById('reviewName');

anon.addEventListener('change', () => {
  if (anon.checked) {
    nameInput.value = 'Anonymous';
    nameInput.removeAttribute('required');

    nameField.style.maxHeight = '0';
    nameField.style.opacity = '0';
    nameField.style.pointerEvents = 'none';
  } else {
    nameInput.value = '';
    nameInput.setAttribute('required', 'required');

    nameField.style.maxHeight = '100px';
    nameField.style.opacity = '1';
    nameField.style.pointerEvents = 'auto';
  }
});
</script>

<script>
/* ===============================
   SUBMIT REVIEW
================================ */
const form = document.getElementById('reviewForm');
const result = document.getElementById('reviewResult');

form.addEventListener('submit', e => {
  e.preventDefault();

  fetch("../includes/review_handler.php", {
    method: "POST",
    body: new FormData(form)
  })
  .then(r => r.json())
  .then(d => {
    result.innerText = d.message;

    if (d.success) {
      form.reset();
      nameField.style.maxHeight = '100px';
      nameField.style.opacity = '1';
      nameField.style.pointerEvents = 'auto';
      nameInput.setAttribute('required', 'required');
      loadReviews();
    }
  })
  .catch(() => {
    result.innerText = "❌ Error sending review";
  });
});

/* ===============================
   LOAD REVIEWS
================================ */
function loadReviews() {
  fetch("../includes/review_handler.php")
    .then(r => r.json())
    .then(d => {
      if (d.html) {
        document.getElementById("reviewsList").innerHTML = d.html;
      }
    });
}

loadReviews();
</script>

<?php include "../includes/footer.php"; ?>
