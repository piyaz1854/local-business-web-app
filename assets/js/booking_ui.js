// ===== ROOMS UI =====
function renderRooms() {
  const grid = document.querySelector(".rooms-grid");
  if (!grid) return;

  grid.innerHTML = "";

  DATA.rooms.forEach(r => {
    const card = document.createElement("div");
    card.className = "room-card";
    card.dataset.type = r.type;
    card.dataset.capacity = r.capacity;

    card.innerHTML = `
      <img src="../assets/images/${r.image}">
      <div class="room-info">
        <h3>${r.name}</h3>
        <p class="room-type">${r.type} Room</p>
        <p class="room-capacity">Capacity: ${r.capacity} people</p>
        <a href="booking_room.php?room_name=${encodeURIComponent(r.name)}&room_type=${r.type}&capacity=${r.capacity}"
           class="neon-btn room-btn">Select Room</a>
      </div>
    `;

    grid.appendChild(card);
  });
}

function filterRoomsUI(typeValue, capacityValue) {
  document.querySelectorAll(".room-card").forEach(room => {
    const typeMatch =
      typeValue === "all" || room.dataset.type === typeValue;
    const capacityMatch =
      parseInt(room.dataset.capacity, 10) >= capacityValue;

    room.style.display =
      (typeMatch && capacityMatch) ? "" : "none";
  });
}

// ===== TABLES UI =====
function renderTablesInside(card, zone) {
  const container = card.querySelector(".tables-inside");
  if (!container) return;

  container.innerHTML = "";

  DATA.tables[zone].tables.forEach((table, i) => {
    const div = document.createElement("div");
    div.className = "table-mini";
    div.dataset.name = table.name;
    div.dataset.zone = zone;
    div.dataset.capacity = table.capacity;

    div.innerHTML = `
      <span>Table ${i + 1}</span>
      <small>${table.capacity} ppl</small>
    `;

    container.appendChild(div);
  });
}

function clearAllTables() {
  document.querySelectorAll(".tables-inside").forEach(c => c.innerHTML = "");
  document.querySelectorAll(".room-card").forEach(c => c.classList.remove("active-zone"));
}
// ===== ZONES UI =====
function renderZones() {
  const grid = document.getElementById("zonesGrid");
  if (!grid) return;

  grid.innerHTML = "";

  Object.entries(DATA.tables).forEach(([zone, data]) => {
    const card = document.createElement("div");
    card.className = "room-card";
    card.dataset.zone = zone;

    const capacities = data.tables.map(t => t.capacity);

    card.innerHTML = `
      <img src="../assets/images/${data.image}">
      <div class="room-info">
        <h3>${zone}</h3>
        <p class="room-type">${data.tables.length} tables</p>
        <p class="room-capacity">
          Capacity: ${Math.min(...capacities)}-${Math.max(...capacities)} people
        </p>
        <button class="neon-btn room-btn select-zone">Select</button>
        <div class="tables-inside"></div>
      </div>
    `;

    grid.appendChild(card);
  });
}
