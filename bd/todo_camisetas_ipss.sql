-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2025 a las 02:32:35
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `todo_camisetas_ipss`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camisetas`
--

CREATE TABLE `camisetas` (
  `codProducto` varchar(50) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `club` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `precio` int(11) NOT NULL,
  `detalles` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camisetas`
--

INSERT INTO `camisetas` (`codProducto`, `titulo`, `club`, `pais`, `tipo`, `color`, `precio`, `detalles`) VALUES
('COL2025L', 'Camiseta Colombia Local 2025', 'Selección Colombiana', 'Colombia', 'Local', 'Amarillo', 45000, 'Oficial de colección'),
('COL2025V', 'Camiseta Colombia Visita 2025', 'Selección Colombiana', 'Colombia', 'Visita', 'Azul', 44000, 'Oficial de colección 2'),
('SCL2025L', 'Camiseta Local 2025 – Selección Chilena', 'Selección Chilena', 'Chile', 'Local', 'Rojo y Azul', 45000, 'Edición aniversario 2025'),
('SCL2025V', 'Camiseta Chile Visita 2025', 'Selección Chile', 'Chile', 'Visita', 'Azul y Rojo', 42000, 'Oficial de colección');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camiseta_talla`
--

CREATE TABLE `camiseta_talla` (
  `camiseta_id` varchar(50) NOT NULL,
  `talla_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camiseta_talla`
--

INSERT INTO `camiseta_talla` (`camiseta_id`, `talla_id`) VALUES
('COL2025L', 2),
('COL2025L', 15),
('SCL2025L', 1),
('SCL2025L', 2),
('SCL2025L', 3),
('SCL2025L', 15),
('SCL2025V', 1),
('SCL2025V', 2),
('SCL2025V', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre_comercial` varchar(150) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `categoria` enum('Regular','Preferencial') DEFAULT 'Regular',
  `contacto_nombre` varchar(100) DEFAULT NULL,
  `contacto_email` varchar(100) DEFAULT NULL,
  `porcentaje_descuento` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre_comercial`, `rut`, `direccion`, `categoria`, `contacto_nombre`, `contacto_email`, `porcentaje_descuento`) VALUES
(1, '90minutos', '76.543.210-1', 'Providencia, Santiago', 'Preferencial', 'María López', 'compras@90minutos.cl', 15.00),
(3, 'tdeportes', '67.890.123-4', 'Pudahuel, Santiago', 'Regular', 'Alvaro Diaz', 'adiaz@tdeportes.cl', 5.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `idTalla` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`idTalla`, `nombre`) VALUES
(3, 'L'),
(2, 'M'),
(1, 'S'),
(4, 'XL'),
(15, 'XS'),
(17, 'XXXL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `camisetas`
--
ALTER TABLE `camisetas`
  ADD PRIMARY KEY (`codProducto`);

--
-- Indices de la tabla `camiseta_talla`
--
ALTER TABLE `camiseta_talla`
  ADD PRIMARY KEY (`camiseta_id`,`talla_id`),
  ADD KEY `talla_id` (`talla_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`idTalla`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `idTalla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `camiseta_talla`
--
ALTER TABLE `camiseta_talla`
  ADD CONSTRAINT `camiseta_talla_ibfk_1` FOREIGN KEY (`camiseta_id`) REFERENCES `camisetas` (`codProducto`) ON DELETE CASCADE,
  ADD CONSTRAINT `camiseta_talla_ibfk_2` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`idTalla`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
