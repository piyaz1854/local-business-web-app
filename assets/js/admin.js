// admin.js – загрузка и управление бронированиями

document.addEventListener("DOMContentLoaded", function () {
  // Выход
  document.getElementById("logout-btn").addEventListener("click", function () {
    fetch("../includes/api/admin_logout.php").then(() => location.reload());
  });

  // Загрузка бронирований
  loadBookings();

  async function loadBookings() {
    try {
      const response = await fetch("../includes/api/get_bookings.php");
      const data = await response.json();

      renderRoomBookings(data.room_bookings);
      renderTableBookings(data.table_bookings);
    } catch (error) {
      console.error("Error loading bookings:", error);
    }
  }

  function renderRoomBookings(bookings) {
    const tbody = document.querySelector("#room-bookings-table tbody");
    tbody.innerHTML = "";

    bookings.forEach((booking) => {
      const row = document.createElement("tr");
      row.innerHTML = `
                <td>${booking.id}</td>
                <td>${booking.client_name}</td>
                <td>${booking.phone}</td>
                <td>${booking.booking_date}</td>
                <td>${booking.booking_time}</td>
                <td>${booking.room_type}</td>
                <td>${booking.theme || "-"}</td>
                <td><button class="delete-btn" data-type="room" data-id="${
                  booking.id
                }">Delete</button></td>
            `;
      tbody.appendChild(row);
    });

    // Обработчики удаления
    document
      .querySelectorAll('.delete-btn[data-type="room"]')
      .forEach((btn) => {
        btn.addEventListener("click", function () {
          const id = this.dataset.id;
          deleteBooking("room", id);
        });
      });
  }

  function renderTableBookings(bookings) {
    const tbody = document.querySelector("#table-bookings-table tbody");
    tbody.innerHTML = "";

    bookings.forEach((booking) => {
      const row = document.createElement("tr");
      row.innerHTML = `
                <td>${booking.id}</td>
                <td>${booking.client_name}</td>
                <td>${booking.phone}</td>
                <td>${booking.booking_date}</td>
                <td>${booking.guests}</td>
                <td>${booking.table_number}</td>
                <td>${booking.payment_method}</td>
                <td><button class="delete-btn" data-type="table" data-id="${booking.id}">Delete</button></td>
            `;
      tbody.appendChild(row);
    });

    document
      .querySelectorAll('.delete-btn[data-type="table"]')
      .forEach((btn) => {
        btn.addEventListener("click", function () {
          const id = this.dataset.id;
          deleteBooking("table", id);
        });
      });
  }

  async function deleteBooking(type, id) {
    if (!confirm("Delete this booking?")) return;

    try {
      const response = await fetch(
        `/includes/api/delete_booking.php?type=${type}&id=${id}`
      );
      const result = await response.json();

      if (result.success) {
        alert("Booking deleted");
        loadBookings();
      }
    } catch (error) {
      console.error("Error deleting booking:", error);
    }
  }
});
