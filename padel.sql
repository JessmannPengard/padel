-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2023 a las 20:02:26
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
-- Estructura de tabla para la tabla `padel_horas`
--

CREATE TABLE `padel_horas` (
  `id` int(11) NOT NULL,
  `hora` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padel_pistas`
--

CREATE TABLE `padel_pistas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `url_imagen` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padel_reservas`
--

CREATE TABLE `padel_reservas` (
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padel_usuarios`
--

CREATE TABLE `padel_usuarios` (
  `id` int(11) NOT NULL,
  `num_socio` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `padel_horas`
--
ALTER TABLE `padel_horas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `padel_pistas`
--
ALTER TABLE `padel_pistas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `padel_reservas`
--
ALTER TABLE `padel_reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `padel_usuarios`
--
ALTER TABLE `padel_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `padel_horas`
--
ALTER TABLE `padel_horas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `padel_pistas`
--
ALTER TABLE `padel_pistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `padel_reservas`
--
ALTER TABLE `padel_reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `padel_usuarios`
--
ALTER TABLE `padel_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
