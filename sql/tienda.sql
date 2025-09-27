-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 07:00 AM
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
-- Database: `tienda`
--

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `genero` enum('men','women','unisex') NOT NULL DEFAULT 'unisex',
  `imagen` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `genero`, `imagen`, `activo`, `creado_en`) VALUES
(1, 'Sudadera Unisex', 699.00, 'unisex', 'assets/p1.jpg', 1, '2025-09-18 18:43:28'),
(2, 'Playera Hombre', 399.00, 'men', 'assets/p2.jpg', 1, '2025-09-18 18:43:28'),
(3, 'Pantalón Cargo', 849.00, 'men', 'assets/p6.jpg', 1, '2025-09-27 04:05:23'),
(4, 'Vestido Casual', 999.00, 'women', 'assets/p7.jpg', 1, '2025-09-27 04:05:23'),
(5, 'Sudadera con Capucha', 749.00, 'unisex', 'assets/p8.jpg', 1, '2025-09-27 04:05:23'),
(6, 'Short Deportivo', 499.00, 'unisex', 'assets/p9.jpg', 1, '2025-09-27 04:05:23'),
(7, 'Blusa Elegante', 679.00, 'women', 'assets/p10.jpg', 1, '2025-09-27 04:05:23');

-- --------------------------------------------------------

--
-- Table structure for table `variantes`
--

CREATE TABLE `variantes` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla` varchar(10) NOT NULL,
  `color` varchar(30) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variantes`
--

INSERT INTO `variantes` (`id`, `producto_id`, `talla`, `color`, `stock`) VALUES
(1, 1, 'S', 'gris', 6),
(2, 1, 'M', 'gris', 4),
(3, 1, 'L', 'gris', 2),
(4, 2, 'M', 'azul', 5),
(5, 2, 'L', 'azul', 3),
(6, 3, '30', 'verde', 10),
(7, 3, '32', 'verde', 12),
(8, 3, '34', 'verde', 8),
(9, 4, 'S', 'rojo', 6),
(10, 4, 'M', 'rojo', 5),
(11, 4, 'L', 'rojo', 3),
(12, 5, 'S', 'negro', 12),
(13, 5, 'M', 'negro', 10),
(14, 5, 'L', 'negro', 6),
(15, 6, 'S', 'azul', 15),
(16, 6, 'M', 'azul', 12),
(17, 6, 'L', 'azul', 9),
(18, 7, 'S', 'blanco', 9),
(19, 7, 'M', 'blanco', 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variantes`
--
ALTER TABLE `variantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `variantes`
--
ALTER TABLE `variantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `variantes`
--
ALTER TABLE `variantes`
  ADD CONSTRAINT `variantes_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
