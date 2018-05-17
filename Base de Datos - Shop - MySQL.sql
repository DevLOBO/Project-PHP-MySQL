-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-04-2018 a las 01:39:57
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shop`
--
CREATE DATABASE IF NOT EXISTS `shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `shop`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `ID` varchar(16) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `MadeBy` varchar(30) NOT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Description` varchar(250) NOT NULL DEFAULT 'Descripción no disponible',
  `Price` decimal(8,2) NOT NULL,
  `Stock` tinyint(4) NOT NULL,
  `SectionID` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `SectionID` (`SectionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `article`
--

INSERT INTO `article` (`ID`, `Name`, `MadeBy`, `Image`, `Description`, `Price`, `Stock`, `SectionID`) VALUES
('157946253-1L', 'Romeo y Julieta', 'William Shakespeare', 'Images/RomeoYJulieta.jpg', 'Descripción no disponible', '36.00', 27, 1),
('873442100-1L', 'El Jugador', 'Fyodor Dostoievsky', 'Images/ElJugador.jpg', 'Descripción no disponible', '187.00', 29, 1),
('720136998-4M', 'Toxicity', 'System of a Down', 'Images/Toxicity.jpg', 'Descripción no disponible', '269.00', 30, 4),
('971425320-4M', 'Demon Days', 'Gorillaz', 'Images/DemonDays.jpg', 'Descripción no disponible', '235.00', 30, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articlebought`
--

DROP TABLE IF EXISTS `articlebought`;
CREATE TABLE IF NOT EXISTS `articlebought` (
  `ID` varchar(16) NOT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `Quantity` smallint(6) NOT NULL,
  `Subtotal` decimal(8,2) NOT NULL,
  `TicketID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `TicketID` (`TicketID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `SectionID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `SectionName` varchar(30) NOT NULL,
  PRIMARY KEY (`SectionID`),
  UNIQUE KEY `SectionName` (`SectionName`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `section`
--

INSERT INTO `section` (`SectionID`, `SectionName`) VALUES
(1, 'Librería'),
(2, 'Deportes'),
(3, 'Electrónica'),
(4, 'Música');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `TicketID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Total` decimal(9,2) NOT NULL,
  `DateTicket` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserID` tinyint(4) NOT NULL,
  PRIMARY KEY (`TicketID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--
-- Base de datos: `user`
--
CREATE DATABASE IF NOT EXISTS `user` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `user`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Nickname` varchar(30) NOT NULL,
  `Password` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Nickname` (`Nickname`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `administrator`
--

INSERT INTO `administrator` (`ID`, `Nickname`, `Password`) VALUES
(1, 'Ángel', 'ING97');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Nickname` varchar(30) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Wallet` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Nickname` (`Nickname`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`ID`, `Nickname`, `Password`, `Wallet`) VALUES
(1, 'Franco', '123', '215.00'),
(2, 'Victor', 'abc', '0.00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
