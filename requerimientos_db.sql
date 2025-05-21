-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2025 a las 16:24:47
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `requerimientos_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `nombre_persona` varchar(255) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `cantidad_entregada` int(11) DEFAULT NULL,
  `fecha_entrega` timestamp NOT NULL DEFAULT current_timestamp(),
  `almacen` varchar(20) NOT NULL,
  `producto_nombre` varchar(255) NOT NULL,
  `estado_producto` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'Disponible',
  `dni` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`id`, `producto_id`, `nombre_persona`, `contacto`, `cantidad_entregada`, `fecha_entrega`, `almacen`, `producto_nombre`, `estado_producto`, `estado`, `dni`) VALUES
(1, 2, 'Profesor Valdivia', '976852369', 1, '2025-04-08 22:04:13', 'requerimientos_db1', 'Libro de Matematicas', 'Entregado', 'Disponible', ''),
(2, 4, 'Profesor de Computo', '977894561', 1, '2025-04-08 22:05:08', 'requerimientos_db2', 'Computadoras', 'Devuelto', 'Disponible', ''),
(3, 1, 'Profesora Anna', '999912345', 1, '2025-04-08 22:05:46', 'requerimientos_db1', 'Libro de Comunicacion', 'Devuelto', 'Disponible', ''),
(4, 2, 'Profesor Valdivia', '976852369', 1, '2025-04-12 17:39:22', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(5, 10, 'Personal de Limpieza', '99999992', 1, '2025-04-14 14:49:27', 'requerimientos_db4', 'Legia Sapolio', NULL, 'Cantidad entregada: 1 - Entregado', ''),
(6, 10, 'Señora Lucy', '99999988', 1, '2025-04-14 14:58:42', 'requerimientos_db4', 'Legia Sapolio', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(7, 10, 'Señora Lucy', '99999988', 1, '2025-04-14 14:59:14', 'requerimientos_db4', '', 'Devuelto', 'Disponible', ''),
(8, 3, 'Gallardo Cieza', '99999992', 1, '2025-04-15 22:42:59', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(9, 3, 'Gallardo Cieza', '99999992', 1, '2025-04-15 22:43:14', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(10, 1, 'Gonzalo', '99999999', 1, '2025-04-21 15:13:14', 'requerimientos_db1', 'Libro de Comunicacion', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(11, 1, 'Gonzalo', '99999999', 1, '2025-04-21 15:13:23', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(12, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:13:51', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(13, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:14:12', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(14, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:32:43', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(15, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:33:18', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(16, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:35:11', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(17, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:37:05', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(18, 2, 'Profesor Valdivia', '976852369', 1, '2025-04-21 15:38:56', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(19, 1, 'Gonzalo', '99999999', 1, '2025-04-21 15:39:07', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(20, 2, 'Profesor Valdivia', '976852369', 1, '2025-04-21 15:39:08', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(21, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:39:09', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(22, 1, 'Gonzalo', '99999999', 1, '2025-04-21 15:40:58', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(23, 1, 'Gonzalo', '99999999', 1, '2025-04-21 15:42:36', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(24, 1, 'Gonzalo', '99999999', 1, '2025-04-21 15:43:57', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(25, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:44:41', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(26, 3, 'Profesor Valdivia', '99999999', 1, '2025-04-21 15:51:11', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(27, 3, 'GALLARDO', '99999999', 1, '2025-04-21 15:55:34', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(28, 3, 'GALLARDO', '99999999', 1, '2025-04-21 15:55:41', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(29, 3, 'Psicologa', '999912345', 1, '2025-04-21 16:03:58', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(30, 3, 'Psicologa', '999912345', 1, '2025-04-21 16:04:07', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(31, 3, 'Profesor Valdivia', '99999992', 1, '2025-04-21 16:57:50', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(32, 3, 'Profesor Valdivia', '99999992', 1, '2025-04-21 17:03:38', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(33, 1, 'Gonzalo', '99999999', 1, '2025-04-24 15:09:12', 'requerimientos_db1', 'Libro de Comunicacion', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(34, 1, 'Gonzalo', '99999999', 1, '2025-04-24 15:09:32', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(35, 6, 'GALLARDO', '99999999', 1, '2025-04-24 15:10:06', 'requerimientos_db2', 'Router', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(36, 6, 'GALLARDO', '99999999', 1, '2025-04-24 17:34:07', 'requerimientos_db2', '', 'Devuelto', 'Disponible', ''),
(37, 6, 'Gonzalo', '99999999', 1, '2025-04-24 17:37:04', 'requerimientos_db2', 'Router', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(38, 6, 'Gonzalo', '99999999', 1, '2025-04-24 17:38:50', 'requerimientos_db2', '', 'Devuelto', 'Disponible', ''),
(39, 6, 'Gonzalo', '99999999', 1, '2025-04-24 17:41:58', 'requerimientos_db2', 'Router', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(40, 6, 'Gonzalo', '99999999', 1, '2025-04-24 17:42:04', 'requerimientos_db2', '', 'Devuelto', 'Disponible', ''),
(41, 6, 'GALLARDO', '99999999', 1, '2025-04-24 17:45:36', 'requerimientos_db2', 'Router', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(42, 6, 'GALLARDO', '99999999', 1, '2025-04-24 17:45:44', 'requerimientos_db2', '', 'Devuelto', 'Disponible', ''),
(43, 3, 'GALLARDO', '99999999', 1, '2025-04-29 14:07:57', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(44, 3, 'GALLARDO', '99999999', 1, '2025-04-29 15:10:27', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(45, 18, 'Profesor Valdivia', '976852369', 1, '2025-04-29 15:36:51', 'requerimientos_db1', 'Libro de Historia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(46, 18, 'Profesor Valdivia', '976852369', 1, '2025-04-30 22:21:12', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(47, 3, 'GALLARDO', '99999999', 1, '2025-05-05 15:25:43', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(48, 3, 'GALLARDO', '99999999', 1, '2025-05-05 15:25:45', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(49, 3, 'GALLARDO', '99999999', 1, '2025-05-05 15:36:13', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(50, 3, 'GALLARDO', '99999999', 1, '2025-05-05 15:36:15', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(51, 3, 'GALLARDO', '99999999', 1, '2025-05-05 15:44:28', 'requerimientos_db1', 'Libro de Psicologia', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(52, 3, 'GALLARDO', '99999999', 1, '2025-05-05 15:44:32', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(53, 20, 'GALLARDO', '99999999', 2, '2025-05-05 16:26:39', 'requerimientos_db1', 'comunicacion', 'Entregado', 'Cantidad entregada: 2 - Entregado', ''),
(54, 20, 'GALLARDO', '99999999', 2, '2025-05-05 16:28:29', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(55, 21, 'Profesor Sergio', '99999992', 1, '2025-05-05 22:18:16', 'requerimientos_db8', 'Peine', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(56, 20, 'Zaikon', '99999992', 1, '2025-05-07 14:26:23', 'requerimientos_db1', 'comunicacion', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(57, 20, 'Zaikon', '99999992', 1, '2025-05-07 14:26:31', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(58, 17, 'Profesor Valdivia', '99999999', 1, '2025-05-07 14:50:42', 'requerimientos_db6', 'Guitarra', 'Entregado', 'Cantidad entregada: 1 - Entregado', ''),
(59, 20, 'ZAIKON', '999912345', 1, '2025-05-08 14:21:37', 'requerimientos_db1', 'comunicacion', 'Entregado', 'Cantidad entregada: 1 - Entregado', '66666666'),
(60, 20, 'ZAIKON', '999912345', 1, '2025-05-08 14:31:18', 'requerimientos_db1', '', 'Devuelto', 'Disponible', ''),
(61, 20, 'ZAIKON', '99999992', 1, '2025-05-08 14:37:01', 'requerimientos_db1', 'comunicacion', 'Entregado', 'Cantidad entregada: 1 - Entregado', '66661232'),
(62, 20, 'ZAIKON', '99999992', 1, '2025-05-08 14:48:45', 'requerimientos_db1', '', 'Devuelto', 'Disponible', '66661232'),
(63, 20, 'Zaikon', '99999999', 1, '2025-05-08 14:49:57', 'requerimientos_db1', 'comunicacion', 'Entregado', 'Cantidad entregada: 1 - Entregado', '66666666'),
(64, 20, 'Zaikon', '99999999', 1, '2025-05-08 16:50:12', 'requerimientos_db1', '', 'Devuelto', 'Disponible', '66666666'),
(65, 20, 'GALLARDO', '99999999', 1, '2025-05-08 17:02:31', 'requerimientos_db1', 'comunicacion', 'Entregado', 'Cantidad entregada: 1 - Entregado', '66666666');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_entregas`
--

CREATE TABLE `historial_entregas` (
  `id` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contacto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_entrega` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_impresiones`
--

CREATE TABLE `historial_impresiones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `entregado_a` varchar(100) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `clase_producto` varchar(50) NOT NULL,
  `descripcion_producto` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 0,
  `almacen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre_producto`, `clase_producto`, `descripcion_producto`, `cantidad`, `almacen`) VALUES
(1, 'Libro de Comunicación', '1', 'Nuevos', 3, 'requerimientos_db1'),
(2, 'Libro de Matemáticas', '1', 'Nuevos', 9, 'requerimientos_db1'),
(3, 'Libro de Psicologia', '1', 'usado', 2, 'requerimientos_db1'),
(4, 'Computadoras', '2', 'Operativo', 19, 'requerimientos_db2'),
(5, 'Proyector', '2', 'Operativo', 2, 'requerimientos_db2'),
(6, 'Router', '2', 'Operativo', 1, 'requerimientos_db2'),
(7, 'Pelota de futbol', '3', 'Inflado', 1, 'requerimientos_db3'),
(8, 'Pelota de voley', '3', 'Inflado', 1, 'requerimientos_db3'),
(9, 'Net de Voley', '3', 'Nuevo', 1, 'requerimientos_db3'),
(10, 'Legia Sapolio', '4', 'Galón Sellado', 3, 'requerimientos_db4'),
(11, 'Escoba', '4', 'Nuevo', 10, 'requerimientos_db4'),
(12, 'CARPETA 01', '5', 'Nuevo', 1, 'requerimientos_db5'),
(13, 'CARPETA 02', '5', 'Nuevo', 1, 'requerimientos_db5'),
(14, 'CARPETA 03', '5', 'Nuevo', 1, 'requerimientos_db5'),
(15, 'CARPETA 04', '5', 'Nuevo', 1, 'requerimientos_db5'),
(16, 'Piano', '6', 'Operativo', 1, 'requerimientos_db6'),
(17, 'Guitarra', '6', 'Operativa', 0, 'requerimientos_db6'),
(18, 'Libro de Historia', '1', 'perdido', 2, 'requerimientos_db1'),
(19, 'mouse', '2', 'Operativo', 2, 'requerimientos_db2'),
(20, 'comunicacion', '1', 'Nuevo', 4, 'requerimientos_db1'),
(21, 'Peine', '8', 'Nuevo', 0, 'requerimientos_db8'),
(22, 'Amigo', '9', 'Especial ', 1, 'requerimientos_db9'),
(23, 'Libro de Actividades', '1', 'Nuevo', 1, 'requerimientos_db1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimientos`
--

CREATE TABLE `requerimientos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_u` enum('user','admin') DEFAULT 'user',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user_name`, `password`, `role_u`, `fecha_creacion`) VALUES
(1, 'gonzalo', '$2y$10$3ewFg64oZ9oh.3HGt6DwlO9hdZPqPGgKS6TqmKVmdgn2VB/o7.ddS', 'admin', '2025-05-13 21:27:36'),
(2, 'gallardo', '$2y$10$HlFExpJlQlAsVF6yp5PPX.s4aMMlrBT6Th1KH6QF8tTyZGwdm/ShG', 'user', '2025-05-13 21:30:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `historial_entregas`
--
ALTER TABLE `historial_entregas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_impresiones`
--
ALTER TABLE `historial_impresiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `requerimientos`
--
ALTER TABLE `requerimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `historial_entregas`
--
ALTER TABLE `historial_entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_impresiones`
--
ALTER TABLE `historial_impresiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `requerimientos`
--
ALTER TABLE `requerimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `entregas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `historial_impresiones`
--
ALTER TABLE `historial_impresiones`
  ADD CONSTRAINT `historial_impresiones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `requerimientos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
