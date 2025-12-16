<?php
include '../includes/header.php';
include '../includes/session.php';

// Если не админ, показываем форму входа
if (!isAdminLoggedIn()) {
    ?>
    <section class="admin-login">
        <h2>Admin Login</h2>
        <form id="admin-login-form">
            <label for="admin-password">Password:</label>
            <input type="password" id="admin-password" required>
            <button type="submit">Login</button>
            <p id="login-message"></p>
        </form>
    </section>

    <script>
        document.getElementById('admin-login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const password = document.getElementById('admin-password').value;
            
            const response = await fetch('../includes/api/admin_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ password: password })
            });
            
            const result = await response.json();
            if (result.success) {
                location.reload();
            } else {
                document.getElementById('login-message').textContent = 'Wrong password!';
            }
        });
    </script>
    <?php
    include '../includes/footer.php';
    exit;
}
?>

<!-- Если админ вошел -->
<h2>📊 Admin Panel</h2>

<!-- Кнопка выхода -->
<button id="logout-btn" style="margin-bottom: 2rem;">Logout</button>

<!-- Таблицы бронирований -->
<div class="admin-tables">
    <div class="table-section">
        <h3>Room Bookings</h3>
        <table id="room-bookings-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Room Type</th>
                    <th>Theme</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Данные загружаются через JS -->
            </tbody>
        </table>
    </div>

    <div class="table-section">
        <h3>Table Bookings</h3>
        <table id="table-bookings-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Guests</th>
                    <th>Table #</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Данные загружаются через JS -->
            </tbody>
        </table>
    </div>
</div>

<script src="../assets/js/admin.js"></script>

<?php include '../includes/footer.php'; ?>