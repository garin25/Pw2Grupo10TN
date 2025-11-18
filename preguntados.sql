-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2025 a las 16:47:16
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
-- Base de datos: `preguntados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoriaId` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `color` varchar(7) DEFAULT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoriaId`, `nombre`, `color`, `ruta_imagen`) VALUES
    (1, 'Deporte', '#FF3B30', '/imagenes/deporte.png'),
    (2, 'Historia', '#FFCC00', '/imagenes/historia.png'),
    (3, 'Ciencias Naturales', '#34C759', '/imagenes/cienciasNaturales.png'),
    (4, 'Geografía', '#007AFF', '/imagenes/geografia.png'),
    (5, 'Programación', '#FF9500', '/imagenes/programacion.png'),
    (6, 'Matemática', '#AF52DE', '/imagenes/matematica.png');
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_respuestas`
--

CREATE TABLE `historial_respuestas` (
  `id_historial` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `preguntaId` int(11) NOT NULL,
  `fue_correcta` tinyint(1) NOT NULL,
  `fecha_respuesta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_respuestas`
--

INSERT INTO `historial_respuestas` (`id_historial`, `usuarioId`, `preguntaId`, `fue_correcta`, `fecha_respuesta`) VALUES
(1, 4, 40, 0, '2025-11-04 18:01:23'),
(2, 4, 85, 0, '2025-11-04 18:03:41'),
(3, 4, 13, 0, '2025-11-04 18:04:01'),
(4, 4, 31, 1, '2025-11-04 18:17:28'),
(5, 4, 3, 1, '2025-11-04 18:18:01'),
(6, 4, 6, 0, '2025-11-04 18:18:44'),
(7, 4, 13, 1, '2025-11-05 03:53:51'),
(8, 4, 40, 0, '2025-11-05 03:54:18'),
(9, 4, 105, 1, '2025-11-07 18:19:15'),
(10, 4, 54, 1, '2025-11-07 18:19:35'),
(11, 4, 127, 0, '2025-11-07 18:20:00'),
(12, 4, 30, 0, '2025-11-07 18:20:54'),
(13, 4, 170, 0, '2025-11-07 18:25:44'),
(14, 4, 156, 0, '2025-11-07 18:28:47'),
(15, 4, 57, 0, '2025-11-07 18:29:49'),
(16, 4, 132, 0, '2025-11-07 18:30:43'),
(17, 4, 133, 0, '2025-11-07 18:31:40'),
(18, 4, 158, 1, '2025-11-07 18:33:38'),
(19, 4, 4, 0, '2025-11-07 18:33:51'),
(20, 4, 153, 0, '2025-11-07 18:36:19'),
(21, 4, 26, 0, '2025-11-07 18:40:08'),
(22, 4, 34, 0, '2025-11-07 18:41:45'),
(23, 4, 18, 1, '2025-11-07 18:44:13'),
(24, 4, 36, 0, '2025-11-07 18:44:26'),
(25, 4, 2, 0, '2025-11-07 18:46:44'),
(26, 4, 138, 0, '2025-11-07 18:55:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id_partida` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `puntos` int(11) NOT NULL DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id_partida`, `usuarioId`, `puntos`, `fecha`) VALUES
(1, 4, 0, '2025-11-01 02:36:03'),
(2, 4, 0, '2025-11-01 02:40:40'),
(3, 4, 0, '2025-11-01 02:40:59'),
(4, 4, 0, '2025-11-01 02:44:54'),
(5, 4, 0, '2025-11-01 02:51:49'),
(6, 4, 0, '2025-11-01 02:52:27'),
(7, 4, 0, '2025-11-01 02:58:59'),
(8, 4, 0, '2025-11-01 02:59:11'),
(9, 4, 0, '2025-11-01 02:59:26'),
(10, 4, 0, '2025-11-01 02:59:38'),
(11, 4, 0, '2025-11-01 03:04:25'),
(12, 4, 0, '2025-11-01 03:05:24'),
(13, 4, 0, '2025-11-01 03:06:36'),
(14, 4, 0, '2025-11-01 03:07:57'),
(15, 4, 0, '2025-11-01 03:07:58'),
(16, 4, 10, '2025-11-01 03:08:22'),
(17, 4, 40, '2025-11-01 03:11:08'),
(18, 4, 0, '2025-11-01 04:24:03'),
(19, 4, 10, '2025-11-01 19:11:56'),
(20, 4, 10, '2025-11-02 00:28:14'),
(21, 4, 10, '2025-11-02 00:43:06'),
(22, 4, 0, '2025-11-02 01:45:06'),
(23, 4, 10, '2025-11-02 01:46:02'),
(24, 4, 0, '2025-11-02 01:46:28'),
(25, 4, 0, '2025-11-02 01:47:42'),
(26, 4, 10, '2025-11-02 01:50:00'),
(27, 4, 0, '2025-11-02 01:52:28'),
(28, 4, 10, '2025-11-02 01:55:06'),
(29, 4, 20, '2025-11-02 01:56:42'),
(30, 4, 10, '2025-11-02 01:58:52'),
(31, 4, 0, '2025-11-02 02:25:12'),
(32, 4, 0, '2025-11-02 02:28:44'),
(33, 4, 0, '2025-11-02 02:30:00'),
(34, 4, 10, '2025-11-02 02:33:05'),
(35, 4, 0, '2025-11-02 02:37:51'),
(36, 4, 0, '2025-11-02 02:39:51'),
(37, 4, 0, '2025-11-02 03:04:04'),
(38, 4, 0, '2025-11-02 03:09:09'),
(39, 4, 0, '2025-11-02 03:49:33'),
(40, 4, 0, '2025-11-02 03:51:36'),
(41, 4, 20, '2025-11-02 04:22:01'),
(42, 4, 0, '2025-11-02 17:38:47'),
(43, 4, 0, '2025-11-02 17:43:00'),
(44, 4, 0, '2025-11-02 17:46:16'),
(45, 4, 0, '2025-11-02 17:49:54'),
(46, 4, 20, '2025-11-02 17:51:32'),
(47, 2, 20, '2025-11-02 18:58:54'),
(48, 2, 40, '2025-11-02 19:12:22'),
(49, 2, 60, '2025-11-02 19:14:14'),
(50, 4, 0, '2025-11-04 16:41:11'),
(51, 4, 0, '2025-11-04 16:43:10'),
(52, 4, 0, '2025-11-04 18:01:23'),
(53, 4, 10, '2025-11-04 18:03:41'),
(54, 4, 0, '2025-11-04 18:04:01'),
(55, 4, 20, '2025-11-04 18:18:44'),
(56, 4, 10, '2025-11-05 03:54:18'),
(57, 4, 20, '2025-11-07 18:20:00'),
(58, 4, 0, '2025-11-07 18:20:54'),
(59, 4, 0, '2025-11-07 18:25:44'),
(60, 4, 0, '2025-11-07 18:28:47'),
(61, 4, 0, '2025-11-07 18:29:49'),
(62, 4, 0, '2025-11-07 18:30:43'),
(63, 4, 0, '2025-11-07 18:31:40'),
(64, 4, 10, '2025-11-07 18:33:51'),
(65, 4, 0, '2025-11-07 18:36:19'),
(66, 4, 0, '2025-11-07 18:40:08'),
(67, 4, 0, '2025-11-07 18:41:45'),
(68, 4, 10, '2025-11-07 18:44:26'),
(69, 4, 0, '2025-11-07 18:46:44'),
(70, 4, 0, '2025-11-07 18:55:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `preguntaId` int(11) NOT NULL,
  `categoriaId` int(11) NOT NULL,
  `enunciado` text NOT NULL,
  `puntaje` int(11) NOT NULL DEFAULT 10,
  `respondidasMal` int(11) NOT NULL DEFAULT 1,
  `cantidadEnviada` int(11) NOT NULL DEFAULT 2,
  `esReportada` tinyint(1) NOT NULL DEFAULT 0,
  `esSugerida` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`preguntaId`, `categoriaId`, `enunciado`, `puntaje`, `respondidasMal`, `cantidadEnviada`, `esReportada`, `esSugerida`) VALUES
(1, 1, '¿Cuántos jugadores tiene un equipo de fútbol en el campo durante un partido?', 10, 1, 2, 0, 0),
(2, 1, '¿Qué país ganó la primera Copa del Mundo de fútbol en 1930?', 10, 2, 3, 0, 0),
(3, 1, '¿En qué deporte se considera a Michael Jordan como el mejor de todos los tiempos?', 10, 1, 3, 0, 0),
(4, 1, '¿Cada cuántos años se celebran los Juegos Olímpicos de Verano?', 10, 2, 3, 0, 0),
(5, 1, '¿Cómo se llama el trofeo que se entrega al ganador de la Copa Libertadores?', 10, 1, 2, 0, 0),
(6, 1, '¿En qué país se inventó el voleibol?', 10, 2, 3, 0, 0),
(7, 1, '¿Qué tenista tiene el récord de más títulos de Grand Slam en la categoría masculina?', 10, 1, 2, 0, 0),
(8, 1, '¿En qué año se celebraron los primeros Juegos Olímpicos modernos en Atenas?', 10, 1, 2, 0, 0),
(9, 1, '¿Qué es un \"hat-trick\" perfecto en el fútbol?', 10, 1, 2, 0, 0),
(10, 1, '¿Quién fue el primer piloto en ganar 7 campeonatos mundiales de Fórmula 1?', 10, 1, 2, 0, 0),
(11, 2, '¿Quién fue el primer hombre en pisar la Luna en 1969?', 10, 1, 2, 0, 0),
(12, 2, '¿En qué año comenzó la Primera Guerra Mundial?', 10, 1, 2, 0, 0),
(13, 2, '¿Qué civilización antigua construyó las pirámides de Giza?', 10, 2, 4, 0, 0),
(14, 2, '¿Qué tratado puso fin a la Primera Guerra Mundial?', 10, 1, 2, 0, 0),
(15, 2, '¿En qué ciudad fue asesinado el archiduque Francisco Fernando, evento que desencadenó la Primera Guerra Mundial?', 10, 1, 2, 0, 0),
(16, 2, '¿Qué civilización precolombina construyó la ciudad de Machu Picchu?', 10, 1, 2, 0, 0),
(17, 2, '¿Quién fue la última reina de Egipto?', 10, 1, 2, 0, 0),
(18, 2, '¿Cómo se llamó la operación militar del desembarco de Normandía durante la Segunda Guerra Mundial?', 10, 1, 3, 0, 0),
(19, 2, '¿Quién fue el líder de la facción bolchevique durante la Revolución Rusa?', 10, 1, 2, 0, 0),
(20, 2, '¿Qué imperio fue derrotado en la Batalla de Waterloo en 1815?', 10, 1, 2, 0, 0),
(21, 3, '¿Cuál es el símbolo químico del agua?', 10, 1, 2, 0, 0),
(22, 3, '¿Qué planeta de nuestro sistema solar es conocido como el \"Planeta Rojo\"?', 10, 1, 2, 0, 0),
(23, 3, '¿Qué gas es esencial para la respiración de los seres humanos?', 10, 1, 2, 0, 0),
(24, 3, '¿Cuál es el hueso más largo del cuerpo humano?', 10, 1, 2, 0, 0),
(25, 3, '¿Cómo se llama el proceso por el cual las plantas producen su propio alimento usando la luz solar?', 10, 1, 2, 0, 0),
(26, 3, '¿Cuántos corazones tiene un pulpo?', 10, 2, 3, 0, 0),
(27, 3, '¿Cuál es el animal terrestre más grande del mundo?', 10, 1, 2, 0, 0),
(28, 3, '¿Cuál es la velocidad aproximada de la luz en el vacío?', 10, 1, 2, 0, 0),
(29, 3, '¿Qué orgánulo es conocido como la \"central energética\" de la célula?', 10, 1, 2, 0, 0),
(30, 3, '¿Qué científico propuso la teoría de la relatividad general?', 10, 2, 3, 0, 0),
(31, 4, '¿Cuál es el río más largo del mundo?', 10, 1, 3, 0, 0),
(32, 4, '¿En qué continente se encuentra Argentina?', 10, 1, 2, 0, 0),
(33, 4, '¿Cuál es la capital de Italia?', 10, 1, 2, 0, 0),
(34, 4, '¿Cuál es el desierto cálido más grande del mundo?', 10, 2, 3, 0, 0),
(35, 4, '¿Qué país tiene la mayor cantidad de islas en el mundo?', 10, 1, 2, 0, 0),
(36, 4, '¿En qué país se encuentra el Monte Everest, la montaña más alta del mundo?', 10, 2, 3, 0, 0),
(37, 4, '¿Cuál es el lago más profundo del mundo, ubicado en Siberia?', 10, 1, 2, 0, 0),
(38, 4, '¿Cuál es la capital de Australia?', 10, 1, 2, 0, 0),
(39, 4, '¿Qué es la Fosa de las Marianas?', 10, 1, 2, 0, 0),
(40, 4, '¿Qué dos países comparten la isla de La Española en el Caribe?', 10, 3, 4, 0, 0),
(41, 5, '¿Qué significa la sigla HTML en desarrollo web?', 10, 1, 2, 0, 0),
(42, 5, '¿Cuál de estos es un lenguaje de programación orientado a objetos: HTML, CSS o Java?', 10, 1, 2, 0, 0),
(43, 5, '¿Qué símbolo se usa para comentarios de una sola línea en lenguajes como Java, C# y JavaScript?', 10, 1, 2, 0, 0),
(44, 5, '¿Qué es una variable en programación?', 10, 1, 2, 0, 0),
(45, 5, '¿Para qué se utiliza comúnmente el comando \"git clone\"?', 10, 1, 2, 0, 0),
(46, 5, '¿Qué significa API?', 10, 1, 2, 0, 0),
(47, 5, '¿En qué paradigma de programación los objetos son la principal abstracción?', 10, 1, 2, 0, 0),
(48, 5, '¿Qué es la recursividad en el contexto de la programación?', 10, 1, 2, 0, 0),
(49, 5, '¿Cuál es la diferencia principal entre \"==\" y \"===\" en JavaScript?', 10, 1, 2, 0, 0),
(50, 5, '¿Qué patrón de diseño utiliza una interfaz para crear familias de objetos relacionados sin especificar sus clases concretas?', 10, 1, 2, 0, 0),
(51, 6, '¿Cuánto es 9 multiplicado por 7?', 10, 1, 2, 0, 0),
(52, 6, '¿Cómo se llama un polígono que tiene 5 lados?', 10, 1, 2, 0, 0),
(53, 6, 'Si tienes 30 manzanas y te comes la mitad, ¿cuántas te quedan?', 10, 1, 2, 0, 0),
(54, 6, '¿Cuál es el valor del número Pi ($pi$) redondeado a dos decimales?', 10, 1, 3, 0, 0),
(55, 6, '¿Cuál es la raíz cuadrada de 144?', 10, 1, 2, 0, 0),
(56, 6, '¿Cuánto suman los ángulos internos de cualquier triángulo?', 10, 1, 2, 0, 0),
(57, 6, '¿Qué teorema establece que en un triángulo rectángulo, el cuadrado de la hipotenusa es igual a la suma de los cuadrados de los catetos?', 10, 2, 3, 0, 0),
(58, 6, '¿Qué es un número primo?', 10, 1, 2, 0, 0),
(59, 6, '¿Cuál es el resultado de 2 elevado a la potencia de 10 (2^10)?', 10, 1, 2, 0, 0),
(60, 6, '¿Qué es el factorial de 5 (representado como 5!)?', 10, 1, 2, 0, 0),
(61, 1, '¿En qué deporte se utiliza el término \"ace\"?', 10, 5, 20, 0, 0),
(62, 2, '¿Quién fue el primer emperador romano?', 10, 2, 15, 0, 0),
(63, 3, '¿Cuál es la fórmula química del agua?', 10, 10, 30, 0, 0),
(64, 4, '¿Cuál es el río más largo del mundo?', 10, 1, 12, 0, 0),
(65, 5, '¿Qué significa el acrónimo SQL?', 10, 8, 25, 0, 0),
(66, 6, '¿Cuántos lados tiene un hexágono?', 10, 3, 18, 0, 0),
(67, 1, '¿Cada cuántos años se celebran los Juegos Olímpicos de verano?', 10, 7, 22, 0, 0),
(68, 2, '¿En qué año cayó el Muro de Berlín?', 10, 4, 17, 0, 0),
(69, 3, '¿Qué gas es el más abundante en la atmósfera terrestre?', 10, 15, 40, 0, 0),
(70, 4, '¿Cuál es la capital de Australia?', 10, 6, 21, 0, 0),
(71, 5, '¿Qué lenguaje de programación se utiliza principalmente para el desarrollo web frontend?', 10, 12, 35, 0, 0),
(72, 6, '¿Cuál es el valor de $\\pi$ (pi) aproximado a dos decimales?', 10, 9, 28, 0, 0),
(73, 1, '¿Qué país ha ganado más Copas Mundiales de la FIFA?', 10, 1, 14, 0, 0),
(74, 2, '¿Qué civilización construyó las pirámides de Giza?', 10, 5, 19, 0, 0),
(75, 3, '¿Cuál es el hueso más largo del cuerpo humano?', 10, 11, 32, 0, 0),
(76, 4, '¿Dónde se encuentra el desierto del Sahara?', 10, 2, 16, 0, 0),
(77, 5, '¿Qué estructura de datos funciona con el principio LIFO?', 10, 7, 23, 0, 0),
(78, 6, '¿Cómo se llama el lado más largo de un triángulo rectángulo?', 10, 4, 20, 0, 0),
(79, 1, '¿Quién es considerado el mejor jugador de baloncesto de todos los tiempos?', 10, 8, 26, 0, 0),
(80, 2, '¿Quién escribió \"Don Quijote de la Mancha\"?', 10, 3, 15, 0, 0),
(81, 3, '¿Qué planeta es conocido como el \"Planeta Rojo\"?', 10, 14, 38, 0, 0),
(82, 4, '¿Cuál es el país más pequeño del mundo por área?', 10, 6, 25, 0, 0),
(83, 5, '¿Qué es un \"commit\" en Git?', 10, 10, 31, 0, 0),
(84, 6, '¿Cuál es el resultado de $5 \\times (3 + 2)$?', 10, 5, 21, 0, 0),
(85, 1, '¿Cuál es la distancia de un maratón en kilómetros?', 10, 10, 28, 0, 0),
(86, 2, '¿Quién fue la primera mujer en ganar un Premio Nobel?', 10, 2, 13, 0, 0),
(87, 3, '¿Qué órgano produce la bilis?', 10, 13, 36, 0, 0),
(88, 4, '¿Qué océano es el más grande?', 10, 7, 24, 0, 0),
(89, 5, '¿Qué es un \"bug\" en programación?', 10, 11, 33, 0, 0),
(90, 6, '¿Qué tipo de número es 7/3 (fracción)?', 10, 6, 22, 0, 0),
(91, 1, '¿Qué equipo de fútbol tiene más Ligas de Campeones de la UEFA?', 10, 4, 18, 0, 0),
(92, 2, '¿En qué siglo comenzó la Revolución Francesa?', 10, 1, 10, 0, 0),
(93, 3, '¿Qué capa de la Tierra protege de los rayos UV?', 10, 16, 42, 0, 0),
(94, 4, '¿Cuál es la montaña más alta del mundo?', 10, 8, 29, 0, 0),
(95, 5, '¿Qué es un bucle \"for\"?', 10, 13, 37, 0, 0),
(96, 6, '¿Qué es un número primo?', 10, 7, 25, 0, 0),
(97, 1, '¿Cuántos jugadores hay en un equipo de béisbol en el campo?', 10, 3, 17, 0, 0),
(98, 2, '¿Quién fue presidente de EEUU durante la Segunda Guerra Mundial?', 10, 5, 20, 0, 0),
(99, 3, '¿Cuál es la unidad básica de la herencia?', 10, 18, 45, 0, 0),
(100, 4, '¿Cuál es la capital de Canadá?', 10, 9, 30, 0, 0),
(101, 5, '¿Qué lenguaje se utiliza para estilizar páginas web?', 10, 14, 39, 0, 0),
(102, 6, '¿Cuál es el valor de $4!$ (factorial de 4)?', 10, 8, 27, 0, 0),
(103, 1, '¿Quién inventó el fútbol?', 10, 6, 21, 0, 0),
(104, 2, '¿En qué año llegó el hombre a la Luna?', 10, 2, 11, 0, 0),
(105, 3, '¿Qué animal realiza la fotosíntesis?', 10, 19, 49, 0, 0),
(106, 4, '¿Qué estrecho separa Asia de América del Norte?', 10, 10, 32, 0, 0),
(107, 5, '¿Qué significa HTML?', 10, 15, 41, 0, 0),
(108, 6, '¿Qué es el módulo de un número complejo?', 10, 9, 29, 0, 0),
(109, 1, '¿Qué es un \"hat-trick\" en fútbol?', 10, 7, 24, 0, 0),
(110, 2, '¿Qué famosa batalla tuvo lugar en 1066?', 10, 3, 16, 0, 0),
(111, 3, '¿Qué tipo de células son las neuronas?', 10, 20, 50, 0, 0),
(112, 4, '¿Cuál es el volcán más activo del mundo?', 10, 11, 34, 0, 0),
(113, 5, '¿Qué es una API?', 10, 16, 43, 0, 0),
(114, 6, '¿Qué figura geométrica tiene cuatro lados iguales y cuatro ángulos rectos?', 10, 10, 31, 0, 0),
(115, 1, '¿Cuál es el nombre del trofeo de la Copa Mundial de la FIFA?', 10, 8, 26, 0, 0),
(116, 2, '¿Cuál fue la capital del Imperio Azteca?', 10, 4, 19, 0, 0),
(117, 3, '¿Qué científico postuló la Teoría de la Relatividad?', 10, 22, 55, 0, 0),
(118, 4, '¿En qué continente se encuentra el Monte Kilimanjaro?', 10, 12, 36, 0, 0),
(119, 5, '¿Qué significa JSON?', 10, 17, 45, 0, 0),
(120, 6, '¿Cuál es la raíz cuadrada de 144?', 10, 11, 33, 0, 0),
(121, 1, '¿Quién es el máximo goleador en la historia del Real Madrid?', 10, 9, 28, 0, 0),
(122, 2, '¿Qué evento marca el inicio de la Edad Media?', 10, 5, 20, 0, 0),
(123, 3, '¿Qué es un catalizador en una reacción química?', 10, 24, 60, 0, 0),
(124, 4, '¿Cuál es el lago más grande de África?', 10, 13, 38, 0, 0),
(125, 5, '¿Cuál es la función principal de un compilador?', 10, 18, 47, 0, 0),
(126, 6, '¿Cuál es el área de un círculo con radio 5?', 10, 12, 35, 0, 0),
(127, 1, '¿Qué deporte se juega en Wimbledon?', 10, 11, 31, 0, 0),
(128, 2, '¿Quién fue Cleopatra?', 10, 6, 22, 0, 0),
(129, 3, '¿Cómo se llama la energía que usa el Sol?', 10, 26, 65, 0, 0),
(130, 4, '¿Qué país es el único que limita con Portugal?', 10, 14, 40, 0, 0),
(131, 5, '¿Qué es un algoritmo de búsqueda binaria?', 10, 19, 49, 0, 0),
(132, 6, '¿Qué es la pendiente de una recta?', 10, 14, 38, 0, 0),
(133, 1, '¿Qué selección ganó el primer Mundial de fútbol?', 10, 12, 33, 0, 0),
(134, 2, '¿Qué tratado puso fin a la Primera Guerra Mundial?', 10, 7, 23, 0, 0),
(135, 3, '¿Qué parte de la planta realiza la transpiración?', 10, 28, 70, 0, 0),
(136, 4, '¿Cuál es la diferencia horaria estándar de UTC?', 10, 15, 42, 0, 0),
(137, 5, '¿Qué es una variable de entorno?', 10, 20, 51, 0, 0),
(138, 6, '¿Qué es un vector en matemáticas?', 10, 15, 40, 0, 0),
(139, 1, '¿De qué color es la tarjeta que expulsa a un jugador en fútbol?', 10, 12, 34, 0, 0),
(140, 2, '¿Quién fue el líder de la India que promovió la no violencia?', 10, 8, 25, 0, 0),
(141, 3, '¿Qué elemento tiene el símbolo O en la tabla periódica?', 10, 30, 75, 0, 0),
(142, 4, '¿En qué ciudad se encuentra el Big Ben?', 10, 16, 44, 0, 0),
(143, 5, '¿Qué lenguaje se usa para el análisis de datos y la IA?', 10, 21, 53, 0, 0),
(144, 6, '¿Qué es la desviación estándar?', 10, 15, 41, 0, 0),
(145, 1, '¿En qué año se fundó el Comité Olímpico Internacional (COI)?', 10, 13, 36, 0, 0),
(146, 2, '¿Qué dinastia construyó la Gran Muralla China?', 10, 9, 27, 0, 0),
(147, 3, '¿Cuál es la función del ADN?', 10, 32, 80, 0, 0),
(148, 4, '¿Cuál es la isla más grande del mundo?', 10, 17, 46, 0, 0),
(149, 5, '¿Qué significa CRUD en bases de datos?', 10, 22, 55, 0, 0),
(150, 6, '¿Cuál es el perímetro de un cuadrado de lado 4?', 10, 16, 43, 0, 0),
(151, 1, '¿Qué tenista es conocido como el \"Rey de la Arcilla\"?', 10, 14, 38, 0, 0),
(152, 2, '¿Qué evento desencadenó la Primera Guerra Mundial?', 10, 10, 29, 0, 0),
(153, 3, '¿Qué parte del ojo controla la cantidad de luz que entra?', 10, 35, 86, 0, 0),
(154, 4, '¿Qué cordillera atraviesa Chile y Argentina?', 10, 18, 48, 0, 0),
(155, 5, '¿Qué es un framework web?', 10, 23, 57, 0, 0),
(156, 6, '¿Cuál es el valor de $e$ (número de Euler) aproximado?', 10, 18, 46, 0, 0),
(157, 1, '¿Cuántos puntos vale un tiro libre en baloncesto?', 10, 15, 40, 0, 0),
(158, 2, '¿Quién fue el líder del nazismo en Alemania?', 10, 11, 32, 0, 0),
(159, 3, '¿Qué es un ecosistema?', 10, 36, 90, 0, 0),
(160, 4, '¿Cuál es el punto más bajo de la Tierra?', 10, 19, 50, 0, 0),
(161, 5, '¿Qué es la recursividad?', 10, 24, 59, 0, 0),
(162, 6, '¿Qué es una matriz identidad?', 10, 18, 47, 0, 0),
(163, 1, '¿De qué nacionalidad es el piloto de F1 Lewis Hamilton?', 10, 16, 42, 0, 0),
(164, 2, '¿En qué batalla fue derrotado Napoleón?', 10, 12, 33, 0, 0),
(165, 3, '¿Qué científicos descubrieron la estructura de doble hélice del ADN?', 10, 38, 95, 0, 0),
(166, 4, '¿Qué ciudad es conocida como la \"Ciudad Eterna\"?', 10, 20, 52, 0, 0),
(167, 5, '¿Qué es un ORM?', 10, 25, 61, 0, 0),
(168, 6, '¿Qué es una función inyectiva?', 10, 19, 49, 0, 0),
(169, 1, '¿Qué es un birdie en golf?', 10, 17, 44, 0, 0),
(170, 2, '¿Qué civilización es famosa por la invención del papel y la pólvora?', 10, 14, 36, 0, 0),
(171, 3, '¿Cómo se llama la ciencia que estudia los terremotos?', 10, 40, 100, 0, 0),
(172, 4, '¿Qué monumento es la principal atracción de París?', 10, 21, 54, 0, 0),
(173, 5, '¿Qué es un sistema operativo?', 10, 26, 63, 0, 0),
(174, 6, '¿Qué estudia la trigonometría?', 10, 20, 51, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_a_evitar`
--

CREATE TABLE `preguntas_a_evitar` (
  `preguntas_a_evitar_id` int(11) NOT NULL,
  `preguntaId` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas_a_evitar`
--

INSERT INTO `preguntas_a_evitar` (`preguntas_a_evitar_id`, `preguntaId`, `usuarioId`) VALUES
(1, 40, 4),
(2, 85, 4),
(3, 13, 4),
(4, 31, 4),
(5, 3, 4),
(6, 6, 4),
(7, 13, 4),
(8, 40, 4),
(9, 105, 4),
(10, 54, 4),
(11, 127, 4),
(12, 30, 4),
(13, 170, 4),
(14, 156, 4),
(15, 57, 4),
(16, 132, 4),
(17, 133, 4),
(18, 158, 4),
(19, 4, 4),
(20, 153, 4),
(21, 26, 4),
(22, 34, 4),
(23, 18, 4),
(24, 36, 4),
(25, 2, 4),
(26, 138, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `reportesId` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `preguntaId` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id_respuesta` int(11) NOT NULL,
  `preguntaId` int(11) NOT NULL,
  `respuestaTexto` text NOT NULL,
  `esCorrecta` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id_respuesta`, `preguntaId`, `respuestaTexto`, `esCorrecta`) VALUES
(1, 1, '11', 1),
(2, 1, '9', 0),
(3, 1, '12', 0),
(4, 1, '10', 0),
(5, 2, 'Uruguay', 1),
(6, 2, 'Argentina', 0),
(7, 2, 'Brasil', 0),
(8, 2, 'Italia', 0),
(9, 3, 'Baloncesto', 1),
(10, 3, 'Béisbol', 0),
(11, 3, 'Fútbol Americano', 0),
(12, 3, 'Golf', 0),
(13, 4, '4', 1),
(14, 4, '2', 0),
(15, 4, '5', 0),
(16, 4, '6', 0),
(17, 5, 'Copa Libertadores de América', 1),
(18, 5, 'Copa del Rey', 0),
(19, 5, 'Champions League', 0),
(20, 5, 'Copa Sudamericana', 0),
(21, 6, 'Estados Unidos', 1),
(22, 6, 'Canadá', 0),
(23, 6, 'Brasil', 0),
(24, 6, 'Rusia', 0),
(25, 7, 'Novak Djokovic', 1),
(26, 7, 'Roger Federer', 0),
(27, 7, 'Rafael Nadal', 0),
(28, 7, 'Pete Sampras', 0),
(29, 8, '1896', 1),
(30, 8, '1900', 0),
(31, 8, '1888', 0),
(32, 8, '1924', 0),
(33, 9, 'Marcar un gol con la pierna derecha, uno con la izquierda y uno de cabeza', 1),
(34, 9, 'Marcar tres goles en un partido', 0),
(35, 9, 'Marcar tres goles en el primer tiempo', 0),
(36, 9, 'Marcar un gol en cada tiempo y uno en la prórroga', 0),
(37, 10, 'Michael Schumacher', 1),
(38, 10, 'Juan Manuel Fangio', 0),
(39, 10, 'Lewis Hamilton', 0),
(40, 10, 'Ayrton Senna', 0),
(41, 11, 'Neil Armstrong', 1),
(42, 11, 'Buzz Aldrin', 0),
(43, 11, 'Michael Collins', 0),
(44, 11, 'Yuri Gagarin', 0),
(45, 12, '1914', 1),
(46, 12, '1918', 0),
(47, 12, '1939', 0),
(48, 12, '1912', 0),
(49, 13, 'Egipcia', 1),
(50, 13, 'Romana', 0),
(51, 13, 'Griega', 0),
(52, 13, 'Maya', 0),
(53, 14, 'Tratado de Versalles', 1),
(54, 14, 'Tratado de Tordesillas', 0),
(55, 14, 'Tratado de Westfalia', 0),
(56, 14, 'Tratado de París', 0),
(57, 15, 'Sarajevo', 1),
(58, 15, 'Viena', 0),
(59, 15, 'Belgrado', 0),
(60, 15, 'Praga', 0),
(61, 16, 'Inca', 1),
(62, 16, 'Azteca', 0),
(63, 16, 'Maya', 0),
(64, 16, 'Olmeca', 0),
(65, 17, 'Cleopatra', 1),
(66, 17, 'Nefertiti', 0),
(67, 17, 'Hatshepsut', 0),
(68, 17, 'Nefertari', 0),
(69, 18, 'Operación Overlord', 1),
(70, 18, 'Operación Barbarroja', 0),
(71, 18, 'Operación Market Garden', 0),
(72, 18, 'Operación Torch', 0),
(73, 19, 'Vladimir Lenin', 1),
(74, 19, 'Iósif Stalin', 0),
(75, 19, 'León Trotski', 0),
(76, 19, 'Karl Marx', 0),
(77, 20, 'El Primer Imperio Francés', 1),
(78, 20, 'El Imperio Británico', 0),
(79, 20, 'El Imperio Ruso', 0),
(80, 20, 'El Imperio Austríaco', 0),
(81, 21, 'H₂O', 1),
(82, 21, 'CO₂', 0),
(83, 21, 'O₂', 0),
(84, 21, 'NaCl', 0),
(85, 22, 'Marte', 1),
(86, 22, 'Júpiter', 0),
(87, 22, 'Venus', 0),
(88, 22, 'Saturno', 0),
(89, 23, 'Oxígeno', 1),
(90, 23, 'Dióxido de carbono', 0),
(91, 23, 'Nitrógeno', 0),
(92, 23, 'Hidrógeno', 0),
(93, 24, 'Fémur', 1),
(94, 24, 'Húmero', 0),
(95, 24, 'Tibia', 0),
(96, 24, 'Cráneo', 0),
(97, 25, 'Fotosíntesis', 1),
(98, 25, 'Respiración celular', 0),
(99, 25, 'Mitosis', 0),
(100, 25, 'Ósmosis', 0),
(101, 26, '3', 1),
(102, 26, '1', 0),
(103, 26, '2', 0),
(104, 26, '8', 0),
(105, 27, 'Elefante africano', 1),
(106, 27, 'Jirafa', 0),
(107, 27, 'Rinoceronte blanco', 0),
(108, 27, 'Hipopótamo', 0),
(109, 28, '300,000 km/s', 1),
(110, 28, '150,000 km/s', 0),
(111, 28, '1,000,000 km/s', 0),
(112, 28, 'Es infinita', 0),
(113, 29, 'Mitocondria', 1),
(114, 29, 'Núcleo', 0),
(115, 29, 'Ribosoma', 0),
(116, 29, 'Aparato de Golgi', 0),
(117, 30, 'Albert Einstein', 1),
(118, 30, 'Isaac Newton', 0),
(119, 30, 'Galileo Galilei', 0),
(120, 30, 'Nikola Tesla', 0),
(121, 31, 'Amazonas', 1),
(122, 31, 'Nilo', 0),
(123, 31, 'Misisipi', 0),
(124, 31, 'Yangtsé', 0),
(125, 32, 'América del Sur', 1),
(126, 32, 'América del Norte', 0),
(127, 32, 'Europa', 0),
(128, 32, 'África', 0),
(129, 33, 'Roma', 1),
(130, 33, 'Milán', 0),
(131, 33, 'Venecia', 0),
(132, 33, 'Nápoles', 0),
(133, 34, 'El Sahara', 1),
(134, 34, 'El Gobi', 0),
(135, 34, 'El Kalahari', 0),
(136, 34, 'El de Arabia', 0),
(137, 35, 'Suecia', 1),
(138, 35, 'Indonesia', 0),
(139, 35, 'Finlandia', 0),
(140, 35, 'Canadá', 0),
(141, 36, 'Nepal', 1),
(142, 36, 'India', 0),
(143, 36, 'China', 0),
(144, 36, 'Bután', 0),
(145, 37, 'Lago Baikal', 1),
(146, 37, 'Lago Tanganica', 0),
(147, 37, 'Lago Superior', 0),
(148, 37, 'Mar Caspio', 0),
(149, 38, 'Canberra', 1),
(150, 38, 'Sídney', 0),
(151, 38, 'Melbourne', 0),
(152, 38, 'Perth', 0),
(153, 39, 'El punto más profundo de los océanos', 1),
(154, 39, 'Un volcán submarino activo', 0),
(155, 39, 'Una cordillera submarina', 0),
(156, 39, 'La fosa tectónica más larga', 0),
(157, 40, 'Haití y República Dominicana', 1),
(158, 40, 'Cuba y Jamaica', 0),
(159, 40, 'Puerto Rico y Haití', 0),
(160, 40, 'República Dominicana y Cuba', 0),
(161, 41, 'HyperText Markup Language', 1),
(162, 41, 'High-level Text Machine Language', 0),
(163, 41, 'Hyperlink and Text Markup Language', 0),
(164, 41, 'Home Tool Markup Language', 0),
(165, 42, 'Java', 1),
(166, 42, 'HTML', 0),
(167, 42, 'CSS', 0),
(168, 42, 'SQL', 0),
(169, 43, '//', 1),
(170, 43, '/* */', 0),
(171, 43, '', 0),
(172, 43, '#', 0),
(173, 44, 'Un espacio en memoria para almacenar un valor que puede cambiar', 1),
(174, 44, 'Una función que no devuelve nada', 0),
(175, 44, 'Una constante que nunca cambia', 0),
(176, 44, 'Un tipo de dato exclusivamente numérico', 0),
(177, 45, 'Para copiar un repositorio remoto a tu máquina local', 1),
(178, 45, 'Para crear una nueva rama', 0),
(179, 45, 'Para fusionar dos ramas', 0),
(180, 45, 'Para subir cambios a un repositorio', 0),
(181, 46, 'Application Programming Interface', 1),
(182, 46, 'Advanced Program Interaction', 0),
(183, 46, 'Automated Programming Input', 0),
(184, 46, 'Application Process Integration', 0),
(185, 47, 'Programación Orientada a Objetos', 1),
(186, 47, 'Programación Funcional', 0),
(187, 47, 'Programación Procedural', 0),
(188, 47, 'Programación Lógica', 0),
(189, 48, 'Una función que se llama a sí misma para resolver un problema', 1),
(190, 48, 'Un bucle que se ejecuta infinitamente', 0),
(191, 48, 'Un objeto que hereda de varias clases', 0),
(192, 48, 'Una variable que puede contener múltiples tipos de datos', 0),
(193, 49, '`===` compara valor y tipo, `==` solo valor (con coerción de tipo)', 1),
(194, 49, '`===` es para objetos y `==` para tipos primitivos', 0),
(195, 49, '`===` es una versión más rápida de `==`', 0),
(196, 49, 'No hay ninguna diferencia, son intercambiables', 0),
(197, 50, 'Abstract Factory', 1),
(198, 50, 'Singleton', 0),
(199, 50, 'Observer', 0),
(200, 50, 'Decorator', 0),
(201, 51, '63', 1),
(202, 51, '56', 0),
(203, 51, '64', 0),
(204, 51, '72', 0),
(205, 52, 'Pentágono', 1),
(206, 52, 'Hexágono', 0),
(207, 52, 'Heptágono', 0),
(208, 52, 'Cuadrado', 0),
(209, 53, '15', 1),
(210, 53, '10', 0),
(211, 53, '20', 0),
(212, 53, 'La mitad de las manzanas', 0),
(213, 54, '3.14', 1),
(214, 54, '3.16', 0),
(215, 54, '2.71', 0),
(216, 54, '1.61', 0),
(217, 55, '12', 1),
(218, 55, '11', 0),
(219, 55, '13', 0),
(220, 55, '14', 0),
(221, 56, '180°', 1),
(222, 56, '90°', 0),
(223, 56, '270°', 0),
(224, 56, '360°', 0),
(225, 57, 'Teorema de Pitágoras', 1),
(226, 57, 'Teorema de Tales', 0),
(227, 57, 'Teorema de Euclides', 0),
(228, 57, 'Último teorema de Fermat', 0),
(229, 58, 'Un número natural > 1 que solo es divisible por sí mismo y por 1', 1),
(230, 58, 'Un número que es impar', 0),
(231, 58, 'Un número que es divisible por 2', 0),
(232, 58, 'Un número que no tiene raíz cuadrada exacta', 0),
(233, 59, '1024', 1),
(234, 59, '1000', 0),
(235, 59, '2048', 0),
(236, 59, '512', 0),
(237, 60, '120', 1),
(238, 60, '25', 0),
(239, 60, '60', 0),
(240, 60, '100', 0),
(697, 61, 'Tenis', 1),
(698, 61, 'Fútbol', 0),
(699, 61, 'Baloncesto', 0),
(700, 61, 'Natación', 0),
(701, 62, 'Augusto', 1),
(702, 62, 'Julio César', 0),
(703, 62, 'Calígula', 0),
(704, 62, 'Nerón', 0),
(705, 63, 'H₂O', 1),
(706, 63, 'CO₂', 0),
(707, 63, 'O₂', 0),
(708, 63, 'NaCl', 0),
(709, 64, 'Amazonas', 1),
(710, 64, 'Nilo', 0),
(711, 64, 'Yangtsé', 0),
(712, 64, 'Misisipi', 0),
(713, 65, 'Structured Query Language', 1),
(714, 65, 'Simple Query Logic', 0),
(715, 65, 'Sequential Query Language', 0),
(716, 65, 'System Query Locator', 0),
(717, 66, '6', 1),
(718, 66, '5', 0),
(719, 66, '7', 0),
(720, 66, '8', 0),
(721, 67, '4', 1),
(722, 67, '2', 0),
(723, 67, '5', 0),
(724, 67, '3', 0),
(725, 68, '1989', 1),
(726, 68, '1991', 0),
(727, 68, '1985', 0),
(728, 68, '1990', 0),
(729, 69, 'Nitrógeno', 1),
(730, 69, 'Oxígeno', 0),
(731, 69, 'Argón', 0),
(732, 69, 'Dióxido de carbono', 0),
(733, 70, 'Canberra', 1),
(734, 70, 'Sídney', 0),
(735, 70, 'Melbourne', 0),
(736, 70, 'Perth', 0),
(737, 71, 'JavaScript', 1),
(738, 71, 'Python', 0),
(739, 71, 'Java', 0),
(740, 71, 'C#', 0),
(741, 72, '3.14', 1),
(742, 72, '3.16', 0),
(743, 72, '3.12', 0),
(744, 72, '3.10', 0),
(745, 73, 'Brasil', 1),
(746, 73, 'Alemania', 0),
(747, 73, 'Italia', 0),
(748, 73, 'Argentina', 0),
(749, 74, 'Egipcia', 1),
(750, 74, 'Romana', 0),
(751, 74, 'Maya', 0),
(752, 74, 'Mesopotámica', 0),
(753, 75, 'Fémur', 1),
(754, 75, 'Tibia', 0),
(755, 75, 'Cráneo', 0),
(756, 75, 'Peroné', 0),
(757, 76, 'África', 1),
(758, 76, 'Asia', 0),
(759, 76, 'América del Sur', 0),
(760, 76, 'Oceanía', 0),
(761, 77, 'Pila (Stack)', 1),
(762, 77, 'Cola (Queue)', 0),
(763, 77, 'Lista', 0),
(764, 77, 'Árbol', 0),
(765, 78, 'Hipotenusa', 1),
(766, 78, 'Cateto', 0),
(767, 78, 'Apotema', 0),
(768, 78, 'Radio', 0),
(769, 79, 'Michael Jordan', 1),
(770, 79, 'LeBron James', 0),
(771, 79, 'Kobe Bryant', 0),
(772, 79, 'Kareem Abdul-Jabbar', 0),
(773, 80, 'Miguel de Cervantes', 1),
(774, 80, 'García Márquez', 0),
(775, 80, 'Lope de Vega', 0),
(776, 80, 'Borges', 0),
(777, 81, 'Marte', 1),
(778, 81, 'Júpiter', 0),
(779, 81, 'Venus', 0),
(780, 81, 'Saturno', 0),
(781, 82, 'Ciudad del Vaticano', 1),
(782, 82, 'Mónaco', 0),
(783, 82, 'Nauru', 0),
(784, 82, 'San Marino', 0),
(785, 83, 'Una instantánea de los cambios en el repositorio', 1),
(786, 83, 'Un error en el código', 0),
(787, 83, 'La compilación del código', 0),
(788, 83, 'Una rama del código', 0),
(789, 84, '25', 1),
(790, 84, '13', 0),
(791, 84, '17', 0),
(792, 84, '15', 0),
(793, 85, '42.195 km', 1),
(794, 85, '21.097 km', 0),
(795, 85, '50 km', 0),
(796, 85, '40 km', 0),
(797, 86, 'Marie Curie', 1),
(798, 86, 'Rosalind Franklin', 0),
(799, 86, 'Madre Teresa', 0),
(800, 86, 'Ada Lovelace', 0),
(801, 87, 'Hígado', 1),
(802, 87, 'Riñón', 0),
(803, 87, 'Estómago', 0),
(804, 87, 'Bazo', 0),
(805, 88, 'Océano Pacífico', 1),
(806, 88, 'Océano Atlántico', 0),
(807, 88, 'Océano Índico', 0),
(808, 88, 'Océano Ártico', 0),
(809, 89, 'Un error o defecto en el software', 1),
(810, 89, 'Una característica inesperada', 0),
(811, 89, 'Un atajo de teclado', 0),
(812, 89, 'Un tipo de virus', 0),
(813, 90, 'Racional', 1),
(814, 90, 'Entero', 0),
(815, 90, 'Irracional', 0),
(816, 90, 'Natural', 0),
(817, 91, 'Real Madrid', 1),
(818, 91, 'AC Milan', 0),
(819, 91, 'Bayern Múnich', 0),
(820, 91, 'Liverpool FC', 0),
(821, 92, 'Siglo XVIII', 1),
(822, 92, 'Siglo XVII', 0),
(823, 92, 'Siglo XIX', 0),
(824, 92, 'Siglo XV', 0),
(825, 93, 'Capa de ozono', 1),
(826, 93, 'Estratosfera', 0),
(827, 93, 'Troposfera', 0),
(828, 93, 'Ionósfera', 0),
(829, 94, 'Monte Everest', 1),
(830, 94, 'K2', 0),
(831, 94, 'Monte Kilimanjaro', 0),
(832, 94, 'Aconcagua', 0),
(833, 95, 'Una estructura de control para iterar un número conocido de veces', 1),
(834, 95, 'Una función para definir variables', 0),
(835, 95, 'Una sentencia de bifurcación', 0),
(836, 95, 'Un tipo de dato', 0),
(837, 96, 'Un número mayor que 1 que solo es divisible por 1 y por sí mismo', 1),
(838, 96, 'Un número divisible por 2', 0),
(839, 96, 'Cualquier número impar', 0),
(840, 96, 'Un número con decimales', 0),
(841, 97, '9', 1),
(842, 97, '10', 0),
(843, 97, '11', 0),
(844, 97, '8', 0),
(845, 98, 'Franklin D. Roosevelt', 1),
(846, 98, 'Harry S. Truman', 0),
(847, 98, 'Dwight D. Eisenhower', 0),
(848, 98, 'Woodrow Wilson', 0),
(849, 99, 'Gen', 1),
(850, 99, 'Cromosoma', 0),
(851, 99, 'Núcleo', 0),
(852, 99, 'Mitocondria', 0),
(853, 100, 'Ottawa', 1),
(854, 100, 'Toronto', 0),
(855, 100, 'Vancouver', 0),
(856, 100, 'Montreal', 0),
(857, 101, 'CSS', 1),
(858, 101, 'HTML', 0),
(859, 101, 'PHP', 0),
(860, 101, 'SQL', 0),
(861, 102, '24', 1),
(862, 102, '4', 0),
(863, 102, '16', 0),
(864, 102, '12', 0),
(865, 103, 'Inglaterra', 1),
(866, 103, 'Brasil', 0),
(867, 103, 'Uruguay', 0),
(868, 103, 'China', 0),
(869, 104, '1969', 1),
(870, 104, '1965', 0),
(871, 104, '1971', 0),
(872, 104, '1967', 0),
(873, 105, 'Ninguno (solo plantas y algas)', 1),
(874, 105, 'Oso perezoso', 0),
(875, 105, 'Salamandra', 0),
(876, 105, 'Medusa', 0),
(877, 106, 'Estrecho de Bering', 1),
(878, 106, 'Estrecho de Gibraltar', 0),
(879, 106, 'Estrecho de Magallanes', 0),
(880, 106, 'Estrecho de Malaca', 0),
(881, 107, 'HyperText Markup Language', 1),
(882, 107, 'High-level Text Management Language', 0),
(883, 107, 'Hyperlink and Text Markup Language', 0),
(884, 107, 'Home Tool Markup Language', 0),
(885, 108, 'La distancia del punto al origen en el plano complejo', 1),
(886, 108, 'El ángulo del número', 0),
(887, 108, 'La parte imaginaria del número', 0),
(888, 108, 'La parte real del número', 0),
(889, 109, 'Tres goles marcados por un jugador en un partido', 1),
(890, 109, 'Tres asistencias en un partido', 0),
(891, 109, 'Tres tarjetas amarillas', 0),
(892, 109, 'Tres partidos sin recibir goles', 0),
(893, 110, 'Batalla de Hastings', 1),
(894, 110, 'Batalla de Waterloo', 0),
(895, 110, 'Batalla de Gaugamela', 0),
(896, 110, 'Batalla de Stalingrado', 0),
(897, 111, 'Células nerviosas', 1),
(898, 111, 'Células sanguíneas', 0),
(899, 111, 'Células óseas', 0),
(900, 111, 'Células epiteliales', 0),
(901, 112, 'Kilauea (Hawái)', 1),
(902, 112, 'Monte Vesubio', 0),
(903, 112, 'Monte Fuji', 0),
(904, 112, 'Popocatépetl', 0),
(905, 113, 'Una Interfaz de Programación de Aplicaciones', 1),
(906, 113, 'Una Aplicación de Interfaz Personalizada', 0),
(907, 113, 'Un Archivo de Protocolo de Internet', 0),
(908, 113, 'Una Automatización de Procesos de Intercambio', 0),
(909, 114, 'Cuadrado', 1),
(910, 114, 'Rectángulo', 0),
(911, 114, 'Rombo', 0),
(912, 114, 'Trapecio', 0),
(913, 115, 'Trofeo de la Copa Mundial de la FIFA', 1),
(914, 115, 'Copa Jules Rimet', 0),
(915, 115, 'Balón de Oro', 0),
(916, 115, 'Copa de Oro', 0),
(917, 116, 'Tenochtitlan', 1),
(918, 116, 'Cuzco', 0),
(919, 116, 'Tikal', 0),
(920, 116, 'Chichén Itzá', 0),
(921, 117, 'Albert Einstein', 1),
(922, 117, 'Isaac Newton', 0),
(923, 117, 'Galileo Galilei', 0),
(924, 117, 'Charles Darwin', 0),
(925, 118, 'África', 1),
(926, 118, 'Asia', 0),
(927, 118, 'América del Sur', 0),
(928, 118, 'Europa', 0),
(929, 119, 'JavaScript Object Notation', 1),
(930, 119, 'Java Style Object Notation', 0),
(931, 119, 'JQuery System Network', 0),
(932, 119, 'Junction Server Object Name', 0),
(933, 120, '12', 1),
(934, 120, '14', 0),
(935, 120, '16', 0),
(936, 120, '10', 0),
(937, 121, 'Cristiano Ronaldo', 1),
(938, 121, 'Raúl González', 0),
(939, 121, 'Alfredo Di Stéfano', 0),
(940, 121, 'Karim Benzema', 0),
(941, 122, 'Caída del Imperio Romano de Occidente', 1),
(942, 122, 'Descubrimiento de América', 0),
(943, 122, 'Inicio de la Revolución Francesa', 0),
(944, 122, 'Invención de la imprenta', 0),
(945, 123, 'Una sustancia que acelera la reacción sin consumirse', 1),
(946, 123, 'El producto final de la reacción', 0),
(947, 123, 'Un reactivo limitante', 0),
(948, 123, 'Un inhibidor de la reacción', 0),
(949, 124, 'Lago Victoria', 1),
(950, 124, 'Lago Tanganica', 0),
(951, 124, 'Lago Malaui', 0),
(952, 124, 'Lago Chad', 0),
(953, 125, 'Traducir código fuente a código máquina', 1),
(954, 125, 'Ejecutar código línea por línea', 0),
(955, 125, 'Estilizar la interfaz de usuario', 0),
(956, 125, 'Gestionar bases de datos', 0),
(957, 126, '25$pi$', 1),
(958, 126, '10$pi$', 0),
(959, 126, '5$pi$', 0),
(960, 126, '50$pi$', 0),
(961, 127, 'Tenis', 1),
(962, 127, 'Golf', 0),
(963, 127, 'Bádminton', 0),
(964, 127, 'Cricket', 0),
(965, 128, 'La última reina activa del Antiguo Egipto', 1),
(966, 128, 'Una emperatriz romana', 0),
(967, 128, 'La fundadora de Roma', 0),
(968, 128, 'Una faraona de la IV Dinastía', 0),
(969, 129, 'Fusión nuclear', 1),
(970, 129, 'Fisión nuclear', 0),
(971, 129, 'Combustión', 0),
(972, 129, 'Energía eólica', 0),
(973, 130, 'España', 1),
(974, 130, 'Francia', 0),
(975, 130, 'Marruecos', 0),
(976, 130, 'Andorra', 0),
(977, 131, 'Un método para encontrar un elemento en una lista ordenada', 1),
(978, 131, 'Un algoritmo para ordenar una lista', 0),
(979, 131, 'Una función hash', 0),
(980, 131, 'Un tipo de cifrado', 0),
(981, 132, 'La inclinación de la recta (cambio vertical / cambio horizontal)', 1),
(982, 132, 'El punto donde la recta cruza el eje Y', 0),
(983, 132, 'La longitud de la recta', 0),
(984, 132, 'El área bajo la recta', 0),
(985, 133, 'Uruguay', 1),
(986, 133, 'Brasil', 0),
(987, 133, 'Italia', 0),
(988, 133, 'Argentina', 0),
(989, 134, 'Tratado de Versalles', 1),
(990, 134, 'Tratado de Tordesillas', 0),
(991, 134, 'Tratado de París', 0),
(992, 134, 'Paz de Westfalia', 0),
(993, 135, 'Hojas (estomas)', 1),
(994, 135, 'Raíces', 0),
(995, 135, 'Tallo', 0),
(996, 135, 'Flores', 0),
(997, 136, 'Tiempo Universal Coordinado', 1),
(998, 136, 'Tiempo Estándar del Centro', 0),
(999, 136, 'Tiempo del Meridiano de Greenwich', 0),
(1000, 136, 'Tiempo Solar Medio', 0),
(1001, 137, 'Un valor dinámico que afecta el comportamiento de los procesos en un equipo', 1),
(1002, 137, 'Una variable definida dentro de una función', 0),
(1003, 137, 'Un tipo de dato especial', 0),
(1004, 137, 'Una constante matemática', 0),
(1005, 138, 'Una cantidad con magnitud y dirección', 1),
(1006, 138, 'Un valor que no cambia', 0),
(1007, 138, 'Un arreglo de números', 0),
(1008, 138, 'La suma de dos matrices', 0),
(1009, 139, 'Roja', 1),
(1010, 139, 'Amarilla', 0),
(1011, 139, 'Azul', 0),
(1012, 139, 'Verde', 0),
(1013, 140, 'Mahatma Gandhi', 1),
(1014, 140, 'Jawaharlal Nehru', 0),
(1015, 140, 'Indira Gandhi', 0),
(1016, 140, 'Subhas Chandra Bose', 0),
(1017, 141, 'Oxígeno', 1),
(1018, 141, 'Oro', 0),
(1019, 141, 'Osmio', 0),
(1020, 141, 'Calcio', 0),
(1021, 142, 'Londres', 1),
(1022, 142, 'París', 0),
(1023, 142, 'Roma', 0),
(1024, 142, 'Berlín', 0),
(1025, 143, 'Python', 1),
(1026, 143, 'C++', 0),
(1027, 143, 'Ruby', 0),
(1028, 143, 'Go', 0),
(1029, 144, 'Una medida de la dispersión de un conjunto de datos', 1),
(1030, 144, 'El promedio de los datos', 0),
(1031, 144, 'El valor central de los datos', 0),
(1032, 144, 'La suma de todos los datos', 0),
(1033, 145, '1894', 1),
(1034, 145, '1900', 0),
(1035, 145, '1896', 0),
(1036, 145, '1924', 0),
(1037, 146, 'Dinastía Qin', 1),
(1038, 146, 'Dinastía Han', 0),
(1039, 146, 'Dinastía Ming', 0),
(1040, 146, 'Dinastía Tang', 0),
(1041, 147, 'Almacenar la información genética', 1),
(1042, 147, 'Proporcionar energía a la célula', 0),
(1043, 147, 'Transportar oxígeno', 0),
(1044, 147, 'Regular la temperatura corporal', 0),
(1045, 148, 'Groenlandia', 1),
(1046, 148, 'Nueva Guinea', 0),
(1047, 148, 'Borneo', 0),
(1048, 148, 'Madagascar', 0),
(1049, 149, 'Create, Read, Update, Delete', 1),
(1050, 149, 'Connect, Run, Update, Disconnect', 0),
(1051, 149, 'Control, Register, Undo, Drop', 0),
(1052, 149, 'Code, Run, Upload, Download', 0),
(1053, 150, '16', 1),
(1054, 150, '12', 0),
(1055, 150, '8', 0),
(1056, 150, '4', 0),
(1057, 151, 'Rafael Nadal', 1),
(1058, 151, 'Roger Federer', 0),
(1059, 151, 'Novak Djokovic', 0),
(1060, 151, 'Pete Sampras', 0),
(1061, 152, 'El asesinato del Archiduque Francisco Fernando', 1),
(1062, 152, 'El hundimiento del Lusitania', 0),
(1063, 152, 'La invasión de Polonia', 0),
(1064, 152, 'La crisis de los misiles de Cuba', 0),
(1065, 153, 'Iris y pupila', 1),
(1066, 153, 'Retina', 0),
(1067, 153, 'Cristalino', 0),
(1068, 153, 'Nervio óptico', 0),
(1069, 154, 'Los Andes', 1),
(1070, 154, 'Los Alpes', 0),
(1071, 154, 'Los Himalayas', 0),
(1072, 154, 'Los Urales', 0),
(1073, 155, 'Un conjunto de herramientas y librerías preestablecidas para desarrollar aplicaciones web', 1),
(1074, 155, 'Un protocolo de seguridad web', 0),
(1075, 155, 'Un lenguaje de programación', 0),
(1076, 155, 'Un servidor de base de datos', 0),
(1077, 156, '2.71', 1),
(1078, 156, '3.14', 0),
(1079, 156, '1.61', 0),
(1080, 156, '0.57', 0),
(1081, 157, '1 punto', 1),
(1082, 157, '2 puntos', 0),
(1083, 157, '3 puntos', 0),
(1084, 157, '0 puntos', 0),
(1085, 158, 'Adolf Hitler', 1),
(1086, 158, 'Benito Mussolini', 0),
(1087, 158, 'Joseph Stalin', 0),
(1088, 158, 'Winston Churchill', 0),
(1089, 159, 'Un conjunto de organismos vivos y el entorno físico donde interactúan', 1),
(1090, 159, 'Una comunidad de plantas solamente', 0),
(1091, 159, 'Una región geográfica', 0),
(1092, 159, 'Un solo organismo', 0),
(1093, 160, 'Fosa de las Marianas', 1),
(1094, 160, 'Mar Muerto', 0),
(1095, 160, 'Valle de la Muerte', 0),
(1096, 160, 'Lago Baikal', 0),
(1097, 161, 'Una función que se llama a sí misma', 1),
(1098, 161, 'Un tipo de bucle infinito', 0),
(1099, 161, 'Un error de sintaxis', 0),
(1100, 161, 'Una biblioteca de código', 0),
(1101, 162, 'Una matriz cuadrada con unos en la diagonal principal y ceros en el resto', 1),
(1102, 162, 'Una matriz con todos los elementos iguales a cero', 0),
(1103, 162, 'Una matriz con una sola fila', 0),
(1104, 162, 'Una matriz con determinantes iguales', 0),
(1105, 163, 'Británica', 1),
(1106, 163, 'Alemana', 0),
(1107, 163, 'Finlandesa', 0),
(1108, 163, 'Española', 0),
(1109, 164, 'Batalla de Waterloo', 1),
(1110, 164, 'Batalla de Austerlitz', 0),
(1111, 164, 'Batalla de Trafalgar', 0),
(1112, 164, 'Batalla de Borodino', 0),
(1113, 165, 'Watson y Crick', 1),
(1114, 165, 'Mendel y Darwin', 0),
(1115, 165, 'Pasteur y Koch', 0),
(1116, 165, 'Franklin y Pauling', 0),
(1117, 166, 'Roma', 1),
(1118, 166, 'Atenas', 0),
(1119, 166, 'Jerusalén', 0),
(1120, 166, 'Estambul', 0),
(1121, 167, 'Mapeo Objeto-Relacional (Object-Relational Mapping)', 1),
(1122, 167, 'Modelo de Red Abierto (Open Router Model)', 0),
(1123, 167, 'Organización de Recursos Múltiples (Organization of Multiple Resources)', 0),
(1124, 167, 'Sistema Operativo Remoto (Operating Remote Manager)', 0),
(1125, 168, 'Una función donde cada elemento del codominio se relaciona con, como máximo, un elemento del dominio', 1),
(1126, 168, 'Una función donde cada elemento tiene un único valor', 0),
(1127, 168, 'Una función que tiene un valor máximo', 0),
(1128, 168, 'Una función que no es continua', 0),
(1129, 169, 'Un golpe bajo el par en un hoyo', 1),
(1130, 169, 'Un golpe dos sobre el par', 0),
(1131, 169, 'Un golpe al par', 0),
(1132, 169, 'Un golpe tres bajo el par', 0),
(1133, 170, 'China', 1),
(1134, 170, 'India', 0),
(1135, 170, 'Árabe', 0),
(1136, 170, 'Romana', 0),
(1137, 171, 'Sismología', 1),
(1138, 171, 'Vulcanología', 0),
(1139, 171, 'Meteorología', 0),
(1140, 171, 'Geología', 0),
(1141, 172, 'Torre Eiffel', 1),
(1142, 172, 'Coliseo', 0),
(1143, 172, 'Estatua de la Libertad', 0),
(1144, 172, 'Big Ben', 0),
(1145, 173, 'El software principal que gestiona los recursos de hardware y proporciona servicios a los programas', 1),
(1146, 173, 'Un lenguaje de programación', 0),
(1147, 173, 'Un tipo de base de datos', 0),
(1148, 173, 'Un protocolo de red', 0),
(1149, 174, 'Las relaciones entre los ángulos y los lados de los triángulos', 1),
(1150, 174, 'El estudio del infinito', 0),
(1151, 174, 'El estudio de las curvas', 0),
(1152, 174, 'La probabilidad de eventos', 0);

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
  `token` varchar(255) DEFAULT NULL,
  `img_qr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuarioId`, `nombre_completo`, `anio_nacimiento`, `sexo`, `pais`, `ciudad`, `latitud`, `longitud`, `email`, `password`, `nombre_usuario`, `foto_perfil`, `cuenta_verificada`, `id_rol`, `fecha_registro`, `token`, `img_qr`) VALUES
(1, 'Ana Martinez', 1998, 'Femenino', 'Argentina', 'La Plata', NULL, NULL, 'ana.martinez@email.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Ana', 'imagenes/fotoPerfil.jpg', 1, 1, '2025-10-20 14:14:12', '', '/imagenes/qr_Ana.png'),
(2, 'Carlos Rodriguez', 1985, 'Masculino', 'Argentina', 'San Justo', NULL, NULL, 'carlos.editor@juego.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Carlos', 'imagenes/fotoPerfil.jpg', 1, 2, '2025-10-20 14:14:12', '', '/imagenes/qr_Carlos.png'),
(3, 'Sofia Lopez', 1990, 'Prefiero no cargarlo', 'Argentina', 'Ramos Mejía', NULL, NULL, 'sofia.admin@juego.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Sofia', 'imagenes/fotoPerfil.jpg', 1, 3, '2025-10-20 14:14:12', '', '/imagenes/qr_Sofia.png'),
(4, 'Admin', 1997, 'Masculino', 'Argentina', 'Buenos Aires', NULL, NULL, 'admin@example.com', '$2y$10$PYeUBw4VFBtg6IbaRplDD.EmUTDFklzZiyGa.2Gx.ULSTEapPK0oK', 'Admin97', 'imagenes/fotoPerfil.jpg', 1, 3, '2025-10-20 14:19:41', '', '/imagenes/qr_Admin97.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoriaId`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `historial_respuestas`
--
ALTER TABLE `historial_respuestas`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `historial_respuestas_ibfk_1` (`usuarioId`),
  ADD KEY `historial_respuestas_ibfk_2` (`preguntaId`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id_partida`),
  ADD KEY `partida_ibfk_1` (`usuarioId`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`preguntaId`),
  ADD KEY `pregunta_ibfk_1` (`categoriaId`);

--
-- Indices de la tabla `preguntas_a_evitar`
--
ALTER TABLE `preguntas_a_evitar`
  ADD PRIMARY KEY (`preguntas_a_evitar_id`),
  ADD KEY `usuarioId` (`usuarioId`),
  ADD KEY `preguntaId` (`preguntaId`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`reportesId`),
  ADD KEY `usuarioId` (`usuarioId`),
  ADD KEY `preguntaId` (`preguntaId`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `respuesta_ibfk_1` (`preguntaId`);

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
  ADD KEY `usuario_ibfk_1` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoriaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `historial_respuestas`
--
ALTER TABLE `historial_respuestas`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `preguntaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT de la tabla `preguntas_a_evitar`
--
ALTER TABLE `preguntas_a_evitar`
  MODIFY `preguntas_a_evitar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `reportesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1153;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuarioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_respuestas`
--
ALTER TABLE `historial_respuestas`
  ADD CONSTRAINT `historial_respuestas_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`usuarioId`),
  ADD CONSTRAINT `historial_respuestas_ibfk_2` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`preguntaId`);

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`usuarioId`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`categoriaId`) REFERENCES `categoria` (`categoriaId`);

--
-- Filtros para la tabla `preguntas_a_evitar`
--
ALTER TABLE `preguntas_a_evitar`
  ADD CONSTRAINT `preguntas_a_evitar_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`usuarioId`),
  ADD CONSTRAINT `preguntas_a_evitar_ibfk_2` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`preguntaId`);

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`usuarioId`),
  ADD CONSTRAINT `reportes_ibfk_2` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`preguntaId`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`preguntaId`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);



INSERT INTO reportes(usuarioId, preguntaId, descripcion)
VALUES
    (1, 1, "Reporte 1"),  -- Modificado (era Reporte 3)
    (1, 20, "Reporte 4"),
    (1, 20, "Reporte 5"),
    (1, 20, "Reporte 6"),
    (1, 40, "Reporte 7"),
    (1, 40, "Reporte 8"),
    (1, 40, "Reporte 9"),
    (1, 60, "Reporte 10"),
    (1, 4, "Reporte 11"), -- Aquí empiezan los del segundo script
    (1, 5, "Reporte 12"),
    (1, 21, "Reporte 13"),
    (1, 25, "Reporte 14"),
    (1, 42, "Reporte 15"),
    (1, 44, "Reporte 16"),
    (1, 47, "Reporte 17"),
    (1, 64, "Reporte 18");
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
