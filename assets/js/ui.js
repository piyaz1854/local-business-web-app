export const renderSongs = (songs) => {
  const container = document.getElementById("songs");
  container.innerHTML = "";

  songs.forEach(song => {
    const div = document.createElement("div");
    div.className = "song-card";
    div.innerHTML = `
      <h3>${song.title}</h3>
      <p>Genre: ${song.genre}</p>
      <p>⭐ ${song.rating}</p>
    `;
    container.appendChild(div);
  });
};
