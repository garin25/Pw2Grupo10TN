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
                         `id_rol` int(11) NOT NULL AUTO_INCREMENT,
                         `nombre_rol` varchar(50) NOT NULL,
                         PRIMARY KEY (`id_rol`),
                         UNIQUE KEY `nombre_rol` (`nombre_rol`)
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
                           `usuarioId` int(11) NOT NULL AUTO_INCREMENT,
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
                           `token` varchar(255) DEFAULT NULL,
                           PRIMARY KEY (`usuarioId`),
                           UNIQUE KEY `email` (`email`),
                           UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
                           CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
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
                           `id_partida` int(11) NOT NULL AUTO_INCREMENT,
                           `usuarioId` int(11) NOT NULL,
                           `puntos` int(11) NOT NULL DEFAULT 0,
                           `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
                           PRIMARY KEY (`id_partida`),
                           CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`usuarioId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabla `categoria`
--
CREATE TABLE `categoria` (
                             `categoriaId` int(11) NOT NULL AUTO_INCREMENT,
                             `nombre` varchar(50) NOT NULL,
                             `color` varchar(7) DEFAULT NULL,
                             PRIMARY KEY (`categoriaId`),
                             UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--
INSERT INTO `categoria` (`categoriaId`, `nombre`, `color`) VALUES
                                                               (1, 'Deporte', '#FF3B30'),
                                                               (2, 'Historia', '#FFCC00'),
                                                               (3, 'Ciencias Naturales', '#34C759'),
                                                               (4, 'Geografía', '#007AFF'),
                                                               (5, 'Programación', '#FF9500'),
                                                               (6, 'Matemática', '#AF52DE');

-- --------------------------------------------------------

--
-- Tabla `pregunta`
--
CREATE TABLE `pregunta` (
                            `preguntaId` int(11) NOT NULL AUTO_INCREMENT,
                            `categoriaId` int(11) NOT NULL,
                            `enunciado` text NOT NULL,
                            `puntaje` int(11) NOT NULL DEFAULT 10,
                            `respondidasMal` int(11) DEFAULT NULL,
                            `cantidadEnviada` int(11) DEFAULT NULL,
                            PRIMARY KEY (`preguntaId`),
                            CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`categoriaId`) REFERENCES `categoria` (`categoriaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta` dificultad "Medio" por defecto (0.5)
--
INSERT INTO `pregunta` (`preguntaId`, `categoriaId`, `enunciado`, `puntaje`, `respondidasMal`, `cantidadEnviada`) VALUES
                                                                                                                      (NULL, 1, '¿Cuántos jugadores tiene un equipo de fútbol en el campo durante un partido?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿Qué país ganó la primera Copa del Mundo de fútbol en 1930?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿En qué deporte se considera a Michael Jordan como el mejor de todos los tiempos?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿Cada cuántos años se celebran los Juegos Olímpicos de Verano?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿Cómo se llama el trofeo que se entrega al ganador de la Copa Libertadores?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿En qué país se inventó el voleibol?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿Qué tenista tiene el récord de más títulos de Grand Slam en la categoría masculina?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿En qué año se celebraron los primeros Juegos Olímpicos modernos en Atenas?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿Qué es un "hat-trick" perfecto en el fútbol?', 10, 1, 2),
                                                                                                                      (NULL, 1, '¿Quién fue el primer piloto en ganar 7 campeonatos mundiales de Fórmula 1?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿Quién fue el primer hombre en pisar la Luna en 1969?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿En qué año comenzó la Primera Guerra Mundial?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿Qué civilización antigua construyó las pirámides de Giza?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿Qué tratado puso fin a la Primera Guerra Mundial?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿En qué ciudad fue asesinado el archiduque Francisco Fernando, evento que desencadenó la Primera Guerra Mundial?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿Qué civilización precolombina construyó la ciudad de Machu Picchu?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿Quién fue la última reina de Egipto?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿Cómo se llamó la operación militar del desembarco de Normandía durante la Segunda Guerra Mundial?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿Quién fue el líder de la facción bolchevique durante la Revolución Rusa?', 10, 1, 2),
                                                                                                                      (NULL, 2, '¿Qué imperio fue derrotado en la Batalla de Waterloo en 1815?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Cuál es el símbolo químico del agua?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Qué planeta de nuestro sistema solar es conocido como el "Planeta Rojo"?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Qué gas es esencial para la respiración de los seres humanos?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Cuál es el hueso más largo del cuerpo humano?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Cómo se llama el proceso por el cual las plantas producen su propio alimento usando la luz solar?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Cuántos corazones tiene un pulpo?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Cuál es el animal terrestre más grande del mundo?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Cuál es la velocidad aproximada de la luz en el vacío?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Qué orgánulo es conocido como la "central energética" de la célula?', 10, 1, 2),
                                                                                                                      (NULL, 3, '¿Qué científico propuso la teoría de la relatividad general?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿Cuál es el río más largo del mundo?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿En qué continente se encuentra Argentina?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿Cuál es la capital de Italia?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿Cuál es el desierto cálido más grande del mundo?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿Qué país tiene la mayor cantidad de islas en el mundo?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿En qué país se encuentra el Monte Everest, la montaña más alta del mundo?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿Cuál es el lago más profundo del mundo, ubicado en Siberia?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿Cuál es la capital de Australia?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿Qué es la Fosa de las Marianas?', 10, 1, 2),
                                                                                                                      (NULL, 4, '¿Qué dos países comparten la isla de La Española en el Caribe?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Qué significa la sigla HTML en desarrollo web?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Cuál de estos es un lenguaje de programación orientado a objetos: HTML, CSS o Java?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Qué símbolo se usa para comentarios de una sola línea en lenguajes como Java, C# y JavaScript?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Qué es una variable en programación?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Para qué se utiliza comúnmente el comando "git clone"?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Qué significa API?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿En qué paradigma de programación los objetos son la principal abstracción?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Qué es la recursividad en el contexto de la programación?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Cuál es la diferencia principal entre "==" y "===" en JavaScript?', 10, 1, 2),
                                                                                                                      (NULL, 5, '¿Qué patrón de diseño utiliza una interfaz para crear familias de objetos relacionados sin especificar sus clases concretas?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Cuánto es 9 multiplicado por 7?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Cómo se llama un polígono que tiene 5 lados?', 10, 1, 2),
                                                                                                                      (NULL, 6, 'Si tienes 30 manzanas y te comes la mitad, ¿cuántas te quedan?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Cuál es el valor del número Pi ($\pi$) redondeado a dos decimales?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Cuál es la raíz cuadrada de 144?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Cuánto suman los ángulos internos de cualquier triángulo?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Qué teorema establece que en un triángulo rectángulo, el cuadrado de la hipotenusa es igual a la suma de los cuadrados de los catetos?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Qué es un número primo?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Cuál es el resultado de 2 elevado a la potencia de 10 (2^10)?', 10, 1, 2),
                                                                                                                      (NULL, 6, '¿Qué es el factorial de 5 (representado como 5!)?', 10, 1, 2);
-- --------------------------------------------------------

--
-- Tabla `respuesta`
--
CREATE TABLE `respuesta` (
                             `id_respuesta` int(11) NOT NULL AUTO_INCREMENT,
                             `preguntaId` int(11) NOT NULL,
                             `respuestaTexto` text NOT NULL,
                             `esCorrecta` tinyint(1) NOT NULL DEFAULT 0,
                             PRIMARY KEY (`id_respuesta`),
                             CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`preguntaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--
INSERT INTO `respuesta` (`preguntaId`, `respuestaTexto`, `esCorrecta`) VALUES
                                                                           (1, '11', 1),
                                                                           (1, '9', 0),
                                                                           (1, '12', 0),
                                                                           (1, '10', 0),
                                                                           (2, 'Uruguay', 1),
                                                                           (2, 'Argentina', 0),
                                                                           (2, 'Brasil', 0),
                                                                           (2, 'Italia', 0),
                                                                           (3, 'Baloncesto', 1),
                                                                           (3, 'Béisbol', 0),
                                                                           (3, 'Fútbol Americano', 0),
                                                                           (3, 'Golf', 0),
                                                                           (4, '4', 1),
                                                                           (4, '2', 0),
                                                                           (4, '5', 0),
                                                                           (4, '6', 0),
                                                                           (5, 'Copa Libertadores de América', 1),
                                                                           (5, 'Copa del Rey', 0),
                                                                           (5, 'Champions League', 0),
                                                                           (5, 'Copa Sudamericana', 0),
                                                                           (6, 'Estados Unidos', 1),
                                                                           (6, 'Canadá', 0),
                                                                           (6, 'Brasil', 0),
                                                                           (6, 'Rusia', 0),
                                                                           (7, 'Novak Djokovic', 1),
                                                                           (7, 'Roger Federer', 0),
                                                                           (7, 'Rafael Nadal', 0),
                                                                           (7, 'Pete Sampras', 0),
                                                                           (8, '1896', 1),
                                                                           (8, '1900', 0),
                                                                           (8, '1888', 0),
                                                                           (8, '1924', 0),
                                                                           (9, 'Marcar un gol con la pierna derecha, uno con la izquierda y uno de cabeza', 1),
                                                                           (9, 'Marcar tres goles en un partido', 0),
                                                                           (9, 'Marcar tres goles en el primer tiempo', 0),
                                                                           (9, 'Marcar un gol en cada tiempo y uno en la prórroga', 0),
                                                                           (10, 'Michael Schumacher', 1),
                                                                           (10, 'Juan Manuel Fangio', 0),
                                                                           (10, 'Lewis Hamilton', 0),
                                                                           (10, 'Ayrton Senna', 0),
                                                                           (11, 'Neil Armstrong', 1),
                                                                           (11, 'Buzz Aldrin', 0),
                                                                           (11, 'Michael Collins', 0),
                                                                           (11, 'Yuri Gagarin', 0),
                                                                           (12, '1914', 1),
                                                                           (12, '1918', 0),
                                                                           (12, '1939', 0),
                                                                           (12, '1912', 0),
                                                                           (13, 'Egipcia', 1),
                                                                           (13, 'Romana', 0),
                                                                           (13, 'Griega', 0),
                                                                           (13, 'Maya', 0),
                                                                           (14, 'Tratado de Versalles', 1),
                                                                           (14, 'Tratado de Tordesillas', 0),
                                                                           (14, 'Tratado de Westfalia', 0),
                                                                           (14, 'Tratado de París', 0),
                                                                           (15, 'Sarajevo', 1),
                                                                           (15, 'Viena', 0),
                                                                           (15, 'Belgrado', 0),
                                                                           (15, 'Praga', 0),
                                                                           (16, 'Inca', 1),
                                                                           (16, 'Azteca', 0),
                                                                           (16, 'Maya', 0),
                                                                           (16, 'Olmeca', 0),
                                                                           (17, 'Cleopatra', 1),
                                                                           (17, 'Nefertiti', 0),
                                                                           (17, 'Hatshepsut', 0),
                                                                           (17, 'Nefertari', 0),
                                                                           (18, 'Operación Overlord', 1),
                                                                           (18, 'Operación Barbarroja', 0),
                                                                           (18, 'Operación Market Garden', 0),
                                                                           (18, 'Operación Torch', 0),
                                                                           (19, 'Vladimir Lenin', 1),
                                                                           (19, 'Iósif Stalin', 0),
                                                                           (19, 'León Trotski', 0),
                                                                           (19, 'Karl Marx', 0),
                                                                           (20, 'El Primer Imperio Francés', 1),
                                                                           (20, 'El Imperio Británico', 0),
                                                                           (20, 'El Imperio Ruso', 0),
                                                                           (20, 'El Imperio Austríaco', 0),
                                                                           (21, 'H₂O', 1),
                                                                           (21, 'CO₂', 0),
                                                                           (21, 'O₂', 0),
                                                                           (21, 'NaCl', 0),
                                                                           (22, 'Marte', 1),
                                                                           (22, 'Júpiter', 0),
                                                                           (22, 'Venus', 0),
                                                                           (22, 'Saturno', 0),
                                                                           (23, 'Oxígeno', 1),
                                                                           (23, 'Dióxido de carbono', 0),
                                                                           (23, 'Nitrógeno', 0),
                                                                           (23, 'Hidrógeno', 0),
                                                                           (24, 'Fémur', 1),
                                                                           (24, 'Húmero', 0),
                                                                           (24, 'Tibia', 0),
                                                                           (24, 'Cráneo', 0),
                                                                           (25, 'Fotosíntesis', 1),
                                                                           (25, 'Respiración celular', 0),
                                                                           (25, 'Mitosis', 0),
                                                                           (25, 'Ósmosis', 0),
                                                                           (26, '3', 1),
                                                                           (26, '1', 0),
                                                                           (26, '2', 0),
                                                                           (26, '8', 0),
                                                                           (27, 'Elefante africano', 1),
                                                                           (27, 'Jirafa', 0),
                                                                           (27, 'Rinoceronte blanco', 0),
                                                                           (27, 'Hipopótamo', 0),
                                                                           (28, '300,000 km/s', 1),
                                                                           (28, '150,000 km/s', 0),
                                                                           (28, '1,000,000 km/s', 0),
                                                                           (28, 'Es infinita', 0),
                                                                           (29, 'Mitocondria', 1),
                                                                           (29, 'Núcleo', 0),
                                                                           (29, 'Ribosoma', 0),
                                                                           (29, 'Aparato de Golgi', 0),
                                                                           (30, 'Albert Einstein', 1),
                                                                           (30, 'Isaac Newton', 0),
                                                                           (30, 'Galileo Galilei', 0),
                                                                           (30, 'Nikola Tesla', 0),
                                                                           (31, 'Amazonas', 1),
                                                                           (31, 'Nilo', 0),
                                                                           (31, 'Misisipi', 0),
                                                                           (31, 'Yangtsé', 0),
                                                                           (32, 'América del Sur', 1),
                                                                           (32, 'América del Norte', 0),
                                                                           (32, 'Europa', 0),
                                                                           (32, 'África', 0),
                                                                           (33, 'Roma', 1),
                                                                           (33, 'Milán', 0),
                                                                           (33, 'Venecia', 0),
                                                                           (33, 'Nápoles', 0),
                                                                           (34, 'El Sahara', 1),
                                                                           (34, 'El Gobi', 0),
                                                                           (34, 'El Kalahari', 0),
                                                                           (34, 'El de Arabia', 0),
                                                                           (35, 'Suecia', 1),
                                                                           (35, 'Indonesia', 0),
                                                                           (35, 'Finlandia', 0),
                                                                           (35, 'Canadá', 0),
                                                                           (36, 'Nepal', 1),
                                                                           (36, 'India', 0),
                                                                           (36, 'China', 0),
                                                                           (36, 'Bután', 0),
                                                                           (37, 'Lago Baikal', 1),
                                                                           (37, 'Lago Tanganica', 0),
                                                                           (37, 'Lago Superior', 0),
                                                                           (37, 'Mar Caspio', 0),
                                                                           (38, 'Canberra', 1),
                                                                           (38, 'Sídney', 0),
                                                                           (38, 'Melbourne', 0),
                                                                           (38, 'Perth', 0),
                                                                           (39, 'El punto más profundo de los océanos', 1),
                                                                           (39, 'Un volcán submarino activo', 0),
                                                                           (39, 'Una cordillera submarina', 0),
                                                                           (39, 'La fosa tectónica más larga', 0),
                                                                           (40, 'Haití y República Dominicana', 1),
                                                                           (40, 'Cuba y Jamaica', 0),
                                                                           (40, 'Puerto Rico y Haití', 0),
                                                                           (40, 'República Dominicana y Cuba', 0),
                                                                           (41, 'HyperText Markup Language', 1),
                                                                           (41, 'High-level Text Machine Language', 0),
                                                                           (41, 'Hyperlink and Text Markup Language', 0),
                                                                           (41, 'Home Tool Markup Language', 0),
                                                                           (42, 'Java', 1),
                                                                           (42, 'HTML', 0),
                                                                           (42, 'CSS', 0),
                                                                           (42, 'SQL', 0),
                                                                           (43, '//', 1),
                                                                           (43, '/* */', 0),
                                                                           (43, '', 0),
                                                                           (43, '#', 0),
                                                                           (44, 'Un espacio en memoria para almacenar un valor que puede cambiar', 1),
                                                                           (44, 'Una función que no devuelve nada', 0),
                                                                           (44, 'Una constante que nunca cambia', 0),
                                                                           (44, 'Un tipo de dato exclusivamente numérico', 0),
                                                                           (45, 'Para copiar un repositorio remoto a tu máquina local', 1),
                                                                           (45, 'Para crear una nueva rama', 0),
                                                                           (45, 'Para fusionar dos ramas', 0),
                                                                           (45, 'Para subir cambios a un repositorio', 0),
                                                                           (46, 'Application Programming Interface', 1),
                                                                           (46, 'Advanced Program Interaction', 0),
                                                                           (46, 'Automated Programming Input', 0),
                                                                           (46, 'Application Process Integration', 0),
                                                                           (47, 'Programación Orientada a Objetos', 1),
                                                                           (47, 'Programación Funcional', 0),
                                                                           (47, 'Programación Procedural', 0),
                                                                           (47, 'Programación Lógica', 0),
                                                                           (48, 'Una función que se llama a sí misma para resolver un problema', 1),
                                                                           (48, 'Un bucle que se ejecuta infinitamente', 0),
                                                                           (48, 'Un objeto que hereda de varias clases', 0),
                                                                           (48, 'Una variable que puede contener múltiples tipos de datos', 0),
                                                                           (49, '`===` compara valor y tipo, `==` solo valor (con coerción de tipo)', 1),
                                                                           (49, '`===` es para objetos y `==` para tipos primitivos', 0),
                                                                           (49, '`===` es una versión más rápida de `==`', 0),
                                                                           (49, 'No hay ninguna diferencia, son intercambiables', 0),
                                                                           (50, 'Abstract Factory', 1),
                                                                           (50, 'Singleton', 0),
                                                                           (50, 'Observer', 0),
                                                                           (50, 'Decorator', 0),
                                                                           (51, '63', 1),
                                                                           (51, '56', 0),
                                                                           (51, '64', 0),
                                                                           (51, '72', 0),
                                                                           (52, 'Pentágono', 1),
                                                                           (52, 'Hexágono', 0),
                                                                           (52, 'Heptágono', 0),
                                                                           (52, 'Cuadrado', 0),
                                                                           (53, '15', 1),
                                                                           (53, '10', 0),
                                                                           (53, '20', 0),
                                                                           (53, 'La mitad de las manzanas', 0),
                                                                           (54, '3.14', 1),
                                                                           (54, '3.16', 0),
                                                                           (54, '2.71', 0),
                                                                           (54, '1.61', 0),
                                                                           (55, '12', 1),
                                                                           (55, '11', 0),
                                                                           (55, '13', 0),
                                                                           (55, '14', 0),
                                                                           (56, '180°', 1),
                                                                           (56, '90°', 0),
                                                                           (56, '270°', 0),
                                                                           (56, '360°', 0),
                                                                           (57, 'Teorema de Pitágoras', 1),
                                                                           (57, 'Teorema de Tales', 0),
                                                                           (57, 'Teorema de Euclides', 0),
                                                                           (57, 'Último teorema de Fermat', 0),
                                                                           (58, 'Un número natural > 1 que solo es divisible por sí mismo y por 1', 1),
                                                                           (58, 'Un número que es impar', 0),
                                                                           (58, 'Un número que es divisible por 2', 0),
                                                                           (58, 'Un número que no tiene raíz cuadrada exacta', 0),
                                                                           (59, '1024', 1),
                                                                           (59, '1000', 0),
                                                                           (59, '2048', 0),
                                                                           (59, '512', 0),
                                                                           (60, '120', 1),
                                                                           (60, '25', 0),
                                                                           (60, '60', 0),
                                                                           (60, '100', 0);

-- --------------------------------------------------------

--
-- Tabla `historial_respuestas`
--
CREATE TABLE `historial_respuestas` (
                                        `id_historial` int(11) NOT NULL AUTO_INCREMENT,
                                        `usuarioId` int(11) NOT NULL,
                                        `preguntaId` int(11) NOT NULL,
                                        `fue_correcta` tinyint(1) NOT NULL,
                                        `fecha_respuesta` timestamp NOT NULL DEFAULT current_timestamp(),
                                        PRIMARY KEY (`id_historial`),
                                        CONSTRAINT `historial_respuestas_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`usuarioId`),
                                        CONSTRAINT `historial_respuestas_ibfk_2` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`preguntaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- PREGUNTAS DIFICILES

-- Categoría 1 (Deporte): ID 1
UPDATE `pregunta`
SET `respondidasMal` = 3, `cantidadEnviada` = 4
WHERE `preguntaId` = 1;

-- Categoría 2 (Historia): ID 11
UPDATE `pregunta`
SET `respondidasMal` = 3, `cantidadEnviada` = 4
WHERE `preguntaId` = 11;

-- Categoría 3 (Ciencias Naturales): ID 21
UPDATE `pregunta`
SET `respondidasMal` = 3, `cantidadEnviada` = 4
WHERE `preguntaId` = 21;

-- Categoría 4 (Geografía): ID 31
UPDATE `pregunta`
SET `respondidasMal` = 3, `cantidadEnviada` = 4
WHERE `preguntaId` = 31;

-- Categoría 5 (Programación): ID 41
UPDATE `pregunta`
SET `respondidasMal` = 3, `cantidadEnviada` = 4
WHERE `preguntaId` = 41;

-- Categoría 6 (Matemática): ID 51
UPDATE `pregunta`
SET `respondidasMal` = 3, `cantidadEnviada` = 4
WHERE `preguntaId` = 51;

-- (Se insertan 4 registros por cada pregunta: 3 mal, 1 bien. Todos del usuarioId 1)

INSERT INTO `historial_respuestas` (`usuarioId`, `preguntaId`, `fue_correcta`) VALUES
-- Historial para Pregunta 1 (Deporte)
(1, 1, 0), -- Mal
(1, 1, 0), -- Mal
(1, 1, 0), -- Mal
(1, 1, 1), -- Bien

-- Historial para Pregunta 11 (Historia)
(1, 11, 0), -- Mal
(1, 11, 0), -- Mal
(1, 11, 1), -- Bien
(1, 11, 0), -- Mal

-- Historial para Pregunta 21 (Ciencias Naturales)
(1, 21, 1), -- Bien
(1, 21, 0), -- Mal
(1, 21, 0), -- Mal
(1, 21, 0), -- Mal

-- Historial para Pregunta 31 (Geografía)
(1, 31, 0), -- Mal
(1, 31, 1), -- Bien
(1, 31, 0), -- Mal
(1, 31, 0), -- Mal

-- Historial para Pregunta 41 (Programación)
(1, 41, 0), -- Mal
(1, 41, 0), -- Mal
(1, 41, 0), -- Mal
(1, 41, 1), -- Bien

-- Historial para Pregunta 51 (Matemática)
(1, 51, 0), -- Mal
(1, 51, 1), -- Bien
(1, 51, 0), -- Mal
(1, 51, 0); -- Mal

COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;