-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-03-2023 a las 16:02:37
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `padelpro`
--
CREATE DATABASE IF NOT EXISTS `padelpro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci;
USE `padelpro`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas`
--

CREATE TABLE `horas` (
  `id` int(11) NOT NULL,
  `hora` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `horas`
--

INSERT INTO `horas` (`id`, `hora`) VALUES
(1, '09:00 - 11:00'),
(2, '11:00 - 13:00'),
(3, '13:00 - 15:00'),
(4, '15:00 - 17:00'),
(5, '17:00 - 19:00'),
(6, '19:00 - 21:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pistas`
--

CREATE TABLE `pistas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `pistas`
--

INSERT INTO `pistas` (`id`, `nombre`) VALUES
(1, 'Pista roja'),
(2, 'Pista verde'),
(3, 'Pista azul'),
(4, 'PistaPRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pista` int(11) NOT NULL,
  `id_hora` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `j1` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `j2` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `j3` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `j4` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `id_usuario`, `id_pista`, `id_hora`, `fecha`, `j1`, `j2`, `j3`, `j4`) VALUES
(13, 1, 1, 3, '2023-03-15', 'Pepín', '', '', ''),
(14, 1, 1, 1, '2023-03-15', 'Pepín', '', '', ''),
(15, 1, 1, 3, '2023-03-14', 'p1', 'p2', 'p3', 'p4'),
(16, 1, 1, 4, '2023-03-14', 'p1', 'p2', 'p3', 'p4'),
(17, 1, 1, 2, '2023-03-15', 'Pepín', 'p2', 'p3', 'p4'),
(18, 1, 1, 2, '2023-03-14', 'Pepín', '', '', ''),
(19, 1, 1, 6, '2023-03-14', 'Pepín', 'p2', '', ''),
(20, 1, 4, 2, '2023-03-14', 'Pepín', 'p2', '', ''),
(21, 1, 4, 3, '2023-03-14', 'Pepín', 'p2', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `num_socio` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `num_socio`, `nombre`, `password`, `telefono`, `email`) VALUES
(1, '1234', 'Jessmann', '81dc9bdb52d04dc20036dbd8313ed055', '123456789', 'jessmann@jessmann.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `horas`
--
ALTER TABLE `horas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pistas`
--
ALTER TABLE `pistas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `horas`
--
ALTER TABLE `horas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pistas`
--
ALTER TABLE `pistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
