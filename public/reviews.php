<?php include "../includes/header.php"; ?>

<section class="reviews-section" style="background:url('../assets/images/image3.jpg') center/cover no-repeat;">
  <div class="reviews-overlay">

    <h2 class="neon-title">⭐ Reviews</h2>
    <form class="reviews-form" id="reviewForm" novalidate>

      <label class="anon-check">
        <input type="checkbox" id="anonymous" name="anonymous" value="1">
        <span>Post as anonymous</span>
      </label>

      <div id="nameField">
        <input 
          type="text"
          name="name"
          id="reviewName"
          placeholder="Your name"
          required
        >
      </div>
      <select name="rating" required>
        <option value="">Rating</option>
        <option value="5">★★★★★</option>
        <option value="4">★★★★☆</option>
        <option value="3">★★★☆☆</option>
        <option value="2">★★☆☆☆</option>
        <option value="1">★☆☆☆☆</option>
      </select>

      <textarea
        name="comment"
        placeholder="Your review"
        required
      ></textarea>

      <button type="submit" class="btn neon-btn">
        Send Review
      </button>

    </form>

    <p id="reviewResult" class="result-text"></p>

    <div id="reviewsList" class="reviews-list"></div>

  </div>
</section>

<script type="module" src="../assets/js/main.js"></script>
<script type="module" src="../assets/js/data.js"></script>
<script type="module" src="../assets/js/ui.js"></script>
<script type="module" src="../assets/js/events.js"></script>

<?php include "../includes/footer.php"; ?>