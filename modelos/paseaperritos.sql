-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 04:43 PM
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
-- Database: `paseaperritos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idAdmin`, `nombre`, `correo`, `clave`) VALUES
(123, 'Dana Moreno', '10@pp.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `dueno`
--

CREATE TABLE `dueno` (
  `idDueno` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dueno`
--

INSERT INTO `dueno` (`idDueno`, `nombre`, `correo`, `clave`) VALUES
(1, 'Juan Moreno', 'juan@pp.com', '202cb962ac59075b964b07152d234b70'),
(2, 'pepe', 'pepe@pp.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `estadopaseo`
--

CREATE TABLE `estadopaseo` (
  `idEstadoPaseo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estadopaseo`
--

INSERT INTO `estadopaseo` (`idEstadoPaseo`, `nombre`) VALUES
(1, 'Reservado'),
(2, 'Realizado'),
(3, 'Cancelado'),
(4, 'Rechazado'),
(5, 'Pendiente');

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `id_paseo` int(11) NOT NULL,
  `fecha_emision` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `qr_code_url` varchar(255) DEFAULT NULL,
  `url_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `factura`
--

INSERT INTO `factura` (`id_factura`, `id_paseo`, `fecha_emision`, `total`, `qr_code_url`, `url_pdf`) VALUES
(14, 45, '2025-06-23', 4000.00, 'archivos_qr/qr_6858b34a3f329.png', NULL),
(15, 46, '2025-06-23', 4000.00, 'archivos_qr/qr_6858b3ef40be4.png', NULL),
(16, 47, '2025-06-23', 100000.00, 'archivos_qr/qr_6858b8aae105c.png', NULL),
(17, 48, '2025-06-23', 100000.00, 'archivos_qr/qr_6858b93c74f62.png', NULL),
(18, 49, '2025-06-23', 100000.00, 'archivos_qr/qr_6858b9fa17469.png', NULL),
(19, 50, '2025-06-23', 4000.00, 'archivos_qr/qr_6858ba6bae97f.png', NULL),
(20, 51, '2025-06-23', 30000.00, 'archivos_qr/qr_6858bbde05842.png', ''),
(21, 52, '2025-06-23', 30000.00, 'archivos_qr/qr_6858bbfca5e05.png', ''),
(22, 53, '2025-06-23', 30000.00, 'archivos_qr/qr_6858bc2f35480.png', 'http://localhost/paseaPerritos/facturas/factura_53_1750645807.pdf'),
(23, 54, '2025-06-23', 15000.00, 'archivos_qr/qr_6858bc9e55978.png', 'http://localhost/paseaPerritos/facturas/factura_54_1750645918.pdf'),
(24, 55, '2025-06-23', 2000.00, 'archivos_qr/qr_6858bcfac2e1a.png', 'http://localhost/paseaPerritos/facturas/factura_55_1750646010.pdf'),
(25, 56, '2025-06-23', 30000.00, 'archivos_qr/qr_6858beb9ce532.png', 'http://localhost/paseaPerritos/facturas/factura_56_1750646457.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `paseador`
--

CREATE TABLE `paseador` (
  `idPaseador` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paseador`
--

INSERT INTO `paseador` (`idPaseador`, `nombre`, `correo`, `clave`, `foto_url`, `descripcion`, `estado`) VALUES
(1, 'David Moreno', '11@pp.com', '202cb962ac59075b964b07152d234b70', 'imagenes/paseadores/images2.jpg', 'me gustan los perritos cariñosos', 1),
(2, 'Juan Pérez Moreno', 'paseador@pp.com.co', 'd41d8cd98f00b204e9800998ecf8427e', 'imagenes/paseadores/images.jpg', 'me gustan los paseos largos', 1),
(3, 'Carlos Pérez', 'carlos@example.com', 'd41d8cd98f00b204e9800998ecf8427e', 'Warning: Undefined variable $foto_url in C:xampphtdocspaseaPerritoslogicaPaseador.php on line 17\n\nWarning: Undefined property: Paseador::$ in C:xampphtdocspaseaPerritoslogicaPaseador.php on line 17\nimagenes/paseadores/images2.jpg', 'me gustan los bulldog', 1),
(13, 'Ana', 'ana@pp.com', '202cb962ac59075b964b07152d234b70', 'imagenes/paseadores/images.jpg', 'me gustan los pug', 1),
(14, 'Danna Moreno', 'danna13@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'imagenes/paseadores/1750463480_WhatsApp Image 2025-06-20 at 6.50.15 PM.jpeg', 'les doy un premio en cada paseo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `paseo`
--

CREATE TABLE `paseo` (
  `idPaseo` int(11) NOT NULL,
  `idPaseador` int(11) NOT NULL,
  `idPerrito` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time DEFAULT NULL,
  `duracion_minutos` int(11) NOT NULL,
  `idTarifa` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `idEstadoPaseo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paseo`
--

INSERT INTO `paseo` (`idPaseo`, `idPaseador`, `idPerrito`, `fecha`, `hora_inicio`, `hora_fin`, `duracion_minutos`, `idTarifa`, `precio`, `idEstadoPaseo`) VALUES
(45, 14, 4, '2025-06-22', '15:52:00', '17:52:00', 120, 9, 4000.00, 5),
(46, 14, 4, '2025-06-22', '15:52:00', '17:52:00', 120, 9, 4000.00, 5),
(47, 13, 2, '2025-06-23', '21:15:00', '23:15:00', 120, 8, 100000.00, 5),
(48, 13, 2, '2025-06-23', '21:15:00', '23:15:00', 120, 8, 100000.00, 5),
(49, 13, 1, '2025-05-01', '21:20:00', '23:20:00', 120, 8, 100000.00, 5),
(50, 14, 2, '2025-07-23', '17:22:00', '19:22:00', 120, 9, 4000.00, 5),
(51, 2, 4, '2025-06-27', '21:44:00', '22:44:00', 60, 11, 30000.00, 5),
(52, 2, 4, '2025-06-27', '21:44:00', '22:44:00', 60, 11, 30000.00, 5),
(53, 2, 4, '2025-06-14', '12:30:00', '13:30:00', 60, 11, 30000.00, 5),
(54, 1, 3, '2025-06-06', '21:31:00', '22:31:00', 60, 1, 15000.00, 5),
(55, 14, 1, '2025-07-11', '21:33:00', '22:33:00', 60, 9, 2000.00, 5),
(56, 2, 2, '2025-08-28', '21:40:00', '22:40:00', 60, 11, 30000.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `perrito`
--

CREATE TABLE `perrito` (
  `idPerrito` int(11) NOT NULL,
  `idDueno` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `raza` varchar(100) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `foto_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perrito`
--

INSERT INTO `perrito` (`idPerrito`, `idDueno`, `nombre`, `raza`, `edad`, `foto_url`) VALUES
(1, 1, 'mia', 'pug', 8, NULL),
(2, 1, 'pepe', 'bulldog', 1, 'imagenes/perritos/1750613304_JHLWPZQCQNCJRIYVCLNUKIISU4.jpg'),
(3, 1, 'alfonso', 'bulldog', 1, 'imagenes/perritos/1750613330_JHLWPZQCQNCJRIYVCLNUKIISU4.jpg'),
(4, 1, 'cariñoso', 'bulldog', 1, 'imagenes/perritos/1750613354_JHLWPZQCQNCJRIYVCLNUKIISU4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tarifapaseador`
--

CREATE TABLE `tarifapaseador` (
  `idTarifa` int(11) NOT NULL,
  `idPaseador` int(11) NOT NULL,
  `valor_hora` decimal(10,2) NOT NULL,
  `fecha_inicio_vigencia` date NOT NULL,
  `fecha_fin_vigencia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tarifapaseador`
--

INSERT INTO `tarifapaseador` (`idTarifa`, `idPaseador`, `valor_hora`, `fecha_inicio_vigencia`, `fecha_fin_vigencia`) VALUES
(1, 1, 15000.00, '2025-06-01', NULL),
(3, 2, 15000.00, '0000-00-00', '2025-06-22'),
(4, 3, 18000.00, '0000-00-00', '2025-06-22'),
(8, 13, 50000.00, '2025-06-21', NULL),
(9, 14, 2000.00, '2025-06-21', NULL),
(10, 2, 30000.00, '0000-00-00', '2025-06-22'),
(11, 2, 30000.00, '2025-06-22', NULL),
(12, 3, 10000.00, '2025-06-22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`),
  ADD UNIQUE KEY `email` (`correo`);

--
-- Indexes for table `dueno`
--
ALTER TABLE `dueno`
  ADD PRIMARY KEY (`idDueno`),
  ADD UNIQUE KEY `email` (`correo`);

--
-- Indexes for table `estadopaseo`
--
ALTER TABLE `estadopaseo`
  ADD PRIMARY KEY (`idEstadoPaseo`);

--
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_paseo` (`id_paseo`);

--
-- Indexes for table `paseador`
--
ALTER TABLE `paseador`
  ADD PRIMARY KEY (`idPaseador`),
  ADD UNIQUE KEY `email` (`correo`);

--
-- Indexes for table `paseo`
--
ALTER TABLE `paseo`
  ADD PRIMARY KEY (`idPaseo`),
  ADD KEY `id_paseador` (`idPaseador`),
  ADD KEY `id_perrito` (`idPerrito`),
  ADD KEY `id_tarifa` (`idTarifa`),
  ADD KEY `id_estado_paseo` (`idEstadoPaseo`);

--
-- Indexes for table `perrito`
--
ALTER TABLE `perrito`
  ADD PRIMARY KEY (`idPerrito`),
  ADD KEY `id_dueno` (`idDueno`);

--
-- Indexes for table `tarifapaseador`
--
ALTER TABLE `tarifapaseador`
  ADD PRIMARY KEY (`idTarifa`),
  ADD KEY `id_paseador` (`idPaseador`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `dueno`
--
ALTER TABLE `dueno`
  MODIFY `idDueno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `estadopaseo`
--
ALTER TABLE `estadopaseo`
  MODIFY `idEstadoPaseo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `paseador`
--
ALTER TABLE `paseador`
  MODIFY `idPaseador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `paseo`
--
ALTER TABLE `paseo`
  MODIFY `idPaseo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `perrito`
--
ALTER TABLE `perrito`
  MODIFY `idPerrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tarifapaseador`
--
ALTER TABLE `tarifapaseador`
  MODIFY `idTarifa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_paseo`) REFERENCES `paseo` (`idPaseo`) ON DELETE CASCADE;

--
-- Constraints for table `paseo`
--
ALTER TABLE `paseo`
  ADD CONSTRAINT `paseo_ibfk_1` FOREIGN KEY (`idPaseador`) REFERENCES `paseador` (`idPaseador`),
  ADD CONSTRAINT `paseo_ibfk_2` FOREIGN KEY (`idPerrito`) REFERENCES `perrito` (`idPerrito`),
  ADD CONSTRAINT `paseo_ibfk_3` FOREIGN KEY (`idTarifa`) REFERENCES `tarifapaseador` (`idTarifa`),
  ADD CONSTRAINT `paseo_ibfk_4` FOREIGN KEY (`idEstadoPaseo`) REFERENCES `estadopaseo` (`idEstadoPaseo`);

--
-- Constraints for table `perrito`
--
ALTER TABLE `perrito`
  ADD CONSTRAINT `perrito_ibfk_1` FOREIGN KEY (`idDueno`) REFERENCES `dueno` (`idDueno`) ON DELETE CASCADE;

--
-- Constraints for table `tarifapaseador`
--
ALTER TABLE `tarifapaseador`
  ADD CONSTRAINT `tarifapaseador_ibfk_1` FOREIGN KEY (`idPaseador`) REFERENCES `paseador` (`idPaseador`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
