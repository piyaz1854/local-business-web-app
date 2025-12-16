// assets/js/events.js
import { updateSlider, renderRoomSlider, qs, highlightSelectedRoom } from "./ui.js";

export function initEvents() {
  // 1) click (обязательно)
  document.addEventListener("click", (e) => {
    const t = e.target;

    if (t && t.id === "prevRoomBtn") {
      const stage = qs("#roomStage");
      const cur = Number(stage?.dataset.index ?? 0);
      updateSlider(cur - 1);
    }

    if (t && t.id === "nextRoomBtn") {
      const stage = qs("#roomStage");
      const cur = Number(stage?.dataset.index ?? 0);
      updateSlider(cur + 1);
    }

    if (t && t.classList?.contains("select-room-btn")) {
      const roomId = t.dataset.roomId;
      localStorage.setItem("selectedRoomId", roomId);
      highlightSelectedRoom(roomId);
      alert(`Room selected: #${roomId}`);
    }
  });

  // 2) mouseover (обязательно)
  document.addEventListener("mouseover", (e) => {
    const t = e.target;
    if (t && t.classList?.contains("card")) {
      t.style.boxShadow = "0 6px 18px rgba(0,0,0,0.12)";
    }
  });

  // 3) mouseout (не обязательно, но полезно)
  document.addEventListener("mouseout", (e) => {
    const t = e.target;
    if (t && t.classList?.contains("card")) {
      t.style.boxShadow = "";
    }
  });

  // Здесь позже добавим submit (форма бронирования)
}

export function initPage() {
  renderRoomSlider("#roomsContainer");
  initEvents();
}
