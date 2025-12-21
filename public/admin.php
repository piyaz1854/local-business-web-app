<?php
include "../includes/header.php";
require "../includes/db.php";

// комнаты
$rooms = $pdo->query(
  "SELECT * FROM room_bookings ORDER BY created_at DESC"
)->fetchAll();

// столы
$tables = $pdo->query(
  "SELECT * FROM table_bookings ORDER BY created_at DESC"
)->fetchAll();
?>

<h2>🛋 Room Bookings</h2>

<table border="1" cellpadding="5">
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Phone</th>
  <th>Date</th>
  <th>Time</th>
  <th>Duration</th>
  <th>Room</th>
  <th>Guests</th>
</tr>

<?php foreach ($rooms as $r): ?>
<tr>
  <td><?= $r["id"] ?></td>
  <td><?= htmlspecialchars($r["client_name"]) ?></td>
  <td><?= $r["phone"] ?></td>
  <td><?= $r["booking_date"] ?></td>
  <td><?= $r["start_time"] ?></td>
  <td><?= $r["duration"] ?>h</td>
  <td><?= $r["room_type"] ?></td>
  <td><?= $r["guests"] ?></td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<h2>🍽 Table Bookings</h2>

<table border="1" cellpadding="5">
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Phone</th>
  <th>Date</th>
  <th>Time</th>
  <th>Guests</th>
  <th>Zone</th>
  <th>Smoking</th>
</tr>

<?php foreach ($tables as $t): ?>
<tr>
  <td><?= $t["id"] ?></td>
  <td><?= htmlspecialchars($t["client_name"]) ?></td>
  <td><?= $t["phone"] ?></td>
  <td><?= $t["booking_date"] ?></td>
  <td><?= $t["booking_time"] ?></td>
  <td><?= $t["guests"] ?></td>
  <td><?= $t["table_zone"] ?></td>
  <td><?= $t["smoking"] ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php include "../includes/footer.php"; ?>
