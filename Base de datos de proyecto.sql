-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2026 a las 00:05:14
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
-- Base de datos: `tienda_armas`
--
DROP DATABASE IF EXISTS `tienda_armas`;
CREATE DATABASE IF NOT EXISTS `tienda_armas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tienda_armas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `armas`
--

DROP TABLE IF EXISTS `armas`;
CREATE TABLE `armas` (
  `id_arma` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `categoria` enum('Pistola','Rifle','Escopeta','Subfusil','Ametralladora') NOT NULL,
  `mecanismo_disparo` enum('Automatica','Semiautomatica','Manual') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `armas`
--

INSERT INTO `armas` (`id_arma`, `nombre`, `marca`, `categoria`, `mecanismo_disparo`, `descripcion`, `precio`, `stock`, `imagen`) VALUES
(1, 'Glock 17', 'Glock', 'Pistola', 'Semiautomatica', 'Pistola calibre 9mm', 1200.00, 10, 'glock17.jpg'),
(2, 'AK-47', 'Kalashnikov', 'Rifle', 'Automatica', 'Rifle automatico', 2500.00, 5, 'ak47.jpg'),
(3, 'Remington 870', 'Remington', 'Escopeta', 'Manual', 'Escopeta de accion manual', 1800.00, 7, 'rem870.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

DROP TABLE IF EXISTS `carrito`;
CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_usuario`, `fecha_creacion`) VALUES
(1, 2, '2026-05-08 18:47:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_detalle`
--

DROP TABLE IF EXISTS `carrito_detalle`;
CREATE TABLE `carrito_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_carrito` int(11) DEFAULT NULL,
  `id_arma` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito_detalle`
--

INSERT INTO `carrito_detalle` (`id_detalle`, `id_carrito`, `id_arma`, `cantidad`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pago`
--

DROP TABLE IF EXISTS `detalle_pago`;
CREATE TABLE `detalle_pago` (
  `id_detalle_pago` int(11) NOT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `id_arma` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pago`
--

INSERT INTO `detalle_pago` (`id_detalle_pago`, `id_pago`, `id_arma`, `cantidad`, `subtotal`) VALUES
(1, 1, 1, 2, 2400.00),
(2, 1, 2, 1, 2500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `estado` enum('pendiente','pagado','cancelado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_usuario`, `fecha_pago`, `total`, `metodo_pago`, `estado`) VALUES
(1, 2, '2026-05-08 18:47:16', 4900.00, 'Tarjeta', 'pagado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('administrador','cliente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `contraseña`, `rol`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$b.hOJeJXu1i7v7sgQxLlLOTSVVaCECnumse49h59oh9T7GOOqpbPK', 'administrador'),
(2, 'Juan Perez', 'juan@gmail.com', 'abcd', 'cliente'),
(3, 'Jose fina', 'Josefina@gmail.com', '$2y$10$qi91H2mRksT8JbWudUaOJ.Ctn/gAlLCCwiMCHX9DrRr.r/p4J9vbi', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`id_arma`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_carrito` (`id_carrito`),
  ADD KEY `id_arma` (`id_arma`);

--
-- Indices de la tabla `detalle_pago`
--
ALTER TABLE `detalle_pago`
  ADD PRIMARY KEY (`id_detalle_pago`),
  ADD KEY `id_pago` (`id_pago`),
  ADD KEY `id_arma` (`id_arma`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `armas`
--
ALTER TABLE `armas`
  MODIFY `id_arma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_pago`
--
ALTER TABLE `detalle_pago`
  MODIFY `id_detalle_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  ADD CONSTRAINT `carrito_detalle_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`),
  ADD CONSTRAINT `carrito_detalle_ibfk_2` FOREIGN KEY (`id_arma`) REFERENCES `armas` (`id_arma`);

--
-- Filtros para la tabla `detalle_pago`
--
ALTER TABLE `detalle_pago`
  ADD CONSTRAINT `detalle_pago_ibfk_1` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`),
  ADD CONSTRAINT `detalle_pago_ibfk_2` FOREIGN KEY (`id_arma`) REFERENCES `armas` (`id_arma`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

--consulta
INSERT INTO armas (
    nombre,
    marca,
    categoria,
    mecanismo_disparo,
    descripcion,
    precio,
    stock,
    imagen
)
VALUES
(
    'Beretta M9',
    'Beretta',
    'Pistola',
    'Semiautomatica',
    'Pistola militar italiana calibre 9mm',
    1350.00,
    12,
    'beretta_m9.jpg'
),
(
    'Colt M1911',
    'Colt',
    'Pistola',
    'Semiautomatica',
    'Pistola clasica calibre .45',
    1500.00,
    8,
    'colt_1911.jpg'
),
(
    'M4A1',
    'Colt',
    'Rifle',
    'Automatica',
    'Rifle de asalto militar',
    3200.00,
    4,
    'm4a1.jpg'
),
(
    'FN SCAR',
    'FN Herstal',
    'Rifle',
    'Semiautomatica',
    'Rifle tactico moderno',
    4100.00,
    3,
    'scar.jpg'
),
(
    'MP5',
    'Heckler & Koch',
    'Subfusil',
    'Automatica',
    'Subfusil compacto aleman',
    2900.00,
    6,
    'mp5.jpg'
),
(
    'Uzi',
    'IMI',
    'Subfusil',
    'Automatica',
    'Subfusil israeli',
    2600.00,
    5,
    'uzi.jpg'
),
(
    'M249',
    'FN Herstal',
    'Ametralladora',
    'Automatica',
    'Ametralladora ligera militar',
    6800.00,
    2,
    'm249.jpg'
),
(
    'PKM',
    'Kalashnikov',
    'Ametralladora',
    'Automatica',
    'Ametralladora media sovietica',
    7200.00,
    2,
    'pkm.jpg'
),
(
    'Mossberg 500',
    'Mossberg',
    'Escopeta',
    'Manual',
    'Escopeta de corredera',
    1900.00,
    9,
    'mossberg500.jpg'
),
(
    'SPAS-12',
    'Franchi',
    'Escopeta',
    'Semiautomatica',
    'Escopeta tactica italiana',
    3400.00,
    3,
    'spas12.jpg'
);
