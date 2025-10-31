-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2025
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
                           `latitud` decimal(10,8) DEFAULT NULL,
                           `longitud` decimal(11,8) DEFAULT NULL,
                           `email` varchar(255) NOT NULL,
                           `password` varchar(255) NOT NULL,
                           `nombre_usuario` varchar(50) NOT NULL,
                           `foto_perfil` varchar(255) DEFAULT NULL,
                           `cuenta_verificada` tinyint(1) DEFAULT 0,
                           `id_rol` int(11) NOT NULL,
                           `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
                           `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--
INSERT INTO `usuario` (`usuarioId`, `nombre_completo`, `anio_nacimiento`, `sexo`, `pais`, `ciudad`, `latitud`, `longitud`, `email`, `password`, `nombre_usuario`, `foto_perfil`, `cuenta_verificada`, `id_rol`, `fecha_registro`, `token`) VALUES
                                                                                                                                                                                                                                               (1, 'Ana Martinez', 1998, 'Femenino', 'Argentina', 'La Plata', NULL, NULL, 'ana.martinez@email.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Ana', 'imagenes/fotoPerfil.jpg', 1, 1, '2025-10-20 14:14:12', NULL),
                                                                                                                                                                                                                                               (2, 'Carlos Rodriguez', 1985, 'Masculino', 'Argentina', 'San Justo', NULL, NULL, 'carlos.editor@juego.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Carlos', 'imagenes/fotoPerfil.jpg', 1, 2, '2025-10-20 14:14:12', NULL),
                                                                                                                                                                                                                                               (3, 'Sofia Lopez', 1990, 'Prefiero no cargarlo', 'Argentina', 'Ramos Mejía', NULL, NULL, 'sofia.admin@juego.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Sofia', 'imagenes/fotoPerfil.jpg', 1, 3, '2025-10-20 14:14:12', NULL),
                                                                                                                                                                                                                                               (4, 'Admin', 1997, 'Masculino', 'Argentina', 'Buenos Aires', NULL, NULL, 'admin@example.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Admin97', 'imagenes/fotoPerfil.jpg', 1, 3, '2025-10-20 14:19:41', NULL);


-- --------------------------------------------------------

--
-- Tabla `partida`
--
CREATE TABLE `partida` (
                           `id_partida` int(11) NOT NULL,
                           `usuarioId` int(11) NOT NULL,
                           `puntos` int(11) NOT NULL DEFAULT 0,
                           `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabla `categoria`
--
CREATE TABLE `categoria` (
                             `id_categoria` int(11) NOT NULL,
                             `nombre` varchar(50) NOT NULL,
                             `color` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;