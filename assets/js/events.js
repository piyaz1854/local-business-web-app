document.addEventListener("DOMContentLoaded", () => {

  console.log("events.js loaded");

  // ===== ROOMS PAGE =====
  const typeFilter = document.getElementById("typeFilter");
  const capacityFilter = document.getElementById("capacityFilter");

  if (typeFilter && capacityFilter) {
    renderRooms();

    const applyRoomFilter = () => {
      filterRoomsUI(
        typeFilter.value,
        parseInt(capacityFilter.value, 10)
      );
    };

    typeFilter.addEventListener("change", applyRoomFilter);
    capacityFilter.addEventListener("change", applyRoomFilter);
  }

  // ===== TABLE PAGE =====
  if (document.getElementById("zonesGrid")) {
    renderZones();
  }

  // ===== ZONE SELECT (delegation) =====
  document.addEventListener("click", e => {
    const btn = e.target.closest(".select-zone");
    if (!btn) return;

    const card = btn.closest(".room-card");
    const zone = card.dataset.zone;
    const container = card.querySelector(".tables-inside");

    if (container.innerHTML.trim()) {
      clearAllTables();
      return;
    }

    clearAllTables();
    card.classList.add("active-zone");
    renderTablesInside(card, zone);
  });

  // ===== TABLE SELECT =====
  document.addEventListener("click", e => {
    const table = e.target.closest(".table-mini");
    if (!table) return;

    const { name, zone, capacity } = table.dataset;

    window.location.href =
      `booking_table.php?table_name=${encodeURIComponent(name)}&zone=${encodeURIComponent(zone)}&capacity=${capacity}`;
  });

});
