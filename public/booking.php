<?php include '../includes/header.php'; ?>

<h2>🎤 Book a Room or Table</h2>

<!-- Форма бронирования кабинки -->
<section class="booking-section">
    <h3>1. Book a Private Karaoke Room</h3>
    <form id="room-booking-form">
        <label for="room-client-name">Your Name *</label>
        <input type="text" id="room-client-name" required>

        <label for="room-phone">Phone Number *</label>
        <input type="tel" id="room-phone" required>

        <label for="room-date">Date *</label>
        <input type="date" id="room-date" required>

        <label for="room-time">Time *</label>
        <input type="time" id="room-time" required>

        <label for="room-type">Room Type *</label>
        <select id="room-type" required>
            <option value="">-- Select --</option>
            <option value="small">Small (up to 6 people)</option>
            <option value="medium">Medium (up to 10 people)</option>
            <option value="large">Large (up to 12 people)</option>
        </select>

        <label for="theme">Party Theme (optional)</label>
        <textarea id="theme" placeholder="e.g., Birthday, Anniversary..."></textarea>

        <button type="submit">Book Room</button>
        <p id="room-message"></p>
    </form>
</section>

<!-- Бронирование столов в общем зале -->
<section class="booking-section">
    <h3>2. Book a Table in Main Hall</h3>
    <p>Select an available table (gray tables are booked):</p>

    <div class="hall-layout">
        <!-- Сцена -->
        <div class="stage">STAGE</div>

        <!-- Столы -->
        <div class="tables-grid" id="tables-grid">
            <!-- Таблицы будут сгенерированы через JavaScript -->
        </div>
    </div>

    <!-- Форма подтверждения брони стола -->
    <form id="table-booking-form" style="display:none;">
        <h4>Confirm Table Booking</h4>
        <p>Table #<span id="selected-table">-</span></p>

        <label for="table-client-name">Your Name *</label>
        <input type="text" id="table-client-name" required>

        <label for="table-phone">Phone Number *</label>
        <input type="tel" id="table-phone" required>

        <label for="table-date">Date *</label>
        <input type="date" id="table-date" required>

        <label for="guests">Number of Guests (max 5) *</label>
        <input type="number" id="guests" min="1" max="5" required>

        <label for="payment">Payment Method *</label>
        <select id="payment" required>
            <option value="cash">Cash</option>
            <option value="card">Card</option>
            <option value="online">Online</option>
        </select>

        <button type="submit">Confirm Booking</button>
        <button type="button" id="cancel-booking">Cancel</button>
        <p id="table-message"></p>
    </form>
</section>

<script src="../assets/js/booking.js"></script>

<?php include '../includes/footer.php'; ?>