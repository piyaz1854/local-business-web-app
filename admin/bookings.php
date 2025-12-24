<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include "../includes/db.php";

if (isset($_GET['delete_room'])) {
    $id = (int)$_GET['delete_room'];
    mysqli_query($conn, "DELETE FROM room_bookings WHERE id = $id");
    header('Location: bookings.php?deleted=1');
    exit;
}

if (isset($_GET['delete_table'])) {
    $id = (int)$_GET['delete_table'];
    mysqli_query($conn, "DELETE FROM table_bookings WHERE id = $id");
    header('Location: bookings.php?deleted=1');
    exit;
}

$rooms = mysqli_query($conn, "SELECT * FROM room_bookings ORDER BY booking_date DESC, start_time DESC");
$tables = mysqli_query($conn, "SELECT * FROM table_bookings ORDER BY booking_date DESC, booking_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">📋 Manage Bookings</h1>
            <a href="index.php" class="back-link">← Back to Admin Dashboard</a>
        </div>
        
        <?php if (isset($_GET['deleted'])): ?>
            <div class="message success">✅ Booking deleted successfully!</div>
        <?php endif; ?>
        
        <h2 class="section-title">
            <span>🎤</span> Room Bookings
            <span class="count-badge"><?= mysqli_num_rows($rooms) ?></span>
        </h2>
        
        <?php if (mysqli_num_rows($rooms) > 0): ?>
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th width="60"><span class="table-header-icon">#</span> ID</th>
                        <th><span class="table-header-icon">👤</span> Customer</th>
                        <th><span class="table-header-icon">📞</span> Contact</th>
                        <th><span class="table-header-icon">📅</span> Date / Time</th>
                        <th><span class="table-header-icon">🎤</span> Room Details</th>
                        <th width="100"><span class="table-header-icon">⚡</span> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($room = mysqli_fetch_assoc($rooms)): 
                        $isToday = date('Y-m-d') == $room['booking_date'];
                    ?>
                        <tr class="<?= $isToday ? 'today-row' : '' ?>">
                            <td><strong>#<?= $room['id'] ?></strong></td>
                            <td>
                                <div class="client-name"><?= htmlspecialchars($room['client_name']) ?></div>
                                <div class="room-badge">🎤 Room</div>
                            </td>
                            <td>
                                <div class="client-phone">📱 <?= htmlspecialchars($room['phone']) ?></div>
                                <?php if (!empty($room['email'])): ?>
                                    <div class="cell-info">📧 <?= htmlspecialchars($room['email']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="booking-date"><?= $room['booking_date'] ?></div>
                                <div class="booking-time">🕐 <?= $room['start_time'] ?> (<?= $room['duration'] ?>h)</div>
                                <div class="cell-info">
                                    Created: <?= date('d.m H:i', strtotime($room['created_at'])) ?>
                                </div>
                            </td>
                            <td>
                                <div class="booking-type"><?= htmlspecialchars($room['room_type']) ?></div>
                                <div class="cell-info">
                                    👥 <?= $room['guests'] ?> guests<br>
                                    <?php if ($room['theme'] && $room['theme'] !== 'Classic'): ?>
                                        🎨 <?= $room['theme'] ?><br>
                                    <?php endif; ?>
                                    <?php if (!empty($room['comment'])): ?>
                                        💬 <?= substr(htmlspecialchars($room['comment']), 0, 30) ?>
                                        <?= strlen($room['comment']) > 30 ? '...' : '' ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <a href="bookings.php?delete_room=<?= $room['id'] ?>" 
                                   class="delete-review-btn"
                                   onclick="return confirm('Delete room booking from <?= addslashes($room['client_name']) ?>?\nDate: <?= $room['booking_date'] ?>\nTime: <?= $room['start_time'] ?>')"
                                   title="Delete booking">
                                    🗑️ Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message">
                🎤 No room bookings yet
                <div style="margin-top: 15px; font-size: 14px; color: #666;">
                    Customers have not booked karaoke rooms yet
                </div>
            </div>
        <?php endif; ?>
        
        <h2 class="section-title">
            <span>🍽️</span> Table Bookings
            <span class="count-badge"><?= mysqli_num_rows($tables) ?></span>
        </h2>
        
        <?php if (mysqli_num_rows($tables) > 0): ?>
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th width="60"><span class="table-header-icon">#</span> ID</th>
                        <th><span class="table-header-icon">👤</span> Customer</th>
                        <th><span class="table-header-icon">📞</span> Contact</th>
                        <th><span class="table-header-icon">📅</span> Date / Time</th>
                        <th><span class="table-header-icon">🍽️</span> Table Details</th>
                        <th width="100"><span class="table-header-icon">⚡</span> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($table = mysqli_fetch_assoc($tables)): 
                        $isToday = date('Y-m-d') == $table['booking_date'];
                    ?>
                        <tr class="<?= $isToday ? 'today-row' : '' ?>">
                            <td><strong>#<?= $table['id'] ?></strong></td>
                            <td>
                                <div class="client-name"><?= htmlspecialchars($table['client_name']) ?></div>
                                <div class="table-badge">🍽️ Table</div>
                            </td>
                            <td>
                                <div class="client-phone">📱 <?= htmlspecialchars($table['phone']) ?></div>
                                <div class="cell-info">
                                    Created: <?= date('d.m H:i', strtotime($table['created_at'])) ?>
                                </div>
                            </td>
                            <td>
                                <div class="booking-date"><?= $table['booking_date'] ?></div>
                                <div class="booking-time">🕐 <?= $table['booking_time'] ?></div>
                            </td>
                            <td>
                                <div class="booking-type"><?= htmlspecialchars($table['table_zone']) ?></div>
                                <div class="cell-info">
                                    👥 <?= $table['guests'] ?> guests<br>
                                    🚭 <?= $table['smoking'] === 'Yes' ? 'Smoking area' : 'Non-smoking' ?><br>
                                    <?php if (!empty($table['comment'])): ?>
                                        💬 <?= substr(htmlspecialchars($table['comment']), 0, 30) ?>
                                        <?= strlen($table['comment']) > 30 ? '...' : '' ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <a href="bookings.php?delete_table=<?= $table['id'] ?>" 
                                   class="delete-review-btn"
                                   onclick="return confirm('Delete table booking from <?= addslashes($table['client_name']) ?>?\nDate: <?= $table['booking_date'] ?>\nTime: <?= $table['booking_time'] ?>')"
                                   title="Delete booking">
                                    🗑️ Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message">
                🍽️ No table bookings yet
                <div style="margin-top: 15px; font-size: 14px; color: #666;">
                    Customers have not booked restaurant tables yet
                </div>
            </div>
        <?php endif; ?>
        
        <div class="footer-nav">
            <div style="margin-top: 20px; color: #666; font-size: 12px;">
                Total bookings: <strong><?= mysqli_num_rows($rooms) + mysqli_num_rows($tables) ?></strong>
                (Rooms: <?= mysqli_num_rows($rooms) ?>, Tables: <?= mysqli_num_rows($tables) ?>)
            </div>
        </div>
    </div>

    <script type="module" src="../assets/js/main.js"></script>
    <script type="module" src="../assets/js/data.js"></script>
    <script type="module" src="../assets/js/ui.js"></script>
    <script type="module" src="../assets/js/events.js"></script>
</body>
</html>
