-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2025 a las 00:17:03
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
  `color` varchar(7) DEFAULT NULL
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
-- Estructura de tabla para la tabla `historial_respuestas`
--

CREATE TABLE `historial_respuestas` (
  `id_historial` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `preguntaId` int(11) NOT NULL,
  `fue_correcta` tinyint(1) NOT NULL,
  `fecha_respuesta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(17, 4, 40, '2025-11-01 03:11:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `preguntaId` int(11) NOT NULL,
  `categoriaId` int(11) NOT NULL,
  `enunciado` text NOT NULL,
  `puntaje` int(11) NOT NULL DEFAULT 10,
  `respondidasMal` int(11) DEFAULT NULL,
  `cantidadEnviada` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`preguntaId`, `categoriaId`, `enunciado`, `puntaje`, `respondidasMal`, `cantidadEnviada`) VALUES
(1, 1, '¿Cuántos jugadores tiene un equipo de fútbol en el campo durante un partido?', 10, 1, 1),
(2, 1, '¿Qué país ganó la primera Copa del Mundo de fútbol en 1930?', 10, 1, 1),
(3, 1, '¿En qué deporte se considera a Michael Jordan como el mejor de todos los tiempos?', 10, 1, 1),
(4, 1, '¿Cada cuántos años se celebran los Juegos Olímpicos de Verano?', 10, 1, 1),
(5, 1, '¿Cómo se llama el trofeo que se entrega al ganador de la Copa Libertadores?', 10, 1, 1),
(6, 1, '¿En qué país se inventó el voleibol?', 10, 1, 1),
(7, 1, '¿Qué tenista tiene el récord de más títulos de Grand Slam en la categoría masculina?', 10, 1, 1),
(8, 1, '¿En qué año se celebraron los primeros Juegos Olímpicos modernos en Atenas?', 10, 1, 1),
(9, 1, '¿Qué es un \"hat-trick\" perfecto en el fútbol?', 10, 1, 1),
(10, 1, '¿Quién fue el primer piloto en ganar 7 campeonatos mundiales de Fórmula 1?', 10, 1, 1),
(11, 2, '¿Quién fue el primer hombre en pisar la Luna en 1969?', 10, 1, 1),
(12, 2, '¿En qué año comenzó la Primera Guerra Mundial?', 10, 1, 1),
(13, 2, '¿Qué civilización antigua construyó las pirámides de Giza?', 10, 1, 1),
(14, 2, '¿Qué tratado puso fin a la Primera Guerra Mundial?', 10, 1, 1),
(15, 2, '¿En qué ciudad fue asesinado el archiduque Francisco Fernando, evento que desencadenó la Primera Guerra Mundial?', 10, 1, 1),
(16, 2, '¿Qué civilización precolombina construyó la ciudad de Machu Picchu?', 10, 1, 1),
(17, 2, '¿Quién fue la última reina de Egipto?', 10, 1, 1),
(18, 2, '¿Cómo se llamó la operación militar del desembarco de Normandía durante la Segunda Guerra Mundial?', 10, 1, 1),
(19, 2, '¿Quién fue el líder de la facción bolchevique durante la Revolución Rusa?', 10, 1, 1),
(20, 2, '¿Qué imperio fue derrotado en la Batalla de Waterloo en 1815?', 10, 1, 1),
(21, 3, '¿Cuál es el símbolo químico del agua?', 10, 1, 1),
(22, 3, '¿Qué planeta de nuestro sistema solar es conocido como el \"Planeta Rojo\"?', 10, 1, 1),
(23, 3, '¿Qué gas es esencial para la respiración de los seres humanos?', 10, 1, 1),
(24, 3, '¿Cuál es el hueso más largo del cuerpo humano?', 10, 1, 1),
(25, 3, '¿Cómo se llama el proceso por el cual las plantas producen su propio alimento usando la luz solar?', 10, 1, 1),
(26, 3, '¿Cuántos corazones tiene un pulpo?', 10, 1, 1),
(27, 3, '¿Cuál es el animal terrestre más grande del mundo?', 10, 1, 1),
(28, 3, '¿Cuál es la velocidad aproximada de la luz en el vacío?', 10, 1, 1),
(29, 3, '¿Qué orgánulo es conocido como la \"central energética\" de la célula?', 10, 1, 1),
(30, 3, '¿Qué científico propuso la teoría de la relatividad general?', 10, 1, 1),
(31, 4, '¿Cuál es el río más largo del mundo?', 10, 1, 1),
(32, 4, '¿En qué continente se encuentra Argentina?', 10, 1, 1),
(33, 4, '¿Cuál es la capital de Italia?', 10, 1, 1),
(34, 4, '¿Cuál es el desierto cálido más grande del mundo?', 10, 1, 1),
(35, 4, '¿Qué país tiene la mayor cantidad de islas en el mundo?', 10, 1, 1),
(36, 4, '¿En qué país se encuentra el Monte Everest, la montaña más alta del mundo?', 10, 1, 1),
(37, 4, '¿Cuál es el lago más profundo del mundo, ubicado en Siberia?', 10, 1, 1),
(38, 4, '¿Cuál es la capital de Australia?', 10, 1, 1),
(39, 4, '¿Qué es la Fosa de las Marianas?', 10, 1, 1),
(40, 4, '¿Qué dos países comparten la isla de La Española en el Caribe?', 10, 1, 1),
(41, 5, '¿Qué significa la sigla HTML en desarrollo web?', 10, 1, 1),
(42, 5, '¿Cuál de estos es un lenguaje de programación orientado a objetos: HTML, CSS o Java?', 10, 1, 1),
(43, 5, '¿Qué símbolo se usa para comentarios de una sola línea en lenguajes como Java, C# y JavaScript?', 10, 1, 1),
(44, 5, '¿Qué es una variable en programación?', 10, 1, 1),
(45, 5, '¿Para qué se utiliza comúnmente el comando \"git clone\"?', 10, 1, 1),
(46, 5, '¿Qué significa API?', 10, 1, 1),
(47, 5, '¿En qué paradigma de programación los objetos son la principal abstracción?', 10, 1, 1),
(48, 5, '¿Qué es la recursividad en el contexto de la programación?', 10, 1, 1),
(49, 5, '¿Cuál es la diferencia principal entre \"==\" y \"===\" en JavaScript?', 10, 1, 1),
(50, 5, '¿Qué patrón de diseño utiliza una interfaz para crear familias de objetos relacionados sin especificar sus clases concretas?', 10, 1, 1),
(51, 6, '¿Cuánto es 9 multiplicado por 7?', 10, 1, 1),
(52, 6, '¿Cómo se llama un polígono que tiene 5 lados?', 10, 1, 1),
(53, 6, 'Si tienes 30 manzanas y te comes la mitad, ¿cuántas te quedan?', 10, 1, 1),
(54, 6, '¿Cuál es el valor del número Pi ($pi$) redondeado a dos decimales?', 10, 1, 1),
(55, 6, '¿Cuál es la raíz cuadrada de 144?', 10, 1, 1),
(56, 6, '¿Cuánto suman los ángulos internos de cualquier triángulo?', 10, 1, 1),
(57, 6, '¿Qué teorema establece que en un triángulo rectángulo, el cuadrado de la hipotenusa es igual a la suma de los cuadrados de los catetos?', 10, 1, 1),
(58, 6, '¿Qué es un número primo?', 10, 1, 1),
(59, 6, '¿Cuál es el resultado de 2 elevado a la potencia de 10 (2^10)?', 10, 1, 1),
(60, 6, '¿Qué es el factorial de 5 (representado como 5!)?', 10, 1, 1);

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
(240, 60, '100', 0);

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
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `preguntaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

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
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`preguntaId`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
