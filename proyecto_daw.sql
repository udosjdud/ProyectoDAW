-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 18:16:35
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
-- Base de datos: `proyecto_daw`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacios_trabajos`
--

CREATE TABLE `espacios_trabajos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `id_propietario` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `background_img` text DEFAULT 'NB'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `espacios_trabajos`
--

INSERT INTO `espacios_trabajos` (`id`, `titulo`, `id_propietario`, `fecha_creacion`, `background_img`) VALUES
(1, 'prueba', 2, '2025-05-20 19:53:00', 'NB'),
(3, 'Prueba', 1, '2025-05-04 11:59:58', 'NB'),
(4, 'asd', 1, '2025-05-15 15:36:25', 'NB'),
(5, 'zcazxc', 1, '2025-05-15 15:39:14', 'NB'),
(6, 'asdfasd', 1, '2025-05-15 16:52:36', 'NB'),
(7, 'fghdfgdfg', 1, '2025-05-15 17:38:10', 'NB'),
(8, 'dfgdfgdfg', 1, '2025-05-15 17:38:26', 'NB'),
(9, 'asdasdasdasd', 1, '2025-05-15 17:38:46', 'NB'),
(10, 'sdjkgkj ', 1, '2025-05-15 17:39:06', 'NB'),
(11, 'kjdvsbd', 1, '2025-05-15 17:39:10', 'NB'),
(12, 'kvjhsd', 1, '2025-05-15 17:39:14', 'NB'),
(13, 'kujdvgzffd', 1, '2025-05-15 17:39:27', 'NB'),
(14, 'ngngngf', 1, '2025-05-15 17:39:31', 'NB'),
(15, 'nfgnxfgxngf', 1, '2025-05-15 17:39:33', 'NB'),
(16, 'nsgfsnsng', 1, '2025-05-15 17:39:35', 'NB'),
(17, 'gfsnsbsnfg', 1, '2025-05-15 17:39:38', 'NB'),
(18, 'snfgsngfng', 1, '2025-05-15 17:39:41', 'NB'),
(19, 'snsgnsngsngf', 1, '2025-05-15 17:39:44', 'NB'),
(20, 'gsfnnsgsgn', 1, '2025-05-15 17:39:46', 'NB'),
(21, 'sngsngsgn', 1, '2025-05-15 17:39:48', 'NB'),
(22, 'asdlskdfhjsdklfhsidfhisdf hsdh', 1, '2025-05-15 17:46:13', 'NB'),
(23, ' bbnvbn', 1, '2025-05-25 16:43:11', 'NB'),
(24, '     rtdert', 1, '2025-05-25 16:43:17', 'NB'),
(25, 'asdasd', 1, '2025-05-25 16:47:41', 'NB'),
(26, 'asdasdasdads', 1, '2025-05-25 16:47:47', 'NB'),
(27, 'asdasdasdasdfvc', 1, '2025-05-25 16:48:16', 'NB'),
(28, 'asdfgd3', 1, '2025-05-27 19:08:28', 'NB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista`
--

CREATE TABLE `lista` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `id_espacio_trabajo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lista`
--

INSERT INTO `lista` (`id`, `titulo`, `id_espacio_trabajo`) VALUES
(1, 'Pendiente', 3),
(2, 'Pendiente 2', 3),
(3, 'Pendiente', 4),
(4, 'Pendiente 2', 4),
(15, 'fdgdfg', 4),
(16, 'fdgdfgvsvsd', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subtarea`
--

CREATE TABLE `subtarea` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `completado` tinyint(1) DEFAULT 0,
  `id_tarea` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subtarea`
--

INSERT INTO `subtarea` (`id`, `titulo`, `completado`, `id_tarea`) VALUES
(1, 'Prueba', 1, 3),
(2, 'Prueba', 0, 3),
(3, 'Prueba', 1, 5),
(4, 'otro', 0, 5),
(5, 'otra mas', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` date NOT NULL DEFAULT current_timestamp(),
  `fecha_vencimiento` date DEFAULT NULL,
  `id_lista` int(11) DEFAULT NULL,
  `posicion` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento`, `id_lista`, `posicion`) VALUES
(3, 'prueba 3', 'Descripción de prueba para tarea 3', '2025-06-01', NULL, 1, 0),
(5, 'prueba', 'Descripción para prueba ', '2025-06-03', NULL, 1, 1),
(7, 'prueba 3', NULL, '2025-06-03', NULL, 2, 0),
(14, 'asj,mdhjkasd', NULL, '2025-06-04', NULL, 3, 0),
(15, 'vsdvscxv', NULL, '2025-06-04', NULL, 3, 1),
(16, 'xcxcvv', NULL, '2025-06-04', NULL, 3, 2),
(17, 'cxvc', 'asdasd asdad', '2025-06-04', NULL, 4, 0),
(18, 'svsv', NULL, '2025-06-04', NULL, 4, 2),
(19, ',mnbdfg', NULL, '2025-06-04', NULL, 15, 0),
(20, 'xcvx', 'xcvxv', '2025-06-04', NULL, 15, 1),
(21, 'xcvxcvbcvb', 'cxvbbfsbdfb', '2025-06-04', NULL, 15, 2),
(22, 'dfbdfb', 'sdfasdf', '2025-06-04', NULL, 4, 1),
(23, 'ascas', NULL, '2025-06-04', NULL, 16, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `passw` blob NOT NULL,
  `foto_perfil` text DEFAULT 'nd'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `passw`, `foto_perfil`) VALUES
(1, 'Probador', 'pruebas@gmail.com', 0x2432792431302451686d616a50714e414a6c4f7438353751397857462e365437392e746e5372344f6d7a73676c5459352f6558524f3267524754316d, 'nd'),
(2, 'prueba2', 'pruebas2@gmail.com', 0x24327924313024514e4d62664c3563626f706438644e6c4e473230614f66415170614a386652795a4938586e585635676672336475546b65716c7853, 'nd');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `espacios_trabajos`
--
ALTER TABLE `espacios_trabajos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_propietario` (`id_propietario`);

--
-- Indices de la tabla `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_espacio_trabajo` (`id_espacio_trabajo`);

--
-- Indices de la tabla `subtarea`
--
ALTER TABLE `subtarea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tarea` (`id_tarea`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lista` (`id_lista`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `espacios_trabajos`
--
ALTER TABLE `espacios_trabajos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `lista`
--
ALTER TABLE `lista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `subtarea`
--
ALTER TABLE `subtarea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `espacios_trabajos`
--
ALTER TABLE `espacios_trabajos`
  ADD CONSTRAINT `fk_propietario` FOREIGN KEY (`id_propietario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lista`
--
ALTER TABLE `lista`
  ADD CONSTRAINT `fk_espacio_trabajo` FOREIGN KEY (`id_espacio_trabajo`) REFERENCES `espacios_trabajos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subtarea`
--
ALTER TABLE `subtarea`
  ADD CONSTRAINT `subtarea_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tareas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`id_lista`) REFERENCES `lista` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
