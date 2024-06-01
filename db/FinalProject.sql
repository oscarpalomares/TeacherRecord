-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-05-2024 a las 19:55:36
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `FinalProject`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Admins`
--

CREATE TABLE `Admins` (
  `FirstName` varchar(20) NOT NULL,
  `FirstSurname` varchar(20) NOT NULL,
  `SecondSurname` varchar(20) NOT NULL,
  `Birthday` date NOT NULL,
  `Age` int(3) NOT NULL,
  `Sex` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ID` varchar(10) NOT NULL,
  `SuperUser` tinyint(1) DEFAULT 0,
  `Photo` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Assignments`
--

CREATE TABLE `Assignments` (
  `ID` int(255) NOT NULL,
  `AssignmentName` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Classes`
--

CREATE TABLE `Classes` (
  `ID` int(255) NOT NULL,
  `ClassroomNumber` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Shift`
--

CREATE TABLE `Shift` (
  `ShiftField` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Teacher`
--

CREATE TABLE `Teacher` (
  `FirstName` varchar(50) NOT NULL,
  `FirstSurname` varchar(50) NOT NULL,
  `SecondSurname` varchar(50) NOT NULL,
  `Birthday` date NOT NULL,
  `Age` int(3) NOT NULL,
  `Career` varchar(50) NOT NULL,
  `Adress` varchar(100) DEFAULT NULL,
  `PhoneNumber` int(15) NOT NULL,
  `Sex` varchar(50) NOT NULL,
  `MaritalStatus` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ID` varchar(50) NOT NULL,
  `Classes` longtext NOT NULL,
  `Assignments` longtext NOT NULL,
  `Shift` longtext NOT NULL,
  `Photo` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Assignments`
--
ALTER TABLE `Assignments`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Classes`
--
ALTER TABLE `Classes`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Teacher`
--
ALTER TABLE `Teacher`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Assignments`
--
ALTER TABLE `Assignments`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Classes`
--
ALTER TABLE `Classes`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
