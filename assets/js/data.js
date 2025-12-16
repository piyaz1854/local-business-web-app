

export const rooms = [
  { id: 1, name: "Standard 1", capacity: 4, pricePerHour: 8000, photo: "" },
  { id: 2, name: "Standard 2", capacity: 6, pricePerHour: 10000, photo: "" },
  { id: 3, name: "VIP Gold", capacity: 10, pricePerHour: 18000, photo: "" },
];

export const menuItems = [
  { id: 1, name: "Cola", category: "Drinks", price: 800, allergens: [] },
  { id: 2, name: "Nachos", category: "Snacks", price: 2200, allergens: ["gluten"] },
  { id: 3, name: "Cheese plate", category: "Snacks", price: 3500, allergens: ["lactose"] },
];


export function filterRoomsByCapacity(minCapacity) {
  return rooms.filter(r => r.capacity >= minCapacity);
}

export function sortRoomsByPrice(list, dir = "asc") {
  const k = dir === "desc" ? -1 : 1;
  return [...list].sort((a, b) => (a.pricePerHour - b.pricePerHour) * k);
}

export function calcBookingTotal(pricePerHour, hours) {
  const parts = Array.from({ length: hours }, () => pricePerHour);
  return parts.reduce((sum, x) => sum + x, 0);
}
