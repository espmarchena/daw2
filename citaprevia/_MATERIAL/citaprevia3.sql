-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2024 a las 08:38:53
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `citaprevia3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `idcita` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idespecialista` int(11) NOT NULL,
  `descripcion` longtext DEFAULT NULL,
  `archivo` varchar(100) DEFAULT NULL,
  `fechacita` date NOT NULL,
  `horacita` time NOT NULL,
  `confirmada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idcita`, `idusuario`, `idespecialista`, `descripcion`, `archivo`, `fechacita`, `horacita`, `confirmada`) VALUES
(1, 1, 40, 'sadsadsadasdasd', 'documentacion_1705657253.png', '2024-01-25', '10:10:00', 0),
(2, 1, 41, 'sadadsad', 'documentacion_1705917952.pdf', '2024-01-24', '15:05:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `idespecialidad` int(11) NOT NULL,
  `especialidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`idespecialidad`, `especialidad`) VALUES
(1, 'Cardiología'),
(2, 'Dermatología'),
(3, 'Endocrinología'),
(4, 'Gastroenterología'),
(5, 'Geriatría'),
(6, 'Ginecología'),
(7, 'Hematología'),
(8, 'Infectología'),
(9, 'Nefrología'),
(10, 'Neumología'),
(11, 'Neurología'),
(12, 'Nutrición'),
(13, 'Oftalmología'),
(14, 'Oncología'),
(15, 'Ortopedia'),
(16, 'Otorrinolaringología'),
(17, 'Pediatría'),
(18, 'Psiquiatría'),
(19, 'Reumatología'),
(20, 'Urología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialistas`
--

CREATE TABLE `especialistas` (
  `idespecialista` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `idespecialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialistas`
--

INSERT INTO `especialistas` (`idespecialista`, `nombre`, `apellido1`, `apellido2`, `idespecialidad`) VALUES
(1, 'Ana', 'González', 'López', 1),
(2, 'Luis', 'Martín', 'Santos', 1),
(3, 'María', 'Jiménez', 'Torres', 1),
(4, 'Carlos', 'Ruiz', 'García', 2),
(5, 'Sonia', 'Moreno', 'Pérez', 2),
(6, 'David', 'Gómez', 'Lorenzo', 2),
(7, 'Cristina', 'Navarro', 'Gil', 3),
(8, 'Pablo', 'Díaz', 'Moreno', 3),
(9, 'Patricia', 'Romero', 'Cano', 3),
(10, 'Jorge', 'Lorenzo', 'Molina', 4),
(11, 'Laura', 'Hernández', 'Alvarez', 4),
(12, 'Roberto', 'Cano', 'Lozano', 4),
(13, 'Elena', 'Castro', 'Navas', 5),
(14, 'Raúl', 'Ortega', 'Serrano', 5),
(15, 'Sara', 'Rubio', 'Morales', 5),
(16, 'Nora', 'Vázquez', 'Ruiz', 6),
(17, 'Óscar', 'Blanco', 'Quintana', 6),
(18, 'Patricia', 'Herrera', 'Giménez', 6),
(19, 'Rodrigo', 'Castaño', 'Martínez', 7),
(20, 'Susana', 'Iglesias', 'Fernández', 7),
(21, 'Tomas', 'Cortés', 'Navarro', 7),
(22, 'Úrsula', 'Rey', 'Garrido', 8),
(23, 'Víctor', 'Sánchez', 'Pérez', 8),
(24, 'Yolanda', 'Torres', 'Delgado', 8),
(25, 'Zoe', 'Nieto', 'Vega', 9),
(26, 'Adrián', 'Molina', 'Rojas', 9),
(27, 'Beatriz', 'Campos', 'Cano', 9),
(28, 'César', 'Guerrero', 'Soto', 10),
(29, 'Diana', 'Prieto', 'González', 10),
(30, 'Eduardo', 'Vidal', 'Méndez', 10),
(31, 'Fabiola', 'Aguilar', 'Santana', 11),
(32, 'Gabriel', 'Pascual', 'Sánchez', 11),
(33, 'Hilda', 'Silva', 'Barajas', 11),
(34, 'Iñigo', 'Arias', 'López', 12),
(35, 'Jaime', 'Benítez', 'Ortiz', 12),
(36, 'Karla', 'Cabrera', 'Ruiz', 12),
(37, 'Leonor', 'Domingo', 'Escobar', 13),
(38, 'Manuel', 'Escudero', 'Gil', 13),
(39, 'Noelia', 'Ferrer', 'Santos', 13),
(40, 'Olga', 'Gálvez', 'Prieto', 14),
(41, 'Pablo', 'Hernando', 'Crespo', 14),
(42, 'Quintín', 'Ibarra', 'Méndez', 14),
(43, 'Ramona', 'Jiménez', 'Lara', 15),
(44, 'Samuel', 'Ledesma', 'Núñez', 15),
(45, 'Tania', 'Marín', 'Pascual', 15),
(46, 'Ubaldo', 'Naranjo', 'Muñoz', 16),
(47, 'Verónica', 'Ochoa', 'Palacios', 16),
(48, 'Walter', 'Peña', 'Herrera', 16),
(49, 'Ximena', 'Quirós', 'Lugo', 17),
(50, 'Yago', 'Rivas', 'Costa', 17),
(51, 'Zaira', 'Soto', 'Moreno', 17),
(52, 'Abel', 'Torres', 'Pérez', 18),
(53, 'Blanca', 'Urrutia', 'Velasco', 18),
(54, 'Caetano', 'Vázquez', 'Lobo', 18),
(55, 'Delia', 'Zamora', 'Ponce', 19),
(56, 'Efrén', 'Andrade', 'Cuevas', 19),
(57, 'Fernanda', 'Bravo', 'Domínguez', 19),
(58, 'Gustavo', 'Correa', 'Fernández', 20),
(59, 'Helena', 'Dávila', 'García', 20),
(60, 'Igor', 'Espino', 'Hidalgo', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `fechanacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `usuario`, `clave`, `email`, `fechanacimiento`) VALUES
(1, 'yo', '$2y$10$GeozcKgFICpArbh.fDwAce.GV8Lywja6Q.IttBbkw009kckwIO0D.', 'probando@probando.com', '2011-11-11'),
(2, 'fulano', '$2y$10$GeozcKgFICpArbh.fDwAce.GV8Lywja6Q.IttBbkw009kckwIO0D.', 'fulano@probando.com', '2001-02-23'),
(3, 'pimpam', '$2y$10$GeozcKgFICpArbh.fDwAce.GV8Lywja6Q.IttBbkw009kckwIO0D.', 'dadada@adada.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_especialidades`
--

CREATE TABLE `usuarios_especialidades` (
  `idusuarioespecialidad` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idespecialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_especialidades`
--

INSERT INTO `usuarios_especialidades` (`idusuarioespecialidad`, `idusuario`, `idespecialidad`) VALUES
(1, 1, 5),
(2, 1, 2),
(3, 1, 17),
(4, 1, 8),
(5, 1, 20),
(6, 1, 14),
(7, 1, 3),
(8, 1, 10),
(9, 3, 13),
(10, 3, 9),
(11, 3, 1),
(12, 3, 16),
(13, 3, 7),
(14, 1, 19),
(15, 1, 12),
(16, 1, 6),
(17, 1, 4),
(18, 1, 11),
(19, 2, 20),
(20, 2, 7),
(21, 2, 5),
(22, 2, 9),
(23, 2, 2),
(24, 2, 11),
(25, 2, 18),
(26, 2, 14),
(27, 2, 3),
(28, 2, 13),
(29, 2, 17),
(30, 2, 16),
(31, 2, 8),
(32, 2, 1),
(33, 2, 6),
(34, 2, 10),
(35, 2, 15),
(36, 2, 12);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idcita`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`idespecialidad`);

--
-- Indices de la tabla `especialistas`
--
ALTER TABLE `especialistas`
  ADD PRIMARY KEY (`idespecialista`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `usuarios_especialidades`
--
ALTER TABLE `usuarios_especialidades`
  ADD PRIMARY KEY (`idusuarioespecialidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idcita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `idespecialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `especialistas`
--
ALTER TABLE `especialistas`
  MODIFY `idespecialista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios_especialidades`
--
ALTER TABLE `usuarios_especialidades`
  MODIFY `idusuarioespecialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;