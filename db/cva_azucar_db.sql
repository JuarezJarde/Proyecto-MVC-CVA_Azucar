-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2025 a las 02:45:08
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
-- Base de datos: `cva_azucar_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `id_log` int(11) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario` varchar(100) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id_log`, `fecha_hora`, `usuario`, `accion`, `detalles`) VALUES
(1, '2025-12-06 22:28:12', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(2, '2025-12-06 22:30:15', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(3, '2025-12-06 22:42:46', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(4, '2025-12-06 22:45:28', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(5, '2025-12-06 22:45:35', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(6, '2025-12-06 22:47:45', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(7, '2025-12-06 22:47:50', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(8, '2025-12-06 22:51:31', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(9, '2025-12-06 23:21:37', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(10, '2025-12-06 23:24:10', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(11, '2025-12-06 23:24:14', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(12, '2025-12-06 23:30:15', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(13, '2025-12-06 23:30:22', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(14, '2025-12-06 23:30:25', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(15, '2025-12-06 23:31:05', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(16, '2025-12-07 00:52:01', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(17, '2025-12-07 00:52:19', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(18, '2025-12-07 02:10:56', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(19, '2025-12-07 02:12:43', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(20, '2025-12-07 02:13:00', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(21, '2025-12-07 02:13:06', 'admin', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(22, '2025-12-07 02:13:19', 'admin', 'Logout', 'Cierre de sesión correcto.'),
(23, '2025-12-07 02:13:24', 'usuario', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(24, '2025-12-07 02:14:11', 'usuario', 'Logout', 'Cierre de sesión correcto.'),
(25, '2025-12-07 02:14:19', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(26, '2025-12-07 02:31:27', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(27, '2025-12-09 03:37:05', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1'),
(28, '2025-12-09 17:27:22', 'Super Administrador', 'Logout', 'Cierre de sesión correcto.'),
(29, '2025-12-09 17:28:13', 'Super Administrador', 'Login Exitoso', 'Inicio de sesión desde IP: ::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_web`
--

CREATE TABLE `configuracion_web` (
  `id_configuracion` int(11) NOT NULL,
  `color_principal` varchar(20) DEFAULT '#66AC4C',
  `color_texto_header` varchar(20) DEFAULT '#ffffff',
  `titulo_sitio` varchar(100) DEFAULT 'CVA Azúcar',
  `mision_texto` text DEFAULT NULL,
  `vision_texto` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT '0251-1234567',
  `email_contacto` varchar(50) DEFAULT 'contacto@cvaazucar.com'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion_web`
--

INSERT INTO `configuracion_web` (`id_configuracion`, `color_principal`, `color_texto_header`, `titulo_sitio`, `mision_texto`, `vision_texto`, `telefono`, `email_contacto`) VALUES
(1, '#66ac4c', '#ffffff', 'CVA Azúcar', NULL, NULL, '0251-1234567', 'contacto@cvaazucar.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_departamentos`
--

CREATE TABLE `config_departamentos` (
  `id_departamento` int(11) NOT NULL,
  `nombre_departamento` varchar(100) NOT NULL,
  `prefijo` varchar(5) NOT NULL,
  `sufijo` varchar(5) NOT NULL DEFAULT 'X',
  `estatus` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `config_departamentos`
--

INSERT INTO `config_departamentos` (`id_departamento`, `nombre_departamento`, `prefijo`, `sufijo`, `estatus`) VALUES
(1, 'Contabilidad', 'CNT', 'X', 1),
(2, 'Recursos Humanos', 'RRHH', 'X', 1),
(3, 'Tecnología', 'TI', 'X', 1),
(4, 'Tesorería', 'TES', 'X', 1),
(5, 'Informática', 'INF', 'X', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` varchar(50) DEFAULT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `cantidad_stock` int(11) DEFAULT 0,
  `unidad_medida` varchar(20) DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_codigos`
--

CREATE TABLE `inventario_codigos` (
  `id_codigo` int(11) NOT NULL,
  `codigo_completo` varchar(20) NOT NULL,
  `prefijo` varchar(5) NOT NULL,
  `numero_secuencia` int(11) NOT NULL,
  `sufijo` varchar(5) DEFAULT NULL,
  `nombre_formato` varchar(100) NOT NULL,
  `modulo_sistema` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_codigos`
--

INSERT INTO `inventario_codigos` (`id_codigo`, `codigo_completo`, `prefijo`, `numero_secuencia`, `sufijo`, `nombre_formato`, `modulo_sistema`, `fecha_creacion`) VALUES
(1, 'CNT0001-X', 'CNT', 1, 'X', 'Solicitud de Vacaciones', 'Contabilidad', '2025-12-09 21:39:07'),
(2, 'TES0001-X', 'TES', 1, 'X', 'Solicitud de Vacaciones', 'Tesorería', '2025-12-09 21:39:14');

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
(2, 'Administrador'),
(1, 'SuperUsuario'),
(3, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion_servicio` text DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `titulo`, `descripcion_servicio`, `imagen_url`, `activo`) VALUES
(1, 'Materia Prima', 'Caña de Azúcar sin Procesar.', '../Assets/Images/servicios/1765056450_Caña.jpg', 1),
(2, 'Producto', 'Bultos de Azúcar Refinada (30 Kg. x Bulto).\r\n\r\n', '../Assets/Images/servicios/1765056468_Azucar Refinada.jpg', 1),
(3, 'Procesos', 'Trituración de caña de Azúcar.\r\n\r\n', '../Assets/Images/servicios/1765056487_Trituradora.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_registro`
--

CREATE TABLE `solicitudes_registro` (
  `id_solicitud` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','rechazado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes_registro`
--

INSERT INTO `solicitudes_registro` (`id_solicitud`, `nombre_completo`, `correo`, `password`, `fecha_solicitud`, `estado`) VALUES
(1, 'prueba', 'prueba@gmail.com', '$2y$10$5jRNe7RQLwQT.aznKYtHke22JR1jK4mEyA0Pc9r1JM3bWBBeslMlm', '2025-12-06 22:11:06', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `estatus` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `password`, `nombre_completo`, `correo`, `id_rol`, `fecha_creacion`, `estatus`, `fecha_registro`) VALUES
(1, 'super@gmail.com', '$2y$10$CwhKy5Gi.SPQICS0oinOHeI3kSvV3fqiDCO.70f5neZz1QpeOV2fC', 'Super Administrador', 'super@gmail.com', 1, '2025-11-29 23:21:21', 'activo', '2025-12-06 20:12:00'),
(2, 'usuario@gmail.com', '$2y$10$HubUdzny.Mxcm9IV5tqCH.1AJPAmGCMYTKTknRiOtog3U6VVEzVzm', 'usuario', 'usuario@gmail.com', 3, '2025-12-01 00:51:09', 'activo', '2025-12-06 20:12:00'),
(3, 'admin@gmail.com', '$2y$10$g.tHbTFs7SClmGwfYfJ85eNwqoVQXkcmlscJwlglDl/N9jrrHggF.', 'admin', 'admin@gmail.com', 2, '2025-12-01 10:46:46', 'activo', '2025-12-06 20:12:00'),
(4, 'mes@gmail.com', '$2y$10$NyMt.DZBSvEGaHbDfGu4L.kCXDQBUZup/epB1h.EVA8dtF9b4j4TG', 'mes', 'mes@gmail.com', 3, '2025-12-06 22:12:50', 'activo', '2025-11-27 22:12:50');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `configuracion_web`
--
ALTER TABLE `configuracion_web`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `config_departamentos`
--
ALTER TABLE `config_departamentos`
  ADD PRIMARY KEY (`id_departamento`),
  ADD UNIQUE KEY `nombre_departamento` (`nombre_departamento`),
  ADD UNIQUE KEY `nombre_departamento_2` (`nombre_departamento`),
  ADD UNIQUE KEY `nombre_departamento_3` (`nombre_departamento`),
  ADD UNIQUE KEY `prefijo` (`prefijo`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo_producto` (`codigo_producto`);

--
-- Indices de la tabla `inventario_codigos`
--
ALTER TABLE `inventario_codigos`
  ADD PRIMARY KEY (`id_codigo`),
  ADD UNIQUE KEY `codigo_completo` (`codigo_completo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `solicitudes_registro`
--
ALTER TABLE `solicitudes_registro`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `configuracion_web`
--
ALTER TABLE `configuracion_web`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `config_departamentos`
--
ALTER TABLE `config_departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inventario_codigos`
--
ALTER TABLE `inventario_codigos`
  MODIFY `id_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitudes_registro`
--
ALTER TABLE `solicitudes_registro`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
