export const API_BASE = '../includes/';

let allSongs = [];

export const auth = {
  login: async (username, password) => {
    const response = await fetch(`${API_BASE}auth_handler.php`, {
      method: 'POST',
      body: new FormData(document.getElementById('loginForm'))
    });
    return response.json();
  },

  logout: async () => {
    const response = await fetch(`${API_BASE}logout_handler.php`);
    return response.json();
  }
};

export const songs = {
  getAll: async () => {
    const response = await fetch(`${API_BASE}songs_handler.php`);
    const data = await response.json();
    if (data.success) {
      allSongs = data.songs;
    }
    return data;
  },

  search: async (query) => {
    const response = await fetch(`${API_BASE}songs_handler.php?search=${encodeURIComponent(query)}`);
    return response.json();
  },

  filterAndSort: (songs, filters) => {
    let filtered = [...songs];
    
    if (filters.genre !== 'all') {
      filtered = filtered.filter(song => song.genre === filters.genre);
    }
    
    if (filters.language !== 'all') {
      filtered = filtered.filter(song => song.language === filters.language);
    }
    
    if (filters.searchText) {
      const searchLower = filters.searchText.toLowerCase();
      filtered = filtered.filter(song => 
        song.title.toLowerCase().includes(searchLower) || 
        song.artist.toLowerCase().includes(searchLower)
      );
    }
    
    filtered.sort((a, b) => {
      switch(filters.sort) {
        case 'title_asc': return a.title.localeCompare(b.title);
        case 'title_desc': return b.title.localeCompare(a.title);
        case 'artist_asc': return a.artist.localeCompare(b.artist);
        case 'year_desc': return b.year - a.year;
        case 'year_asc': return a.year - b.year;
        default: return 0;
      }
    });
    
    return filtered;
  },

  getAllSongs: () => allSongs,

  setAllSongs: (songs) => {
    allSongs = songs;
  }
};

export const favorites = {
  getAll: async () => {
    const response = await fetch(`${API_BASE}favorites_handler.php?action=get_all`);
    return response.json();
  },

  toggle: async (songId, action) => {
    const response = await fetch(`${API_BASE}favorites_handler.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `action=${action}&song_id=${songId}`
    });
    return response.json();
  },

  check: async (songId) => {
    const response = await fetch(`${API_BASE}favorites_handler.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `action=check&song_id=${songId}`
    });
    return response.json();
  }
};

export const bookings = {
  room: async (formData) => {
    const response = await fetch(`${API_BASE}room_booking_handler.php`, {
      method: 'POST',
      body: formData
    });
    return response.json();
  },

  table: async (formData) => {
    const response = await fetch(`${API_BASE}table_booking_handler.php`, {
      method: 'POST',
      body: formData
    });
    return response.json();
  }
};

export const reviews = {
  getAll: async () => {
    const response = await fetch(`${API_BASE}review_handler.php`);
    return response.json();
  },

  submit: async (formData) => {
    const response = await fetch(`${API_BASE}review_handler.php`, {
      method: 'POST',
      body: formData
    });
    return response.json();
  }
};

export const admin = {
  confirmDelete: (message) => confirm(message),

  confirmSongDelete: (title) => {
    return admin.confirmDelete(`Удалить песню «${title}»?`);
  },

  confirmReviewDelete: (name, rating) => {
    return admin.confirmDelete(`Удалить отзыв от ${name}?\nРейтинг: ${rating}/5`);
  },

  confirmRoomBookingDelete: (name, date, time) => {
    return admin.confirmDelete(
      `Удалить бронирование комнаты от ${name}?\nДата: ${date}\nВремя: ${time}`
    );
  },

  confirmTableBookingDelete: (name, date, time) => {
    return admin.confirmDelete(
      `Удалить бронирование стола от ${name}?\nДата: ${date}\nВремя: ${time}`
    );
  }
};