-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: db.3wa.io
-- Generation Time: Feb 07, 2024 at 06:06 AM
-- Server version: 5.7.33-0ubuntu0.18.04.1-log
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maridoucet_bre01_userbase_poo`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(5) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Test', 'test@test.fr', '$2y$10$MXdJStM/YX9vJDjgD67l6.gNuJpzKs2/9x6nD4p54SRfNQpjv32jq', 'USER', '2016-01-07 13:53:51'),
(2, 'Admin', 'admin@test.fr', '$2y$10$cy4evTNdUAkjwIb8u6MyreJSpNmzVE1LNShHd0JhLcRkFKgXPxx0W', 'ADMIN', '2024-01-26 18:15:35'),
(3, 'User', 'user@test.fr', '$2y$10$txzUzh73e9SKOjJ496JYTuUsHnoSWOdS02KFEORF40eUoZ0vWWcHG', 'USER', '2024-01-26 23:06:35'),
(4, 'Secure', 'secure@test.fr', '$2y$10$UvgzpYt9eZWhrxoPmUFEauH3Juts9HxZA8VRxwDeo1g2vL2gK3CVa', 'ADMIN', '2024-01-26 02:15:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
