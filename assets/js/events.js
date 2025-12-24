import { songs, favorites, bookings, reviews, admin } from "./data.js";
import { notifications, ui, styles } from "./ui.js";

export const handlers = {
  toggleFavorite: async (songId, button = null) => {
    const isActive = button
      ? button.classList.contains("active")
      : document.getElementById("favoriteBtn")?.classList.contains("active") ||
        false;

    const action = isActive ? "remove" : "add";

    try {
      const data = await favorites.toggle(songId, action);
      if (data.success) {
        if (button) {
          button.classList.toggle("active");
          button.innerHTML = button.classList.contains("active") ? "❤️" : "🤍";
          button.title = button.classList.contains("active")
            ? "Remove from favorites"
            : "Add to favorites";
        }

        const karaokeBtn = document.getElementById("favoriteBtn");
        if (karaokeBtn) {
          karaokeBtn.classList.toggle("active");
          karaokeBtn.innerHTML = karaokeBtn.classList.contains("active")
            ? "❤️ Remove from Favorites"
            : "🤍 Add to Favorites";
          karaokeBtn.title = karaokeBtn.classList.contains("active")
            ? "Remove from favorites"
            : "Add to favorites";
        }

        notifications.show(
          data.message ||
            (isActive ? "Removed from favorites" : "Added to favorites"),
          "success"
        );

        return data;
      }
    } catch (error) {
      console.error("Error:", error);
      notifications.show("Error saving favorite", "error");
    }
  },

  setupSearch: (allSongs, onFilterChange) => {
    const searchInput = document.getElementById("songSearch");
    const suggestionsBox = document.getElementById("searchSuggestions");

    if (!searchInput) return;

    let searchTimeout;
    searchInput.addEventListener("input", function () {
      clearTimeout(searchTimeout);
      const query = this.value.trim();

      if (query.length === 0) {
        if (suggestionsBox) suggestionsBox.style.display = "none";
        onFilterChange();
        return;
      }

      searchTimeout = setTimeout(async () => {
        try {
          const data = await songs.search(query);
          if (data.success && suggestionsBox) {
            suggestionsBox.innerHTML = "";

            if (data.songs.length > 0) {
              data.songs.slice(0, 8).forEach((song) => {
                const suggestion = document.createElement("div");
                suggestion.className = "suggestion-item";
                suggestion.innerHTML = `
                  <strong>${song.title}</strong><br>
                  <small>${song.artist} • ${song.genre}</small>
                `;
                suggestion.addEventListener("click", () => {
                  searchInput.value = song.title;
                  suggestionsBox.style.display = "none";
                  onFilterChange();
                });
                suggestionsBox.appendChild(suggestion);
              });
              suggestionsBox.style.display = "block";
            } else {
              suggestionsBox.style.display = "none";
            }
          }
        } catch (error) {
          console.error("Search error:", error);
        }
      }, 300);
    });

    searchInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        onFilterChange();
        if (suggestionsBox) suggestionsBox.style.display = "none";
      }
    });

    document.addEventListener("click", function (e) {
      if (
        suggestionsBox &&
        searchInput &&
        !searchInput.contains(e.target) &&
        !suggestionsBox.contains(e.target)
      ) {
        suggestionsBox.style.display = "none";
      }
    });
  },

  setupFilters: (allSongs, onFilterChange) => {
    document
      .getElementById("genreFilter")
      ?.addEventListener("change", onFilterChange);
    document
      .getElementById("languageFilter")
      ?.addEventListener("change", onFilterChange);
    document
      .getElementById("sortFilter")
      ?.addEventListener("change", onFilterChange);

    document.getElementById("resetFilters")?.addEventListener("click", () => {
      document.getElementById("genreFilter").value = "all";
      document.getElementById("languageFilter").value = "all";
      document.getElementById("sortFilter").value = "title_asc";
      document.getElementById("songSearch").value = "";

      const suggestionsBox = document.getElementById("searchSuggestions");
      if (suggestionsBox) suggestionsBox.style.display = "none";

      onFilterChange();
    });
  },

  setupAnonymousToggle: () => {
    const anon = document.getElementById("anonymous");
    const nameField = document.getElementById("nameField");
    const nameInput = document.getElementById("reviewName");

    if (anon && nameField && nameInput) {
      anon.addEventListener("change", () => {
        if (anon.checked) {
          nameInput.value = "Anonymous";
          nameInput.removeAttribute("required");
          nameField.style.maxHeight = "0";
          nameField.style.opacity = "0";
          nameField.style.pointerEvents = "none";
        } else {
          nameInput.value = "";
          nameInput.setAttribute("required", "required");
          nameField.style.maxHeight = "100px";
          nameField.style.opacity = "1";
          nameField.style.pointerEvents = "auto";
        }
      });
    }
  },
};

export const forms = {
  roomBooking: (formId) => {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      try {
        const data = await bookings.room(formData);
        const result = document.getElementById("roomResult");
        if (result) {
          result.innerText = data.message;
          if (data.success) form.reset();
        }
      } catch (error) {
        console.error("Booking error:", error);
        const result = document.getElementById("roomResult");
        if (result) result.innerText = "Booking failed";
      }
    });
  },

  tableBooking: (formId) => {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      try {
        const data = await bookings.table(formData);
        const result = document.getElementById("tableResult");
        if (result) {
          result.innerText = data.message;
          if (data.success) form.reset();
        }
      } catch (error) {
        console.error("Table booking error:", error);
        const result = document.getElementById("tableResult");
        if (result) result.innerText = "❌ Error occurred";
      }
    });
  },

  reviews: (formId) => {
    const form = document.getElementById(formId);
    const result = document.getElementById("reviewResult");

    if (!form || !result) return;

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      try {
        const data = await reviews.submit(formData);
        result.innerText = data.message;

        if (data.success) {
          form.reset();
          const nameField = document.getElementById("nameField");
          const nameInput = document.getElementById("reviewName");

          if (nameField && nameInput) {
            nameField.style.maxHeight = "100px";
            nameField.style.opacity = "1";
            nameField.style.pointerEvents = "auto";
            nameInput.setAttribute("required", "required");
          }
        }
      } catch (error) {
        console.error("Review error:", error);
        result.innerText = "❌ Error sending review";
      }
    });
  },
};

export const adminHandlers = {
  updateDeleteHandlers: () => {
    document.querySelectorAll('a[onclick*="confirm"]').forEach((link) => {
      const onclick = link.getAttribute("onclick");
      link.removeAttribute("onclick");

      link.addEventListener("click", function (e) {
        if (
          !admin.confirmDelete("Are you sure you want to delete this record?")
        ) {
          e.preventDefault();
        }
      });
    });
  },

  showStats: () => {
    if (document.querySelector(".stats-panel")) {
      document.querySelector(".stats-panel").remove();
    } else {
      const panel = document.createElement("div");
      panel.className = "stats-panel";
      panel.innerHTML = `
        <h3>📊 Quick Stats</h3>
        <div class="stat-item">
          <span>Total songs:</span>
          <span class="stat-value" id="totalSongs">${
            document.querySelectorAll(".songs-table tbody tr").length
          }</span>
        </div>
        <div class="stat-item">
          <span>Total reviews:</span>
          <span class="stat-value" id="totalReviews">${
            document.querySelectorAll(".review-card").length
          }</span>
        </div>
        <div class="stat-item">
          <span>Today:</span>
          <span class="stat-value" id="todayDate">${new Date().toLocaleDateString(
            "en-US"
          )}</span>
        </div>
        <button class="close-stats">× Close</button>
      `;

      document.body.appendChild(panel);
      panel.querySelector(".close-stats").addEventListener("click", () => {
        panel.remove();
      });
    }
  },
};

export function setupSearchButton(onFilterChange) {
  const searchButton = document.getElementById("searchButton");
  if (searchButton) {
    searchButton.addEventListener("click", () => {
      if (onFilterChange && typeof onFilterChange === "function") {
        onFilterChange();
      } else {
        const event = new Event("change");
        document.getElementById("genreFilter")?.dispatchEvent(event);
      }
    });
  }
}
