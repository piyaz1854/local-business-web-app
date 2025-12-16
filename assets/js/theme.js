// theme.js – управление темой (темная/светлая)

document.addEventListener("DOMContentLoaded", function () {
  const themeToggle = document.getElementById("theme-toggle");
  const body = document.body;

  // Проверяем сохраненную тему в куки
  function getCookie(name) {
    const cookies = document.cookie.split(";");
    for (let cookie of cookies) {
      const [key, value] = cookie.trim().split("=");
      if (key === name) return value;
    }
    return null;
  }

  // Устанавливаем тему
  function setTheme(theme) {
    body.classList.remove("light-theme", "dark-theme");
    body.classList.add(theme + "-theme");
    document.cookie = `karaoke_theme=${theme}; max-age=${
      365 * 24 * 60 * 60
    }; path=/`;

    if (themeToggle) {
      themeToggle.textContent =
        theme === "dark" ? "☀️ Light Mode" : "🌙 Dark Mode";
    }
  }

  // Инициализация темы
  const savedTheme = getCookie("karaoke_theme") || "light";
  setTheme(savedTheme);

  // Обработчик переключения
  if (themeToggle) {
    themeToggle.addEventListener("click", function () {
      const currentTheme = body.classList.contains("dark-theme")
        ? "dark"
        : "light";
      const newTheme = currentTheme === "dark" ? "light" : "dark";
      setTheme(newTheme);
    });
  }
});
