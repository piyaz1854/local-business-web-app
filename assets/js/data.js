// data.js – AJAX-запросы и работа с данными

const API_BASE = "../includes/api/"; // Папка для PHP-обработчиков

// 1. GET-запрос для загрузки меню (Web Service v1)
async function loadMenu() {
  try {
    const response = await fetch(API_BASE + "get_menu.php");
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error loading menu:", error);
    return [];
  }
}

// 2. POST-запрос для бронирования стола (Web Service v2)
async function bookTable(bookingData) {
  try {
    const response = await fetch(API_BASE + "book_table.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(bookingData),
    });
    const result = await response.json();
    return result;
  } catch (error) {
    console.error("Error booking table:", error);
    return { success: false, message: "Network error" };
  }
}

// 3. POST-запрос для бронирования кабинки
async function bookRoom(roomData) {
  try {
    const response = await fetch(API_BASE + "book_room.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(roomData),
    });
    return await response.json();
  } catch (error) {
    console.error("Error booking room:", error);
    return { success: false };
  }
}

// 4. GET-запрос для загрузки забронированных столов (для админки)
async function loadBookings() {
  try {
    const response = await fetch(API_BASE + "get_bookings.php");
    return await response.json();
  } catch (error) {
    console.error("Error loading bookings:", error);
    return [];
  }
}

// Пример использования в других файлах:
// В events.js можно заменить alert на реальный AJAX-вызов:
/*
document.getElementById('room-booking-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = { ... };
    const result = await bookRoom(formData);
    if (result.success) {
        alert('Room booked successfully!');
    } else {
        alert('Error: ' + result.message);
    }
});
*/

export { loadMenu, bookTable, bookRoom, loadBookings };
