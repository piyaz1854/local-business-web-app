<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Booking - Karaoke</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
  <header>
    <div class="container">
      <h1>Booking</h1>
      <p>Select a room and book a slot.</p>
    </div>
  </header>

  <nav>
    <div class="container">
      <a href="index.html">Home</a>
      <a href="about.html">About</a>
      <a href="catalog.php">Booking</a>
    </div>
  </nav>

  <main class="container">
    <section class="card">
      <h2>Rooms (will be dynamic)</h2>
      <div id="roomsContainer">Rooms will appear here…</div>
    </section>

    <section class="card">
      <h2>Booking form (later)</h2>
      <p>We'll add the form + fetch submission in the next step.</p>
    </section>
  </main>

  <footer>
    <div class="container">
      <small>© 2025 Karaoke Platform</small>
    </div>
  </footer>
  <script type="module">
  import { initPage } from "../assets/js/events.js";
  initPage();
</script>
</body>
</html>
