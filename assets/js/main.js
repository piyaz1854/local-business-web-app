import { songs, favorites, reviews } from "./data.js";
import { notifications, ui, styles } from "./ui.js";
import { handlers, forms, adminHandlers, setupSearchButton } from "./events.js";

window.toggleFavorite = handlers.toggleFavorite;
window.showNotification = notifications.show;

function setupFavoriteButtons() {
  document.querySelectorAll(".favorite-btn").forEach((button) => {
    const newButton = button.cloneNode(true);
    button.parentNode.replaceChild(newButton, button);

    newButton.addEventListener("click", async function () {
      const songId = this.getAttribute("data-song-id");
      if (songId) {
        await handlers.toggleFavorite(songId, this);

        if (window.location.pathname.includes("favorites.php")) {
          setTimeout(() => initFavoritesPage(), 1000);
        }
      }
    });
  });
}

async function initSongsPage() {
  try {
    const data = await songs.getAll();
    if (data.success) {
      songs.setAllSongs(data.songs);

      const applyFilters = () => {
        const genre = document.getElementById("genreFilter")?.value || "all";
        const language =
          document.getElementById("languageFilter")?.value || "all";
        const sort =
          document.getElementById("sortFilter")?.value || "title_asc";
        const searchText =
          document.getElementById("songSearch")?.value.toLowerCase() || "";

        const filtered = songs.filterAndSort(data.songs, {
          genre,
          language,
          sort,
          searchText,
        });

        ui.displaySongs(filtered, "songsContainer");
        ui.updateStats(filtered.length, data.songs.length, "songStats");

        setupFavoriteButtons();
      };

      ui.displaySongs(data.songs, "songsContainer");
      ui.updateStats(data.songs.length, data.songs.length, "songStats");
      handlers.setupSearch(data.songs, applyFilters);
      handlers.setupFilters(data.songs, applyFilters);
      setupSearchButton(applyFilters);
      setupFavoriteButtons();
      setTimeout(async () => {
        const buttons = document.querySelectorAll(".favorite-btn");
        for (const button of buttons) {
          const songId = button.getAttribute("data-song-id");
          try {
            const favData = await favorites.check(songId);
            if (favData.success && favData.is_favorite) {
              button.classList.add("active");
              button.innerHTML = "❤️";
              button.title = "Remove from favorites";
            } else {
              button.classList.remove("active");
              button.innerHTML = "🤍";
              button.title = "Add to favorites";
            }
          } catch (error) {
            console.error("Error checking favorite:", error);
          }
        }
      }, 500);
    }
  } catch (error) {
    console.error("Error loading songs:", error);
    notifications.show("Error loading songs", "error");
  }
}

async function initFavoritesPage() {
  try {
    const data = await favorites.getAll();
    if (data.success) {
      ui.displayFavorites(data.songs, "favoritesContainer");
      setupFavoriteButtons();

      const favoritesCount = document.getElementById("favoritesCount");
      if (favoritesCount) {
        favoritesCount.textContent = data.songs.length;
      }
    }
  } catch (error) {
    console.error("Error loading favorites:", error);
    notifications.show("Error loading favorites", "error");
  }
}

async function initKaraokePage() {
  const urlParams = new URLSearchParams(window.location.search);
  const songId = urlParams.get("song_id");
  const button = document.getElementById("favoriteBtn");

  if (songId && button) {
    try {
      const data = await favorites.check(songId);
      if (data.success && data.is_favorite) {
        button.classList.add("active");
        button.innerHTML = "❤️ Remove from Favorites";
        button.title = "Remove from favorites";
      } else {
        button.classList.remove("active");
        button.innerHTML = "🤍 Add to Favorites";
        button.title = "Add to favorites";
      }

      button.addEventListener("click", async function () {
        await handlers.toggleFavorite(songId, this);
      });
    } catch (error) {
      console.error("Error checking favorite status:", error);
    }
  }
}

async function initReviewsPage() {
  handlers.setupAnonymousToggle();
  forms.reviews("reviewForm");

  try {
    const data = await reviews.getAll();
    if (data.html) {
      document.getElementById("reviewsList").innerHTML = data.html;
    }
  } catch (error) {
    console.error("Error loading reviews:", error);
  }
}

function initAdminPage() {
  styles.restoreTheme();

  adminHandlers.createQuickActions();

  styles.addHoverEffects(".menu-card, .review-card, .stat-card, .booking-card");

  styles.addCopyIdButtons();

  styles.highlightTodayDates();

  adminHandlers.updateDeleteHandlers();

  const searchInput = document.querySelector(".search-input");
  if (searchInput) {
    setTimeout(() => searchInput.focus(), 100);
  }

  const durationInput = document.getElementById("duration");
  if (durationInput) {
    durationInput.addEventListener("blur", function () {
      const value = this.value.trim();
      if (value && !/^\d{1,2}:\d{2}$/.test(value)) {
        notifications.show(
          "Enter duration in MM:SS format (e.g., 03:45)",
          "warning"
        );
        this.focus();
      }
    });
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const path = window.location.pathname;

  if (path.includes("songs.php")) {
    initSongsPage();
  } else if (path.includes("favorites.php")) {
    initFavoritesPage();
  } else if (path.includes("karaoke.php")) {
    initKaraokePage();
  } else if (path.includes("reviews.php")) {
    initReviewsPage();
  } else if (path.includes("booking_table.php")) {
    forms.tableBooking("tableForm");
  } else if (path.includes("booking_room.php")) {
    forms.roomBooking("roomForm");
  } else if (path.includes("/admin/")) {
    initAdminPage();
  }
});
