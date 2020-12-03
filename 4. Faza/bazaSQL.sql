-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2020 at 03:36 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--
CREATE DATABASE IF NOT EXISTS `school` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `school`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(45) NOT NULL,
  `prezime` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `adresa`
--
-- Creation: May 15, 2020 at 09:58 AM
--

DROP TABLE IF EXISTS `adresa`;
CREATE TABLE IF NOT EXISTS `adresa` (
  `idAdresa` int(11) NOT NULL AUTO_INCREMENT,
  `broj` int(11) NOT NULL,
  `idUlica` int(11) NOT NULL,
  PRIMARY KEY (`idAdresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `drzava`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `drzava`;
CREATE TABLE IF NOT EXISTS `drzava` (
  `iddrzava` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(45) NOT NULL,
  PRIMARY KEY (`iddrzava`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `filepathdokumentacijekorisnika`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `filepathdokumentacijekorisnika`;
CREATE TABLE IF NOT EXISTS `filepathdokumentacijekorisnika` (
  `idFilepathDokumentacijeKorisnika` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(100) NOT NULL,
  `idKorisnika` int(11) NOT NULL,
  PRIMARY KEY (`idFilepathDokumentacijeKorisnika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `filepathdokumentacijesmestaja`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `filepathdokumentacijesmestaja`;
CREATE TABLE IF NOT EXISTS `filepathdokumentacijesmestaja` (
  `idFilepath` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(100) NOT NULL,
  `idOglas` int(11) NOT NULL,
  PRIMARY KEY (`idFilepath`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `grad`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `grad`;
CREATE TABLE IF NOT EXISTS `grad` (
  `idgrad` int(11) NOT NULL AUTO_INCREMENT,
  `Ime` varchar(45) NOT NULL,
  `ptt` varchar(45) NOT NULL,
  `idDrzava` int(11) NOT NULL,
  PRIMARY KEY (`idgrad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--
-- Creation: May 15, 2020 at 09:58 AM
--

DROP TABLE IF EXISTS `korisnici`;
CREATE TABLE IF NOT EXISTS `korisnici` (
  `idKorisnici` int(11) NOT NULL AUTO_INCREMENT,
  `Ime` varchar(45) NOT NULL,
  `Prezime` varchar(45) NOT NULL,
  `tip` varchar(15) NOT NULL,
  `userName` varchar(45) NOT NULL,
  `eMail` varchar(45) NOT NULL,
  `datumRodjenja` date NOT NULL,
  `adresa` varchar(70) NOT NULL,
  PRIMARY KEY (`idKorisnici`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `odgovor`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `odgovor`;
CREATE TABLE IF NOT EXISTS `odgovor` (
  `idOdgovor` int(11) NOT NULL AUTO_INCREMENT,
  `idRecenzija` int(11) DEFAULT NULL,
  `idKorisnick` int(11) NOT NULL,
  `idOdgovorNa` int(11) DEFAULT NULL,
  `text` varchar(300) NOT NULL,
  PRIMARY KEY (`idOdgovor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `recenzija`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `recenzija`;
CREATE TABLE IF NOT EXISTS `recenzija` (
  `idRecenzija` int(11) NOT NULL AUTO_INCREMENT,
  `cistoca` int(11) NOT NULL,
  `komfor` int(11) NOT NULL,
  `kvalitet` int(11) NOT NULL,
  `lokacija` int(11) NOT NULL,
  `ljubaznost` int(11) NOT NULL,
  `osptiUtisak` int(11) NOT NULL,
  `tip` varchar(45) NOT NULL,
  `idOglasa` int(11) NOT NULL,
  `idKorisnika` int(11) NOT NULL,
  `komentar` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idRecenzija`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `rezervacija`;
CREATE TABLE IF NOT EXISTS `rezervacija` (
  `idRezervacija` int(11) NOT NULL AUTO_INCREMENT,
  `datumOd` date NOT NULL,
  `datumDo` date NOT NULL,
  `brojOsoba` int(11) NOT NULL,
  `napomena` varchar(500) NOT NULL,
  `idSmestaj` int(11) NOT NULL,
  `idKorisnika` int(11) NOT NULL,
  PRIMARY KEY (`idRezervacija`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `smestaj`
--
-- Creation: May 15, 2020 at 09:58 AM
--

DROP TABLE IF EXISTS `smestaj`;
CREATE TABLE IF NOT EXISTS `smestaj` (
  `idOglasi` int(11) NOT NULL AUTO_INCREMENT,
  `opis` varchar(200) NOT NULL,
  `cena` int(11) NOT NULL,
  `idVlasnik` int(11) NOT NULL,
  `idAdresa` int(11) NOT NULL,
  `tipSmestaja` varchar(45) NOT NULL,
  `kapacitet` int(11) NOT NULL,
  `povrsina` int(11) NOT NULL,
  `kuhinja` varchar(5) NOT NULL,
  `terasa` tinyint(4) NOT NULL,
  `parking` tinyint(4) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`idOglasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ulica`
--
-- Creation: May 15, 2020 at 09:59 AM
--

DROP TABLE IF EXISTS `ulica`;
CREATE TABLE IF NOT EXISTS `ulica` (
  `idUlica` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(45) DEFAULT NULL,
  `idGrad` int(11) NOT NULL,
  PRIMARY KEY (`idUlica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
