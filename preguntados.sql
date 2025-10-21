-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-10-2025 a las 16:22:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS preguntados;
USE preguntados;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `preguntados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(3, 'Administrador'),
(2, 'Editor'),
(1, 'Jugador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuarioId` int(11) NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `anio_nacimiento` int(11) NOT NULL,
  `sexo` enum('Masculino','Femenino','Prefiero no cargarlo') NOT NULL,
  `pais` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `cuenta_verificada` tinyint(1) DEFAULT 0,
  `puntaje_total` int(11) DEFAULT 0,
  `id_rol` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuarioId`, `nombre_completo`, `anio_nacimiento`, `sexo`, `pais`, `ciudad`, `email`, `password`, `nombre_usuario`, `foto_perfil`, `cuenta_verificada`, `puntaje_total`, `id_rol`, `fecha_registro`, `token`) VALUES
(1, 'Ana Martinez', 1998, 'Femenino', 'Argentina', 'La Plata', 'ana.martinez@email.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Ana', 'imagenes/fotoPerfil.jpg', 1, 1250, 1, '2025-10-20 14:14:12', NULL),
(2, 'Carlos Rodriguez', 1985, 'Masculino', 'Argentina', 'San Justo', 'carlos.editor@juego.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Carlos', 'imagenes/fotoPerfil.jpg', 1, 0, 2, '2025-10-20 14:14:12', NULL),
(3, 'Sofia Lopez', 1990, 'Prefiero no cargarlo', 'Argentina', 'Ramos Mejía', 'sofia.admin@juego.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Sofia', 'imagenes/fotoPerfil.jpg', 1, 0, 3, '2025-10-20 14:14:12', NULL),
(4, 'Admin', 1997, 'Masculino', 'Argentina', 'Buenos Aires', 'admin@example.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Admin97', 'imagenes/fotoPerfil.jpg', 1, 0, 3, '2025-10-20 14:19:41', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuarioId`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuarioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
