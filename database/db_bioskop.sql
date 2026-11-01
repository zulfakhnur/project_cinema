-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2026 at 04:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bioskop`
--
CREATE DATABASE IF NOT EXISTS `db_bioskop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_bioskop`;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_code` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timetable_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `timetable_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL,
  `age_rating` varchar(10) DEFAULT NULL,
  `synopsis` text DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `status` enum('now_showing','coming_soon') DEFAULT 'now_showing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`, `title`, `genre`, `duration`, `age_rating`, `synopsis`, `poster`, `status`) VALUES
(1, 'Clayface', 'Aksi', 108, 'R', 'Bintang Hollywood yang sedang naik daun, Matt Hagen, berubah menjadi monster mengerikan yang penuh dendam setelah ambisi ilmiah merenggut identitas serta kemanusiaannya.', 'poster_6ae744a2e8009.jpeg', 'now_showing'),
(2, 'Ebenezer', 'Fantasy', 116, '13+', 'Sebuah kisah hantu yang mendebarkan dengan latar London di era Dickens, mengikuti perjalanan supranatural seorang pria dalam menghadapi masa lalu, masa kini, dan masa depannya, sembari berjuang demi kesempatan kedua untuk menebus kesalahan.', 'poster_6ae746f149cee.jpeg', 'now_showing'),
(3, 'Jumanji: Open World', 'Komedi', 120, 'SU', 'Para pemain telah berhasil meloloskan diri dari hutan Jumanji yang terus berubah, namun kali ini permainan tersebut keluar dari konsolnya dan menebarkan kekacauan ke dunia kita.', 'poster_6ae7461612cb1.jpeg', 'now_showing'),
(4, 'Avengers: Doomsday', 'Aksi', 165, '13+', 'Para pahlawan dari tiga dunia yang berbeda harus bersatu ketika mereka dipertemukan untuk menghadapi bahaya katastropik yang dapat menghancurkan segala hal yang mereka kenal.', 'poster_6ae7456c48c7f.jpeg', 'now_showing'),
(6, 'Ramayana: Rise of a Legend', 'Fantasy', 165, '13+', 'Sebuah epos kuno mengisahkan seorang pangeran dan putri muda yang pernikahan serta pengasingan mereka menjadi awal dari sebuah perjalanan legendaris. Kisah cinta, kewajiban, dan takdir mereka menjadi landasan bagi tantangan-tantangan yang lebih besar di masa depan.', 'poster_6ae74819112c3.jpeg', 'now_showing'),
(7, 'Dune: Part Three', 'Aksi', 120, '17+', 'Kaisar Paul Atreides menghadapi dampak dari naiknya ia ke tampuk kekuasaan, sementara intrik politik dan perang suci yang melanda seluruh galaksi mengancam masa depan yang hanya bisa dilihat oleh dirinya.', 'poster_6ae7489099a49.jpeg', 'now_showing'),
(8, 'Godzilla:Minus Zero', 'Aksi', 135, 'R', 'Berlatar tahun 1949, keluarga Shikishima menghadapi bencana baru, dua tahun setelah mereka selamat dari cobaan sebelumnya yang melibatkan monster legendaris tersebut.', 'poster_6ae748e184ed3.jpeg', 'now_showing');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `studio_id` int(11) NOT NULL,
  `seat_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `studio_id`, `seat_code`) VALUES
(1, 1, 'A1'),
(2, 2, 'A1'),
(3, 1, 'B1'),
(4, 2, 'B1'),
(5, 1, 'C1'),
(6, 2, 'C1'),
(7, 1, 'D1'),
(8, 2, 'D1'),
(9, 1, 'E1'),
(10, 2, 'E1'),
(11, 1, 'F1'),
(12, 2, 'F1'),
(13, 1, 'A2'),
(14, 2, 'A2'),
(15, 1, 'B2'),
(16, 2, 'B2'),
(17, 1, 'C2'),
(18, 2, 'C2'),
(19, 1, 'D2'),
(20, 2, 'D2'),
(21, 1, 'E2'),
(22, 2, 'E2'),
(23, 1, 'F2'),
(24, 2, 'F2'),
(25, 1, 'A3'),
(26, 2, 'A3'),
(27, 1, 'B3'),
(28, 2, 'B3'),
(29, 1, 'C3'),
(30, 2, 'C3'),
(31, 1, 'D3'),
(32, 2, 'D3'),
(33, 1, 'E3'),
(34, 2, 'E3'),
(35, 1, 'F3'),
(36, 2, 'F3'),
(37, 1, 'A4'),
(38, 2, 'A4'),
(39, 1, 'B4'),
(40, 2, 'B4'),
(41, 1, 'C4'),
(42, 2, 'C4'),
(43, 1, 'D4'),
(44, 2, 'D4'),
(45, 1, 'E4'),
(46, 2, 'E4'),
(47, 1, 'F4'),
(48, 2, 'F4'),
(49, 1, 'A5'),
(50, 2, 'A5'),
(51, 1, 'B5'),
(52, 2, 'B5'),
(53, 1, 'C5'),
(54, 2, 'C5'),
(55, 1, 'D5'),
(56, 2, 'D5'),
(57, 1, 'E5'),
(58, 2, 'E5'),
(59, 1, 'F5'),
(60, 2, 'F5'),
(61, 1, 'A6'),
(62, 2, 'A6'),
(63, 1, 'B6'),
(64, 2, 'B6'),
(65, 1, 'C6'),
(66, 2, 'C6'),
(67, 1, 'D6'),
(68, 2, 'D6'),
(69, 1, 'E6'),
(70, 2, 'E6'),
(71, 1, 'F6'),
(72, 2, 'F6'),
(73, 1, 'A7'),
(74, 2, 'A7'),
(75, 1, 'B7'),
(76, 2, 'B7'),
(77, 1, 'C7'),
(78, 2, 'C7'),
(79, 1, 'D7'),
(80, 2, 'D7'),
(81, 1, 'E7'),
(82, 2, 'E7'),
(83, 1, 'F7'),
(84, 2, 'F7'),
(85, 1, 'A8'),
(86, 2, 'A8'),
(87, 1, 'B8'),
(88, 2, 'B8'),
(89, 1, 'C8'),
(90, 2, 'C8'),
(91, 1, 'D8'),
(92, 2, 'D8'),
(93, 1, 'E8'),
(94, 2, 'E8'),
(95, 1, 'F8'),
(96, 2, 'F8');

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(30) DEFAULT 'Regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`id`, `name`, `type`) VALUES
(1, 'Studio 1', 'Regular'),
(2, 'Studio 2', 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `studio_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `film_id`, `studio_id`, `show_date`, `show_time`, `price`) VALUES
(1, 1, 1, '2026-12-20', '10:00:00', 45000),
(3, 2, 2, '2026-12-19', '15:30:00', 50000),
(4, 3, 1, '2026-12-18', '20:00:00', 45000),
(5, 4, 2, '2026-12-20', '12:30:00', 50000),
(6, 1, 1, '2026-12-19', '10:30:00', 45000),
(8, 8, 2, '2026-12-20', '10:00:00', 50000),
(9, 6, 2, '2026-12-18', '18:00:00', 50000),
(10, 7, 2, '2026-12-20', '15:00:00', 50000),
(11, 2, 1, '2026-12-18', '15:30:00', 45000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `timetable_id` (`timetable_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `timetable_id` (`timetable_id`,`seat_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studio_id` (`studio_id`);

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `film_id` (`film_id`),
  ADD KEY `studio_id` (`studio_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `studios`
--
ALTER TABLE `studios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`timetable_id`) REFERENCES `timetables` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`timetable_id`) REFERENCES `timetables` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_ibfk_3` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`studio_id`) REFERENCES `studios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetables_ibfk_2` FOREIGN KEY (`studio_id`) REFERENCES `studios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
