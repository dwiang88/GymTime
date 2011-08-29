-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2011 at 04:41 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `GymTime`
--

-- --------------------------------------------------------

--
-- Table structure for table `Exercise`
--

CREATE TABLE IF NOT EXISTS `Exercise` (
  `ExerciseID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `MuscleGroup` text NOT NULL,
  `Type` int(11) NOT NULL,
  PRIMARY KEY (`ExerciseID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Exercise`
--

INSERT INTO `Exercise` (`ExerciseID`, `Name`, `MuscleGroup`, `Type`) VALUES
(1, 'Barbell Bench Press', 'Chest', 0),
(2, 'Barbell Incline Bench Press', 'Chest', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ExerciseSets`
--

CREATE TABLE IF NOT EXISTS `ExerciseSets` (
  `ExerciseSetsID` int(11) NOT NULL DEFAULT '0',
  `SetID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ExerciseSets`
--

INSERT INTO `ExerciseSets` (`ExerciseSetsID`, `SetID`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Sets`
--

CREATE TABLE IF NOT EXISTS `Sets` (
  `SetsID` int(11) NOT NULL AUTO_INCREMENT,
  `ExerciseID` int(11) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `Repetitions` int(11) DEFAULT NULL,
  PRIMARY KEY (`SetsID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Sets`
--

INSERT INTO `Sets` (`SetsID`, `ExerciseID`, `Weight`, `Repetitions`) VALUES
(1, 1, 185, 10),
(2, 1, 225, 8),
(3, 1, 135, 15);

-- --------------------------------------------------------

--
-- Table structure for table `Workouts`
--

CREATE TABLE IF NOT EXISTS `Workouts` (
  `WorkoutsID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `ExerciseSetsID` int(11) DEFAULT NULL,
  PRIMARY KEY (`WorkoutsID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Workouts`
--

INSERT INTO `Workouts` (`WorkoutsID`, `Date`, `ExerciseSetsID`) VALUES
(1, '2011-08-29', 1);
