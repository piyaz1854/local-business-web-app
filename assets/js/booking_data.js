// assets/js/data.js
window.DATA = {
  rooms: [
    { name: "Standard 1", type: "Standard", capacity: 6, image: "image20.png" },
    { name: "Standard 2", type: "Standard", capacity: 6, image: "image21.png" },
    { name: "Standard 3", type: "Standard", capacity: 6, image: "image22.png" },
    { name: "Standard 4", type: "Standard", capacity: 8, image: "image23.png" },
    { name: "Standard 5", type: "Standard", capacity: 8, image: "image24.png" },
    { name: "Standard 6", type: "Standard", capacity: 10, image: "image25.png" },
    { name: "VIP 1", type: "VIP", capacity: 12, image: "image26.png" },
    { name: "VIP 2", type: "VIP", capacity: 12, image: "image27.png" },
    { name: "Premium 1", type: "Premium", capacity: 15, image: "image28.png" },
    { name: "Premium 2", type: "Premium", capacity: 15, image: "image29.png" },
  ],

  tables: {
    "Main Hall": {
      image: "image30.png",
      tables: [
        { name: "Main Hall Table 1", capacity: 6 },
        { name: "Main Hall Table 2", capacity: 8 },
        { name: "Main Hall Table 3", capacity: 10 },
        { name: "Main Hall Table 4", capacity: 12 },
        { name: "Main Hall Table 5", capacity: 16 },
        { name: "Main Hall Table 6", capacity: 20 },
      ]
    },
    "Near Stage": {
      image: "image31.png",
      tables: [
        { name: "Near Stage Table 1", capacity: 8 },
        { name: "Near Stage Table 2", capacity: 12 },
      ]
    },
    "Balcony": {
      image: "image32.png",
      tables: [
        { name: "Balcony Table 1", capacity: 10 },
        { name: "Balcony Table 2", capacity: 16 },
      ]
    }
  }
};
