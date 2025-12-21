CREATE DATABASE karaflow_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE karaflow_db;
CREATE TABLE room_bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  email VARCHAR(100),
  booking_date DATE NOT NULL,
  start_time TIME NOT NULL,
  duration INT NOT NULL,
  room_type ENUM('Standard','VIP','Premium') NOT NULL,
  guests INT NOT NULL,
  theme ENUM('Classic','Neon','Retro','K-Pop','Rock') DEFAULT 'Classic',
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE table_bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  booking_date DATE NOT NULL,
  booking_time TIME NOT NULL,
  guests INT NOT NULL,
  table_zone ENUM('Main Hall','Near Stage','VIP Zone','Balcony') NOT NULL,
  smoking ENUM('Yes','No') DEFAULT 'No',
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
SELECT * FROM room_bookings;
SELECT * FROM table_bookings;
SELECT * FROM karaflow_db.room_bookings;

