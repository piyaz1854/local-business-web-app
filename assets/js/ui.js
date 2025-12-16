// assets/js/ui.js
import { rooms } from "./data.js";

export function qs(sel) {
  return document.querySelector(sel);
}

export function clear(el) {
  el.innerHTML = "";
}

function roomCard(room, isActive) {
  const card = document.createElement("div");
  card.className = "card";
  card.dataset.roomId = String(room.id);

  // 1) создаём DOM элементы динамически (минимум 5 – мы создадим больше)
  const title = document.createElement("h3");
  title.textContent = `${room.name} ${isActive ? "⭐" : ""}`;

  const info = document.createElement("p");
  info.textContent = `Capacity: ${room.capacity} people • Price: ${room.pricePerHour} KZT/hour`;

  const btn = document.createElement("button");
  btn.type = "button";
  btn.className = "select-room-btn";
  btn.textContent = "Select this room";
  btn.dataset.roomId = String(room.id);

  card.append(title, info, btn);
  return card;
}

/**
 * Простая “листалка” (carousel-like):
 * отображаем 1 кабинку за раз + кнопки prev/next
 */
export function renderRoomSlider(containerId = "#roomsContainer") {
  const container = qs(containerId);
  if (!container) return;

  clear(container);

  const wrap = document.createElement("div");
  wrap.id = "roomSlider";

  const header = document.createElement("div");
  header.className = "card";

  const prev = document.createElement("button");
  prev.type = "button";
  prev.id = "prevRoomBtn";
  prev.textContent = "◀ Prev";

  const next = document.createElement("button");
  next.type = "button";
  next.id = "nextRoomBtn";
  next.textContent = "Next ▶";

  const counter = document.createElement("span");
  counter.id = "roomCounter";
  counter.style.marginLeft = "12px";

  header.append(prev, next, counter);

  const stage = document.createElement("div");
  stage.id = "roomStage";

  wrap.append(header, stage);
  container.append(wrap);

  // стартовый рендер
  updateSlider(0);
}

export function updateSlider(index) {
  const stage = qs("#roomStage");
  const counter = qs("#roomCounter");
  if (!stage || !counter) return;

  // защита индекса
  const i = ((index % rooms.length) + rooms.length) % rooms.length;

  stage.innerHTML = "";
  stage.append(roomCard(rooms[i], true));
  counter.textContent = `${i + 1} / ${rooms.length}`;

  // сохраним текущий индекс в data-атрибут
  stage.dataset.index = String(i);
}

export function highlightSelectedRoom(roomId) {
  // просто визуальный эффект: меняем стиль контейнера
  const stage = qs("#roomStage");
  if (!stage) return;
  stage.style.border = "2px solid #000";
  stage.title = `Selected room id: ${roomId}`;
}
