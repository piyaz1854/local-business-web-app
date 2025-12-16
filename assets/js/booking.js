// booking.js – логика выбора столов и бронирования

document.addEventListener("DOMContentLoaded", function () {
  const tablesGrid = document.getElementById("tables-grid");
  const tableBookingForm = document.getElementById("table-booking-form");
  const selectedTableSpan = document.getElementById("selected-table");
  const cancelBtn = document.getElementById("cancel-booking");
  let selectedTableNumber = null;

  // Данные: 10 столов, некоторые забронированы
  const tables = [
    { number: 1, booked: false },
    { number: 2, booked: true },
    { number: 3, booked: false },
    { number: 4, booked: false },
    { number: 5, booked: true },
    { number: 6, booked: false },
    { number: 7, booked: false },
    { number: 8, booked: true },
    { number: 9, booked: false },
    { number: 10, booked: false },
  ];

  // Рендерим столы
  function renderTables() {
    tablesGrid.innerHTML = "";
    tables.forEach((table) => {
      const tableDiv = document.createElement("div");
      tableDiv.className = `table ${table.booked ? "booked" : "available"}`;
      tableDiv.textContent = `Table ${table.number}`;
      tableDiv.dataset.number = table.number;

      if (!table.booked) {
        tableDiv.addEventListener("click", () => selectTable(table.number));
      }

      tablesGrid.appendChild(tableDiv);
    });
  }

  // Выбор стола
  function selectTable(number) {
    selectedTableNumber = number;
    selectedTableSpan.textContent = number;
    tableBookingForm.style.display = "block";
    tableBookingForm.scrollIntoView({ behavior: "smooth" });
  }

  // Отмена выбора
  cancelBtn.addEventListener("click", function () {
    tableBookingForm.style.display = "none";
    selectedTableNumber = null;
  });

  // Отправка формы брони стола
  document
    .getElementById("table-booking-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const bookingData = {
        table: selectedTableNumber,
        name: document.getElementById("table-client-name").value,
        phone: document.getElementById("table-phone").value,
        date: document.getElementById("table-date").value,
        guests: document.getElementById("guests").value,
        payment: document.getElementById("payment").value,
      };

      // AJAX запрос будет в data.js
      console.log("Table booking data:", bookingData);
      alert(`Table ${bookingData.table} booked for ${bookingData.name}!`);
      tableBookingForm.reset();
      tableBookingForm.style.display = "none";
      renderTables(); // Обновляем сетку
    });

  // Инициализация
  renderTables();
});
