// menu.js – фильтрация меню и предзаказ

document.addEventListener("DOMContentLoaded", function () {
  const menuGrid = document.getElementById("menu-grid");
  const preorderList = document.getElementById("preorder-list");
  const totalPriceSpan = document.getElementById("total-price");
  const applyBtn = document.getElementById("apply-filters");
  const resetBtn = document.getElementById("reset-filters");
  const submitBtn = document.getElementById("submit-preorder");

  let menuItems = [];
  let selectedItems = [];

  // Пример данных меню (в реальном проекте будут загружаться через AJAX)
  const sampleMenu = [
    {
      id: 1,
      name: "Spring Rolls",
      category: "appetizer",
      allergens: "none",
      price: 5.99,
    },
    {
      id: 2,
      name: "Chicken Satay",
      category: "appetizer",
      allergens: "nuts",
      price: 7.5,
    },
    {
      id: 3,
      name: "Beef Burger",
      category: "main",
      allergens: "gluten,dairy",
      price: 12.99,
    },
    {
      id: 4,
      name: "Grilled Salmon",
      category: "main",
      allergens: "seafood",
      price: 15.5,
    },
    {
      id: 5,
      name: "Chocolate Cake",
      category: "dessert",
      allergens: "dairy",
      price: 6.99,
    },
    {
      id: 6,
      name: "Fruit Salad",
      category: "dessert",
      allergens: "none",
      price: 4.5,
    },
    {
      id: 7,
      name: "Cocktail",
      category: "drink",
      allergens: "none",
      price: 8.0,
    },
    {
      id: 8,
      name: "Family Combo",
      category: "combo",
      allergens: "nuts,dairy",
      price: 25.99,
    },
  ];
  // В menu.js добавьте после строки с sampleMenu:

  // Пример использования map и reduce (для требования)
  const allPrices = sampleMenu.map((item) => item.price);
  const totalMenuPrice = allPrices.reduce((sum, price) => sum + price, 0);
  console.log("Total price of all menu items:", totalMenuPrice.toFixed(2));

  // Пример использования map для преобразования данных
  const menuSummary = sampleMenu.map((item) => ({
    name: item.name.toUpperCase(),
    category: item.category,
    priceWithTax: (item.price * 1.1).toFixed(2),
  }));
  console.log("Menu summary:", menuSummary);

  // Инициализация
  menuItems = [...sampleMenu];
  renderMenu(menuItems);

  // Рендер меню
  function renderMenu(items) {
    menuGrid.innerHTML = "";
    items.forEach((item) => {
      const card = document.createElement("div");
      card.className = "menu-card";
      card.innerHTML = `
                <h4>${item.name}</h4>
                <p><strong>Category:</strong> ${item.category}</p>
                <p><strong>Allergens:</strong> ${item.allergens || "none"}</p>
                <p><strong>Price:</strong> $${item.price}</p>
                <button class="add-to-order" data-id="${
                  item.id
                }">Add to Pre-order</button>
            `;
      menuGrid.appendChild(card);
    });

    // Добавляем обработчики кнопок
    document.querySelectorAll(".add-to-order").forEach((btn) => {
      btn.addEventListener("click", function () {
        const id = parseInt(this.dataset.id);
        addToPreorder(id);
      });
    });
  }

  // Добавить в предзаказ
  function addToPreorder(id) {
    const item = menuItems.find((i) => i.id === id);
    if (!item) return;

    // Проверяем, уже ли добавлен
    const existing = selectedItems.find((i) => i.id === id);
    if (existing) {
      existing.quantity = (existing.quantity || 1) + 1;
    } else {
      selectedItems.push({ ...item, quantity: 1 });
    }

    updatePreorderList();
  }

  // Обновить список предзаказа
  function updatePreorderList() {
    preorderList.innerHTML = "";
    let total = 0;

    selectedItems.forEach((item) => {
      const li = document.createElement("li");
      li.innerHTML = `
                ${item.name} x${item.quantity} – $${(
        item.price * item.quantity
      ).toFixed(2)}
                <button class="remove-item" data-id="${item.id}">Remove</button>
            `;
      preorderList.appendChild(li);
      total += item.price * item.quantity;
    });

    totalPriceSpan.textContent = total.toFixed(2);

    // Обработчики удаления
    document.querySelectorAll(".remove-item").forEach((btn) => {
      btn.addEventListener("click", function () {
        const id = parseInt(this.dataset.id);
        removeFromPreorder(id);
      });
    });
  }

  // Удалить из предзаказа
  function removeFromPreorder(id) {
    selectedItems = selectedItems.filter((item) => item.id !== id);
    updatePreorderList();
  }

  // Применение фильтров
  applyBtn.addEventListener("click", function () {
    const category = document.getElementById("category-filter").value;
    const allergen = document.getElementById("allergen-filter").value;
    const sort = document.getElementById("sort-price").value;

    let filtered = [...sampleMenu];

    // Фильтр по категории
    if (category !== "all") {
      filtered = filtered.filter((item) => item.category === category);
    }

    // Фильтр по аллергенам
    if (allergen !== "all") {
      filtered = filtered.filter((item) => !item.allergens.includes(allergen));
    }

    // Сортировка по цене
    filtered.sort((a, b) => {
      return sort === "asc" ? a.price - b.price : b.price - a.price;
    });

    renderMenu(filtered);
  });

  // Сброс фильтров
  resetBtn.addEventListener("click", function () {
    document.getElementById("category-filter").value = "all";
    document.getElementById("allergen-filter").value = "all";
    document.getElementById("sort-price").value = "asc";
    renderMenu(sampleMenu);
  });

  // Отправка предзаказа
  submitBtn.addEventListener("click", function () {
    if (selectedItems.length === 0) {
      alert("Please add items to pre-order.");
      return;
    }

    const preorderData = {
      items: selectedItems,
      total: totalPriceSpan.textContent,
      timestamp: new Date().toISOString(),
    };

    // AJAX запрос будет в data.js
    console.log("Pre-order data:", preorderData);
    alert(`Pre-order submitted! Total: $${preorderData.total}`);
    selectedItems = [];
    updatePreorderList();
  });
});
