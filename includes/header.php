<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KARAFLOW Karaoke</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../assets/css/style.css?v=123">
</head>
<body>

<header class="main-header">
  <div class="logo">
    🎤 <span>KARAFLOW</span>
  </div>

  <nav class="nav-links">
    <a href="index.php">Home</a>
    <a href="songs.php">Songs</a>
    <a href="booking.php">Booking</a>
    <a href="reviews.php">Reviews</a>
    <a href="about.php">About</a>
    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
        <a href="../admin/index.php" style="color: #ff00ff;">Admin</a>
    <?php else: ?>
        <a href="../admin/login.php">Admin</a>
    <?php endif; ?>
</nav>
</header>

<main>
