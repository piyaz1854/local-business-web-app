<?php include '../includes/header.php'; ?>

<h2>🍽️ Menu & Pre-order</h2>
<p>Filter items by allergens or category. You can pre-order for your booking.</p>

<!-- Фильтры -->
<div class="filters">
    <label for="category-filter">Category:</label>
    <select id="category-filter">
        <option value="all">All</option>
        <option value="appetizer">Appetizers</option>
        <option value="main">Main Dishes</option>
        <option value="dessert">Desserts</option>
        <option value="drink">Drinks</option>
        <option value="combo">Combos</option>
    </select>

    <label for="allergen-filter">Allergens:</label>
    <select id="allergen-filter">
        <option value="all">No restriction</option>
        <option value="nuts">Nuts</option>
        <option value="dairy">Dairy</option>
        <option value="gluten">Gluten</option>
        <option value="seafood">Seafood</option>
    </select>

    <label for="sort-price">Sort by Price:</label>
    <select id="sort-price">
        <option value="asc">Low to High</option>
        <option value="desc">High to Low</option>
    </select>

    <button id="apply-filters">Apply</button>
    <button id="reset-filters">Reset</button>
</div>

<!-- Контейнер для блюд -->
<div class="menu-grid" id="menu-grid">
    <!-- Меню будет загружено через JavaScript -->
</div>

<!-- Форма предзаказа -->
<div class="preorder-form">
    <h3>📝 Pre-order Selected Items</h3>
    <ul id="preorder-list"></ul>
    <p>Total: $<span id="total-price">0</span></p>
    <button id="submit-preorder">Submit Pre-order</button>
    <p id="preorder-message"></p>
</div>

<script src="../assets/js/menu.js"></script>

<?php include '../includes/footer.php'; ?>