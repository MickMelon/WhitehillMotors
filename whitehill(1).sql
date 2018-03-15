-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 15, 2018 at 03:57 PM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `whitehill`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` int(11) NOT NULL,
  `Username` varchar(32) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeID`, `Username`, `Password`) VALUES
(1, 'manager', '$2y$10$OupfvggF6XFynKu5GarkgegL7B7q.jnnl9Cq4Wx/K4SIQtiK4uV7u'),
(2, 'Halpert', '$2y$10$HftkT8gqGKnpXGnUMMIQl.ssY8lHfz7kCjSBRVFfhJ3X3R/A68D.y');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `ManufacturerID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`ManufacturerID`, `Name`) VALUES
(1, 'Volkswagen'),
(2, 'Audi'),
(3, 'Seat'),
(4, 'Skoda'),
(5, 'BMW'),
(6, 'Vauxhall'),
(7, 'Nissan'),
(8, 'Peugeot'),
(9, 'Renault'),
(10, 'Kia'),
(11, 'Hyundai'),
(12, 'Ford'),
(13, 'Fiat'),
(14, 'Citroen'),
(15, 'Honda'),
(16, 'Jeep'),
(17, 'Land Rover'),
(18, 'Mazda'),
(19, 'Mercedes-Benz'),
(20, 'Toyota');

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `ModelID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `ManufacturerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`ModelID`, `Name`, `ManufacturerID`) VALUES
(1, 'Golf', 1),
(2, 'Passat', 1),
(3, 'Scirocco', 1),
(4, 'A1', 2),
(5, 'A2', 2),
(6, 'A3', 2),
(7, 'A4', 2),
(8, 'Leon', 3),
(9, 'Ibiza', 3),
(10, 'Octavia', 4),
(11, 'Fabia', 4),
(12, 'M1', 5),
(13, 'M5', 5),
(14, 'Corsa', 6),
(15, 'Astra', 6),
(16, 'Vectra', 6),
(17, 'Skyline', 7),
(18, 'Micra', 7),
(19, '106', 8),
(20, '206', 8),
(21, 'Clio', 9),
(22, 'Kangoo', 9),
(23, 'Cee\'d', 10),
(24, 'Picanto', 10),
(25, 'Sportage', 10),
(26, 'i30', 11),
(27, 'Focus', 12),
(28, 'Fiesta', 12),
(29, 'Punto', 13),
(30, '500', 13),
(31, '500X', 13),
(32, '500L', 13),
(33, 'Picasso', 14),
(34, 'C4', 14),
(35, 'Saxo', 14),
(36, 'Civic', 15),
(37, 'Accord', 15),
(38, 'Renegade', 16),
(39, 'Range Rover', 17),
(40, 'MX5', 18),
(41, 'SLK', 19),
(42, 'C63', 19),
(43, 'Yaris', 20),
(44, 'Picnic', 20),
(45, 'Prius', 20);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewID` int(11) NOT NULL,
  `CustomerName` varchar(64) NOT NULL,
  `ReviewText` text NOT NULL,
  `Rating` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0',
  `DateReviewed` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`ReviewID`, `CustomerName`, `ReviewText`, `Rating`, `EmployeeID`, `Approved`, `DateReviewed`) VALUES
(8, 'John Lennon', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 4, 1, 1, '2018-03-14');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `VehicleID` int(11) NOT NULL,
  `ModelID` int(11) NOT NULL,
  `Engine` float NOT NULL,
  `Year` int(11) NOT NULL,
  `Registration` varchar(24) NOT NULL,
  `Mileage` int(11) NOT NULL,
  `FuelType` varchar(32) NOT NULL,
  `Condition` varchar(32) NOT NULL,
  `Features` text NOT NULL,
  `Description` text NOT NULL,
  `Price` float NOT NULL,
  `Sold` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`VehicleID`, `ModelID`, `Engine`, `Year`, `Registration`, `Mileage`, `FuelType`, `Condition`, `Features`, `Description`, `Price`, `Sold`) VALUES
(1, 1, 2, 2007, 'SA07ENW', 116000, 'Diesel', 'Used', 'Wheels, tyres, and all that jazz', '', 2800, 1),
(2, 10, 1.4, 2013, 'SA12JYF', 50432, 'Diesel', 'Used', 'nothing', 'nothing', 8992.98, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`ManufacturerID`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`ModelID`),
  ADD KEY `ManufacturerID` (`ManufacturerID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`VehicleID`),
  ADD KEY `ModelID` (`ModelID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `ManufacturerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `ModelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `VehicleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`ManufacturerID`) REFERENCES `manufacturer` (`ManufacturerID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`ModelID`) REFERENCES `model` (`ModelID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
