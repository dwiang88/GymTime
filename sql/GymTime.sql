-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2011 at 04:40 PM
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
-- Table structure for table `Exercises`
--

CREATE TABLE IF NOT EXISTS `Exercises` (
  `ExerciseID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `MuscleGroup` text NOT NULL,
  PRIMARY KEY (`ExerciseID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Exercises`
--

INSERT INTO `Exercises` (`ExerciseID`, `Name`, `MuscleGroup`) VALUES
(1, 'Barbell Bench Press', 'Chest'),
(2, 'Dumbbell Incline Press', 'Chest');

-- --------------------------------------------------------

--
-- Table structure for table `Sets`
--

CREATE TABLE IF NOT EXISTS `Sets` (
  `SetID` int(11) NOT NULL,
  `ExerciseID` int(11) NOT NULL,
  `Weight` int(11) NOT NULL,
  `Repetitions` int(11) NOT NULL,
  `SetNumber` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Sets`
--

INSERT INTO `Sets` (`SetID`, `ExerciseID`, `Weight`, `Repetitions`, `SetNumber`) VALUES
(1, 1, 135, 10, 1),
(2, 2, 135, 4, 2),
(1, 1, 135, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` text NOT NULL,
  `Email` text NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Email`) VALUES
(1, 'john.flores', 'john.s.flores@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `Workouts`
--

CREATE TABLE IF NOT EXISTS `Workouts` (
  `WorkoutID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date DEFAULT NULL,
  `SetID` int(11) DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`WorkoutID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Workouts`
--

INSERT INTO `Workouts` (`WorkoutID`, `Date`, `SetID`, `UserID`) VALUES
(2, '2011-08-28', 1, 1),
(3, '2011-08-29', 1, 1),
(5, '2011-08-30', -1, 1);
