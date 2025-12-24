-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 24 2025 г., 03:54
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `karaflow_db`
--
CREATE DATABASE IF NOT EXISTS `karaflow_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `karaflow_db`;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 1,
  `song_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `song_id` (`song_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ССЫЛКИ ТАБЛИЦЫ `favorites`:
--   `song_id`
--       `songs` -> `id`
--

--
-- Дамп данных таблицы `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `song_id`, `created_at`) VALUES
(20, 1, 17, '2025-12-24 01:10:32'),
(21, 1, 13, '2025-12-24 01:10:37'),
(22, 1, 11, '2025-12-24 01:10:41');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `allergens` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ССЫЛКИ ТАБЛИЦЫ `menu_items`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ССЫЛКИ ТАБЛИЦЫ `reviews`:
--

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `rating`, `comment`, `created_at`) VALUES
(1, 'Anonymous', 3, 'fmdkfmdk,dlv', '2025-12-23 14:31:42'),
(2, 'Anonymous', 5, 'орпасмр', '2025-12-24 00:07:38'),
(3, 'Anonymous', 3, 'риотло', '2025-12-24 00:07:49'),
(4, 'xdjnxjdknx', 4, 'jkhjvgvjhjknlk', '2025-12-24 00:29:25'),
(5, 'cdcdc', 2, 'dcdnckdnkd', '2025-12-24 00:29:41'),
(6, 'dcc', 5, '123456', '2025-12-24 00:29:48');

-- --------------------------------------------------------

--
-- Структура таблицы `room_bookings`
--

DROP TABLE IF EXISTS `room_bookings`;
CREATE TABLE IF NOT EXISTS `room_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `duration` int(11) NOT NULL,
  `room_type` enum('Standard','VIP','Premium') NOT NULL,
  `guests` int(11) NOT NULL,
  `theme` enum('Classic','Neon','Retro','K-Pop','Rock') DEFAULT 'Classic',
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ССЫЛКИ ТАБЛИЦЫ `room_bookings`:
--

--
-- Дамп данных таблицы `room_bookings`
--

INSERT INTO `room_bookings` (`id`, `client_name`, `phone`, `email`, `booking_date`, `start_time`, `duration`, `room_type`, `guests`, `theme`, `comment`, `created_at`) VALUES
(2, 'уцу', '12343212345', 'aripxanovy@mail.ru', '3212-12-31', '23:03:00', 2, 'VIP', 33, 'K-Pop', 'укрвпавафыаыпва', '2025-12-23 18:58:19');

-- --------------------------------------------------------

--
-- Структура таблицы `songs`
--

DROP TABLE IF EXISTS `songs`;
CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `artist` varchar(200) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `favorites` int(11) DEFAULT 0,
  `youtube_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ССЫЛКИ ТАБЛИЦЫ `songs`:
--

--
-- Дамп данных таблицы `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `genre`, `year`, `duration`, `language`, `favorites`, `youtube_id`) VALUES
(3, 'Shape of You', 'Ed Sheeran', 'Pop', 2017, '03:54:00', 'English', 0, 'liTfD88dbCo'),
(10, 'Dynamite', 'BTS', 'K-Pop', 2020, '03:19:00', 'Korean', 0, 'wqAzxAR0h5A'),
(11, 'Отпусти и забудь (Холодное сердце)', 'Анна Бутурлина', 'Pop', 2017, '03:40:00', 'Russian', 0, '2JzPZSw7lDY'),
(12, 'Ұнайды маған', 'Мархаба Сәби', 'Pop', 2015, '00:03:25', 'Kazakh', 0, '7Y9CLRwzkaI'),
(13, 'Алтыным', 'Айқын Төлепберген', 'Pop', 2010, '00:02:38', 'Kazakh', 0, 'blz-ZCLnPfo'),
(14, 'Белгісіз жан', 'Орда тобы', 'Pop', 2009, '00:04:27', 'Kazakh', 0, 'yg4HHQ_NTAM'),
(15, 'Капкан', 'Мот', 'Hip-Hop', 2018, '00:03:38', 'Russian', 0, '3EP9AJ4uHLM'),
(16, 'Прованс', 'Елка', 'Rap', 2010, '00:03:26', 'Russian', 0, 'ICbSgK5j66'),
(17, 'Last Christmas', 'Wham!', 'Hip-Hop', 2006, '00:04:23', 'English', 0, 'KhqNTjbQ71A'),
(18, 'Әндетемін', 'Мирас Жүгінісов', 'Hip-Hop', 2024, '00:03:48', 'Kazakh', 0, 'F9oze4mqU6U'),
(19, 'Die With A Smile', 'Lady Gaga, Bruno Mars', 'Hip-Hop', 2024, '00:04:09', 'English', 0, 'zgaCZOQCpp8'),
(20, 'Without Me', 'Eminem', 'Rap', 2024, '00:04:51', 'English', 0, '-8xhmV3JoG4'),
(21, 'Beggin\'', 'Måneskin', 'Rap', 2024, '00:03:30', 'English', 0, 'W2MpGCL8-9o'),
(22, 'По берегу', 'Rin\'Go', 'Pop', 2007, '00:03:44', 'Kazakh', 0, 'xFCkPunLUos'),
(23, 'Ғашықсың ба?', 'Орда тобы', 'Hip-Hop', 2024, '00:03:45', 'Kazakh', 0, 'FMoOwKVL8TY');

-- --------------------------------------------------------

--
-- Структура таблицы `table_bookings`
--

DROP TABLE IF EXISTS `table_bookings`;
CREATE TABLE IF NOT EXISTS `table_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `guests` int(11) NOT NULL,
  `table_zone` enum('Main Hall','Near Stage','VIP Zone','Balcony') NOT NULL,
  `smoking` enum('Yes','No') DEFAULT 'No',
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ССЫЛКИ ТАБЛИЦЫ `table_bookings`:
--

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE CASCADE;


--
-- Метаданные
--
USE `phpmyadmin`;

--
-- Метаданные для таблицы favorites
--

--
-- Метаданные для таблицы menu_items
--

--
-- Метаданные для таблицы reviews
--

--
-- Метаданные для таблицы room_bookings
--

--
-- Метаданные для таблицы songs
--

--
-- Метаданные для таблицы table_bookings
--

--
-- Метаданные для базы данных karaflow_db
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
