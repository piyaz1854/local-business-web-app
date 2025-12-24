export const notifications = {
  show: (message, type = "info", duration = 3000) => {
    const existing = document.querySelector(".notification");
    if (existing) existing.remove();

    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
      <span class="notification-icon">${
        type === "success"
          ? "✅"
          : type === "error"
          ? "❌"
          : type === "warning"
          ? "⚠️"
          : "ℹ️"
      }</span>
      <span class="notification-text">${message}</span>
    `;

    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      background: ${
        type === "success"
          ? "rgba(0, 255, 0, 0.9)"
          : type === "error"
          ? "rgba(255, 0, 0, 0.9)"
          : type === "warning"
          ? "rgba(255, 165, 0, 0.9)"
          : "rgba(0, 150, 255, 0.9)"
      };
      color: white;
      padding: 15px 25px;
      border-radius: 10px;
      z-index: 9999;
      animation: slideIn 0.3s ease;
      display: flex;
      align-items: center;
      gap: 10px;
      max-width: 400px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    `;

    document.body.appendChild(notification);

    if (!document.querySelector("#notification-styles")) {
      const style = document.createElement("style");
      style.id = "notification-styles";
      style.textContent = `
        @keyframes slideIn {
          from { transform: translateX(100%); opacity: 0; }
          to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
          from { transform: translateX(0); opacity: 1; }
          to { transform: translateX(100%); opacity: 0; }
        }
      `;
      document.head.appendChild(style);
    }

    setTimeout(() => {
      notification.style.animation = "slideOut 0.3s ease";
      setTimeout(() => notification.remove(), 300);
    }, duration);
  },
};

export const elements = {
  createSongCard: (song) => {
    const card = document.createElement("div");
    card.className = "song-card";
    card.innerHTML = `
      <div class="song-card-header">
        <div class="song-info">
          <div class="song-title">${song.title}</div>
          <div class="song-artist">${song.artist}</div>
        </div>
        <button class="favorite-btn" data-song-id="${song.id}">
          🤍
        </button>
      </div>
      
      <div class="song-meta">
        <span>🎵 ${song.genre}</span> • 
        <span>🌐 ${song.language}</span> • 
        <span>📅 ${song.year}</span><br>
        <span>⏱️ ${song.duration}</span>
      </div>
      
      <a href="karaoke.php?song_id=${song.id}" class="play-button-link">
        <div class="play-button">
          ▶️ Sing Now
        </div>
      </a>
    `;
    return card;
  },

  createFavoriteCard: (song) => {
    const card = document.createElement("div");
    card.className = "song-card";
    card.innerHTML = `
      <div class="song-card-header">
        <div class="song-info">
          <div class="song-title">${song.title}</div>
          <div class="song-artist">${song.artist}</div>
        </div>
        <button class="favorite-btn active" data-song-id="${song.id}">
          ❤️
        </button>
      </div>
      
      <div class="song-meta">
        <span>🎵 ${song.genre}</span> 
        <span>🌐 ${song.language}</span>  
        <span>📅 ${song.year}</span><br>
        <span>⏱️ ${song.duration}</span>
      </div>
      
      <a href="karaoke.php?song_id=${song.id}" class="play-button-link">
        <div class="play-button">
          ▶️ Sing Now
        </div>
      </a>
    `;
    return card;
  },

  createSearchSuggestion: (song, onClick) => {
    const div = document.createElement("div");
    div.className = "suggestion-item";
    div.innerHTML = `
      <strong>${song.title}</strong><br>
      <small>${song.artist} • ${song.genre}</small>
    `;
    div.addEventListener("click", onClick);
    return div;
  },

  createNoDataMessage: (message, buttonText = null, buttonLink = null) => {
    const container = document.createElement("div");
    container.className = "no-songs";
    container.innerHTML = `
      <p>${message}</p>
      ${
        buttonText
          ? `<a href="${buttonLink}" class="btn primary">${buttonText}</a>`
          : ""
      }
    `;
    return container;
  },

  createStatsElement: (showing, total) => {
    const stats = document.createElement("div");
    stats.className = "song-stats";
    stats.innerHTML = `
      Showing <strong>${showing}</strong> of <strong>${total}</strong> songs
      ${showing < total ? `(${total - showing} hidden by filters)` : ""}
    `;
    return stats;
  },

  createStatsPanel: () => {
    const panel = document.createElement("div");
    panel.className = "stats-panel";
    panel.innerHTML = `
      <h3>📊 Быстрая статистика</h3>
      <div class="stat-item">
        <span>Всего песен:</span>
        <span class="stat-value" id="totalSongs">0</span>
      </div>
      <div class="stat-item">
        <span>Всего отзывов:</span>
        <span class="stat-value" id="totalReviews">0</span>
      </div>
      <div class="stat-item">
        <span>Сегодня:</span>
        <span class="stat-value" id="todayDate">${new Date().toLocaleDateString(
          "ru-RU"
        )}</span>
      </div>
      <button class="close-stats">× Закрыть</button>
    `;
    return panel;
  },
};

export const styles = {
  addHoverEffects: (selector) => {
    const elements = document.querySelectorAll(selector);
    elements.forEach((el) => {
      el.addEventListener("mouseenter", function () {
        this.style.transform = "translateY(-5px)";
        this.style.boxShadow = "0 10px 25px rgba(255, 0, 255, 0.3)";
      });

      el.addEventListener("mouseleave", function () {
        this.style.transform = "translateY(0)";
        this.style.boxShadow = "";
      });
    });
  },

  highlightTodayDates: () => {
    const today = new Date().toISOString().split("T")[0];
    document.querySelectorAll(".booking-date").forEach((dateElement) => {
      if (dateElement.textContent.includes(today)) {
        dateElement.style.color = "#ff9900";
        dateElement.style.fontWeight = "bold";
        dateElement.innerHTML = "🔥 " + dateElement.innerHTML;
      }
    });
  },

  addCopyIdButtons: () => {
    const ids = document.querySelectorAll(".review-id, .booking-id");
    ids.forEach((idElement) => {
      const id = idElement.textContent.replace("ID: ", "");
      idElement.style.cursor = "pointer";
      idElement.title = "Кликните чтобы скопировать ID";

      idElement.addEventListener("click", async function () {
        try {
          await navigator.clipboard.writeText(id);
          notifications.show(`ID ${id} скопирован!`, "success");
        } catch (err) {
          console.error("Ошибка копирования:", err);
        }
      });
    });
  },
};

export const ui = {
  displaySongs: (songs, containerId) => {
    const container = document.getElementById(containerId);
    if (!container) return;

    if (songs.length === 0) {
      container.innerHTML = "";
      container.appendChild(
        elements.createNoDataMessage(
          "🎵 No songs found. Try different filters!"
        )
      );
      return;
    }

    container.innerHTML = "";
    songs.forEach((song) => {
      container.appendChild(elements.createSongCard(song));
    });
  },

  displayFavorites: (songs, containerId) => {
    const container = document.getElementById(containerId);
    const noFavorites = document.getElementById("noFavorites");

    if (songs.length === 0) {
      container.innerHTML = "";
      container.style.display = "none";
      if (noFavorites) noFavorites.style.display = "block";
      return;
    }

    container.innerHTML = "";
    songs.forEach((song) => {
      container.appendChild(elements.createFavoriteCard(song));
    });

    container.style.display = "grid";
    if (noFavorites) noFavorites.style.display = "none";
  },

  updateStats: (showing, total, containerId) => {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = "";
    container.appendChild(elements.createStatsElement(showing, total));
  },
};
