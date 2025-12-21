import { songs } from "./data.js";
import { renderSongs } from "./ui.js";

console.log("EVENTS.JS LOADED NEW VERSION");

// Проверяем наличие контейнера
const songsContainer = document.getElementById("songs");

if (songsContainer) {
  renderSongs(songs);

  const genreFilter = document.getElementById("genreFilter");

  if (genreFilter) {
    genreFilter.addEventListener("change", (e) => {
      const value = e.target.value;

      const filtered =
        value === "all"
          ? songs
          : songs.filter(song => song.genre === value);

      renderSongs(filtered);
    });
  }
}
