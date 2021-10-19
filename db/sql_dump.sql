-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Ott 16, 2021 alle 13:44
-- Versione del server: 10.3.31-MariaDB-log-cll-lve
-- Versione PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table `check_phone`
--

CREATE TABLE `check_phone` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` int(20) DEFAULT 0,
  `contact_checked` set('no','yes') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Trigger `check_phone`
--
DELIMITER $$
CREATE TRIGGER `after_contact_insert` AFTER INSERT ON `check_phone` FOR EACH ROW BEGIN
    IF NEW.email is NOT NULL THEN
        INSERT INTO wellcome_gift(email)
        VALUES(NEW.email);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `type_active_campaign` varchar(20) NOT NULL,
  `date_time` date NOT NULL,
  `initiated_by` varchar(30) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `contact_email` varchar(30) NOT NULL,
  `contact_first_name` varchar(30) NOT NULL,
  `contact_last_name` varchar(30) NOT NULL,
  `contact_phone` int(20) NOT NULL,
  `contact_ip` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table `wellcome_gift`
--

CREATE TABLE `wellcome_gift` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `gift_sent` set('no','yes') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Index for downloaded Table
--

--
-- Index for Table `check_phone`
--
ALTER TABLE `check_phone`
  ADD PRIMARY KEY (`id`);

--
-- Index for Table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Index for Table `wellcome_gift`
--
ALTER TABLE `wellcome_gift`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for downloaded tables
--

--
-- AUTO_INCREMENT for table `check_phone`
--
ALTER TABLE `check_phone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wellcome_gift`
--
ALTER TABLE `wellcome_gift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
