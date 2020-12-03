-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2020 at 10:51 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minions`
--
CREATE DATABASE IF NOT EXISTS `minions` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `minions`;

-- --------------------------------------------------------

--
-- Table structure for table `brojrecenzija`
--

DROP TABLE IF EXISTS `brojrecenzija`;
CREATE TABLE IF NOT EXISTS `brojrecenzija` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idKorisnik` int(11) NOT NULL,
  `idSmestaj` int(11) NOT NULL,
  `broj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brojrecenzija`
--

INSERT INTO `brojrecenzija` (`id`, `idKorisnik`, `idSmestaj`, `broj`) VALUES
(7, 16, 14, 7),
(8, 16, 18, 0),
(9, 16, 15, 3),
(10, 17, 17, 0),
(11, 17, 16, 0),
(12, 17, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `filepathdokumentacijesmestaja`
--

DROP TABLE IF EXISTS `filepathdokumentacijesmestaja`;
CREATE TABLE IF NOT EXISTS `filepathdokumentacijesmestaja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(100) NOT NULL,
  `idSmestaj` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `filepathdokumentacijesmestaja`
--

INSERT INTO `filepathdokumentacijesmestaja` (`id`, `filepath`, `idSmestaj`) VALUES
(46, 'slike/proba/slika1.jpg', 8),
(47, 'slike/proba/slika2.jpg', 8),
(48, 'slike/proba/slika3.jpg', 8),
(49, 'slike/proba/slika4.jpg', 8),
(50, 'slike/proba/slika5.jpg', 8),
(51, 'slike/proba/slika11.jpg', 9),
(52, 'slike/proba/slika12.jpg', 9),
(53, 'slike/proba/slika13.jpg', 9),
(54, 'slike/proba/slika14.jpg', 9),
(55, 'slike/proba/slika15.jpg', 9),
(56, 'slike/proba/slika41.jpg', 10),
(57, 'slike/proba/slika42.jpg', 10),
(58, 'slike/proba/slika43.jpg', 10),
(59, 'slike/proba/slika44.jpg', 10),
(60, 'slike/proba/slika45.jpg', 10),
(61, 'slike/proba/slika51.jpg', 11),
(62, 'slike/proba/slika52.jpg', 11),
(63, 'slike/proba/slika53.jpg', 11),
(64, 'slike/proba/slika54.jpg', 11),
(65, 'slike/proba/slika55.jpg', 11),
(66, 'slike/proba/slika61.jpg', 12),
(67, 'slike/proba/slika62.jpg', 12),
(68, 'slike/proba/slika63.jpg', 12),
(69, 'slike/proba/slika64.jpg', 12),
(70, 'slike/proba/slika65.jpg', 12),
(71, 'slike/Hotel Metropol/slika61.jpg', 13),
(72, 'slike/Hotel Metropol/slika62.jpg', 13),
(73, 'slike/Hotel Metropol/slika63.jpg', 13),
(74, 'slike/Hotel Metropol/slika64.jpg', 13),
(75, 'slike/Hotel Metropol/slika65.jpg', 13),
(76, 'slike/Aleksandar Apartments/slika31.jpg', 14),
(77, 'slike/Aleksandar Apartments/slika32.jpg', 14),
(78, 'slike/Aleksandar Apartments/slika33.jpg', 14),
(79, 'slike/Aleksandar Apartments/slika34.jpg', 14),
(80, 'slike/Aleksandar Apartments/slika35.jpg', 14),
(81, 'slike/Hotel Metropol/slika21.jpg', 15),
(82, 'slike/Hotel Metropol/slika22.jpg', 15),
(83, 'slike/Hotel Metropol/slika23.jpg', 15),
(84, 'slike/Hotel Metropol/slika24.jpg', 15),
(85, 'slike/Hotel Metropol/slika25.jpg', 15),
(86, 'slike/Vila Beograd/slika11.jpg', 16),
(87, 'slike/Vila Beograd/slika12.jpg', 16),
(88, 'slike/Vila Beograd/slika13.jpg', 16),
(89, 'slike/Vila Beograd/slika14.jpg', 16),
(90, 'slike/Vila Beograd/slika15.jpg', 16),
(91, 'slike/Kragujevac Apartment/slika41.jpg', 17),
(92, 'slike/Kragujevac Apartment/slika42.jpg', 17),
(93, 'slike/Kragujevac Apartment/slika43.jpg', 17),
(94, 'slike/Kragujevac Apartment/slika44.jpg', 17),
(95, 'slike/Kragujevac Apartment/slika45.jpg', 17),
(96, 'slike/Vila Niketic/slika51.jpg', 18),
(97, 'slike/Vila Niketic/slika52.jpg', 18),
(98, 'slike/Vila Niketic/slika53.jpg', 18),
(99, 'slike/Vila Niketic/slika54.jpg', 18),
(100, 'slike/Vila Niketic/slika55.jpg', 18),
(101, 'slike/Apartment Valjevo/slika61.jpg', 19),
(102, 'slike/Apartment Valjevo/slika62.jpg', 19),
(103, 'slike/Apartment Valjevo/slika63.jpg', 19),
(104, 'slike/Apartment Valjevo/slika64.jpg', 19),
(105, 'slike/Apartment Valjevo/slika65.jpg', 19),
(106, 'slike/Moma/Capture.PNG', 20),
(107, 'slike/Moma/k.PNG', 20),
(108, 'slike/Moma5/Capture.PNG', 21),
(109, 'slike/Moma5/k.PNG', 21),
(110, 'slike/Moma3/ca760b70976b52578da88e06973af542.jpg', 22),
(111, 'slike/Moma3/download.jpg', 22),
(112, 'slike/Moma3/RKyaEDwp8J7JKeZWQPuOVWvkUjGQfpCx_cover_580.jpg', 22),
(113, 'slike/Moma4/ca760b70976b52578da88e06973af542.jpg', 23),
(114, 'slike/Moma4/download.jpg', 23),
(115, 'slike/Moma4/RKyaEDwp8J7JKeZWQPuOVWvkUjGQfpCx_cover_580.jpg', 23),
(116, 'slike/Moma4/ca760b70976b52578da88e06973af542.jpg', 24),
(117, 'slike/Moma4/download.jpg', 24),
(118, 'slike/Moma4/RKyaEDwp8J7JKeZWQPuOVWvkUjGQfpCx_cover_580.jpg', 24),
(119, 'slike/Moma5/ca760b70976b52578da88e06973af542.jpg', 25),
(120, 'slike/Moma5/download.jpg', 25),
(121, 'slike/Moma5/RKyaEDwp8J7JKeZWQPuOVWvkUjGQfpCx_cover_580.jpg', 25);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(45) NOT NULL,
  `prezime` varchar(45) NOT NULL,
  `tip` varchar(15) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `datumRodjenja` date NOT NULL,
  `adresa` varchar(70) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `tip`, `username`, `password`, `email`, `datumRodjenja`, `adresa`, `status`) VALUES
(11, 'Nikola', 'Marovic', 'admin', 'admin', 'admin', 'nmarovic998@gmail.com', '1998-05-23', 'Brace Velickovic 4', 'aktivan'),
(13, 'Nikola', 'Marovic', 'oglasavac', 'nidzulitza', 'qwerqwer', 'nmarovic998@gmail.com', '1998-05-23', 'Brace Velickovic 4', 'aktivan'),
(14, 'Momcilo', 'Niketic', 'oglasavac', 'moma98', 'zxcvzxcv', 'moma98kg@gmail.com', '1998-08-06', 'Bresnica bb', 'aktivan'),
(15, 'Mina', 'Urosevic', 'oglasavac', 'minka', 'asdfasdf', 'mina.urosevic12@gmail.com', '1999-01-31', 'Karadjordjeva 10', 'aktivan'),
(16, 'Aleksandar', 'Nikolic', 'korisnik', 'coa98', 'sifra123', 'aleksandarnikolic@hotmail.rs', '1998-10-06', 'Bavaniste bb', 'aktivan'),
(17, 'Drazen', 'Draskovic', 'korisnik', 'draza', 'asdfasdf', 'drazen.draskovic@etf.rs', '1990-07-01', 'Niska 37 beograd', 'aktivan');

-- --------------------------------------------------------

--
-- Table structure for table `obavestenja`
--

DROP TABLE IF EXISTS `obavestenja`;
CREATE TABLE IF NOT EXISTS `obavestenja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idKorisnik` int(13) NOT NULL,
  `naslov` varchar(45) NOT NULL,
  `opis` varchar(250) NOT NULL,
  `tip` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obavestenja`
--

INSERT INTO `obavestenja` (`id`, `idKorisnik`, `naslov`, `opis`, `tip`) VALUES
(6, 16, 'Neuspešna rezervacija!', 'Vlasnik smeštaja Nikola Marovic nije potvrdio Vaš boravak u smeštaju Aleksandar Apartments od 2020-05-06 do 2020-05-07. Ne možete da ostavite recenziju.', 'danger'),
(7, 16, 'Uspešna rezervacija!', 'Vlasnik smeštaja Nikola Marovic je potvrdio Vaš boravak u smeštaju Aleksandar Apartments od 2020-05-08 do 2020-05-09. Molimo Vas da ostavite recenziju.', 'success'),
(8, 16, 'Uspešna rezervacija!', 'Vlasnik smeštaja Nikola Marovic je potvrdio Vaš boravak u smeštaju Aleksandar Apartments od 2020-05-09 do 2020-05-10. Molimo Vas da ostavite recenziju.', 'success'),
(9, 16, 'Uspešna rezervacija!', 'Vlasnik smeštaja Nikola Marovic je potvrdio Vaš boravak u smeštaju Hotel Metropol od 2020-04-26 do 2020-04-27. Molimo Vas da ostavite recenziju.', 'success'),
(10, 16, 'Uspešna rezervacija!', 'Vlasnik smeštaja Nikola Marovic je potvrdio Vaš boravak u smeštaju Hotel Metropol od 2020-05-05 do 2020-05-06. Molimo Vas da ostavite recenziju.', 'success'),
(11, 16, 'Uspešna rezervacija!', 'Vlasnik smeštaja Nikola Marovic je potvrdio Vaš boravak u smeštaju Hotel Metropol od 2020-06-06 do 2020-06-07. Molimo Vas da ostavite recenziju.', 'success'),
(12, 16, 'Uspešna rezervacija!', 'Vlasnik smeštaja Nikola Marovic je potvrdio Vaš boravak u smeštaju Aleksandar Apartments od 2020-06-02 do 2020-06-03. Molimo Vas da ostavite recenziju.', 'success'),
(13, 13, 'Nova recenzija!', 'Korisnik Aleksandar Nikolic je ostavio recenziju za boravak u Vašem smeštaju Aleksandar Apartments', 'success'),
(14, 13, 'Nova recenzija!', 'Korisnik Aleksandar Nikolic je ostavio recenziju za boravak u Vašem smeštaju Aleksandar Apartments', 'success'),
(15, 13, 'Nova recenzija!', 'Korisnik Aleksandar Nikolic je ostavio recenziju za boravak u Vašem smeštaju Aleksandar Apartments', 'success'),
(16, 16, 'Odgovor na recenziju!', 'Vlasnik smeštaja Nikola Marovic je odgovorio na Vašu recenziju za smeštaj Aleksandar Apartments', 'success'),
(17, 17, 'Uspešna rezervacija!', 'Vlasnik smeštaja Mina Urosevic je potvrdio Vaš boravak u smeštaju Apartment Valjevo od 2020-06-18 do 2020-06-24. Molimo Vas da ostavite recenziju.', 'success'),
(18, 17, 'Uspešna rezervacija!', 'Vlasnik smeštaja Mina Urosevic je potvrdio Vaš boravak u smeštaju Apartment Valjevo od 2020-06-05 do 2020-06-08. Molimo Vas da ostavite recenziju.', 'success'),
(19, 15, 'Nova recenzija!', 'Korisnik Drazen Draskovic je ostavio recenziju za boravak u Vašem smeštaju Apartment Valjevo', 'success'),
(20, 17, 'Uspešna rezervacija!', 'Vlasnik smeštaja Momcilo Niketic je potvrdio Vaš boravak u smeštaju Kragujevac Apartment od 2020-06-05 do 2020-06-01. Molimo Vas da ostavite recenziju.', 'success'),
(21, 17, 'Neuspešna rezervacija!', 'Vlasnik smeštaja Momcilo Niketic nije potvrdio Vaš boravak u smeštaju Kragujevac Apartment od 2020-06-22 do 2020-06-24. Ne možete da ostavite recenziju.', 'danger'),
(22, 17, 'Uspešna rezervacija!', 'Vlasnik smeštaja Momcilo Niketic je potvrdio Vaš boravak u smeštaju Kragujevac Apartment od 2020-06-18 do 2020-06-22. Molimo Vas da ostavite recenziju.', 'success'),
(23, 14, 'Nova recenzija!', 'Korisnik Drazen Draskovic je ostavio recenziju za boravak u Vašem smeštaju Kragujevac Apartment', 'success'),
(24, 17, 'Odgovor na recenziju!', 'Vlasnik smeštaja Momcilo Niketic je odgovorio na Vašu recenziju za smeštaj Kragujevac Apartment', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `recenzija`
--

DROP TABLE IF EXISTS `recenzija`;
CREATE TABLE IF NOT EXISTS `recenzija` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cistoca` int(11) NOT NULL,
  `komfor` int(11) NOT NULL,
  `kvalitet` int(11) NOT NULL,
  `lokacija` int(11) NOT NULL,
  `ljubaznost` int(11) NOT NULL,
  `opstiUtisak` varchar(25) NOT NULL,
  `tip` varchar(45) NOT NULL,
  `idSmestaj` int(11) NOT NULL,
  `idKorisnik` int(11) NOT NULL,
  `idOglasavac` int(11) NOT NULL,
  `komentar` varchar(500) DEFAULT NULL,
  `odgovor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recenzija`
--

INSERT INTO `recenzija` (`id`, `cistoca`, `komfor`, `kvalitet`, `lokacija`, `ljubaznost`, `opstiUtisak`, `tip`, `idSmestaj`, `idKorisnik`, `idOglasavac`, `komentar`, `odgovor`) VALUES
(16, 4, 5, 5, 4, 5, 'Sjajno', 'Porodica', 14, 16, 13, 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic type', 'Similar to the contextual text color classes, easily set the background of an element to any contextual class. Anchor components will darken on hover, just like the text classes. Background utilities do not set color, so in some cases you’ll want to '),
(17, 5, 4, 5, 5, 4, 'Sjajno', 'Porodica', 14, 16, 13, 'Odlican smestaj, za svaku pohvalu! Ponovo cemo doci! Pozdrav iz Panceva!', 'Hvala! Cast nam je bila ugostiti Vas! Veliki pozdrav!'),
(19, 5, 4, 4, 5, 4, 'Dobro', 'Porodica', 14, 16, 13, 'Odlican smestaj, ponovo cemo doci.', NULL),
(20, 5, 5, 5, 5, 5, 'Dobro', 'Grupa prijatelja', 15, 16, 13, 'Ovo je bio odlican smestaj. Uvek cemo doci! Veliki pozdrav iz Bavanista!', NULL),
(21, 5, 5, 4, 5, 5, 'Sjajno', 'Porodica', 15, 16, 13, 'Opet cemo doci, sve je odlicno! Pozdrav!', NULL),
(22, 5, 5, 5, 5, 5, 'Sjajno', 'Porodica', 14, 16, 13, 'Sjajan smestaj. Ponovo cemo doci! Pozdrav!\r\n', NULL),
(23, 5, 5, 5, 4, 5, 'Dobro', 'Porodica', 14, 16, 13, 'Veoma dobar smestaj. Osoblje jako ljubazno. Svima preporucujemo.', NULL),
(24, 5, 5, 5, 4, 5, 'Dobro', 'Porodica', 14, 16, 13, 'Veoma dobar smestaj. Osoblje jako ljubazno. Svima preporucujemo.', NULL),
(25, 5, 5, 5, 4, 5, 'Dobro', 'Porodica', 14, 16, 13, 'Veoma dobar smestaj. Osoblje jako ljubazno. Svima preporucujemo.', NULL),
(26, 5, 4, 5, 4, 5, 'Sjajno', 'Porodica', 14, 16, 13, 'Veoma dobar smestaj. Svima cu preporuciti. Veliki pozdrav!', NULL),
(27, 5, 4, 4, 5, 5, 'Dobro', 'Grupa prijatelja', 14, 16, 13, 'Odlican smestaj svima cu preporuciti. Pozdrav od Acike programatora iz Bavanista!', NULL),
(28, 5, 5, 5, 5, 5, 'Sjajno', 'Par', 19, 17, 15, 'Hvala! Cast nam je bila ugostiti Vas! Veliki pozdrav!Veoma dobar smestaj. Svima cu preporuciti. Veliki pozdrav!', NULL),
(29, 5, 5, 5, 5, 5, 'Dobro', 'Porodica', 17, 17, 14, 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic type', 'Hvala! Cast nam je bila ugostiti Vas! Veliki pozdrav!');

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

DROP TABLE IF EXISTS `rezervacija`;
CREATE TABLE IF NOT EXISTS `rezervacija` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datumOd` date NOT NULL,
  `datumDo` date NOT NULL,
  `brojOsoba` int(11) NOT NULL,
  `napomena` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL,
  `idSmestaj` int(11) NOT NULL,
  `idKorisnika` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rezervacija`
--

INSERT INTO `rezervacija` (`id`, `datumOd`, `datumDo`, `brojOsoba`, `napomena`, `status`, `idSmestaj`, `idKorisnika`) VALUES
(27, '2020-05-27', '2020-05-28', 4, 'Nista', 'potvrdjena', 14, 16),
(28, '2020-05-29', '2020-05-30', 2, 'Nista', 'potvrdjena', 14, 16),
(30, '2020-05-31', '2020-06-01', 2, 'Nista', 'potvrdjena', 14, 16),
(31, '2020-05-13', '2020-05-14', 2, 'Nista', 'potvrdjena', 15, 16),
(32, '2020-05-29', '2020-05-30', 2, 'Nista', 'potvrdjena', 15, 16),
(33, '2020-04-26', '2020-04-27', 2, 'Nista', 'potvrdjena', 14, 16),
(34, '2020-05-01', '2020-05-02', 2, 'Nista', 'potvrdjena', 14, 16),
(35, '2020-05-06', '2020-05-07', 2, 'Nista', 'odbijena', 14, 16),
(36, '2020-05-08', '2020-05-09', 2, 'Nista', 'potvrdjena', 14, 16),
(37, '2020-05-09', '2020-05-10', 2, 'nista', 'potvrdjena', 14, 16),
(38, '2020-04-26', '2020-04-27', 2, 'Nista', 'potvrdjena', 15, 16),
(39, '2020-05-05', '2020-05-06', 2, 'nista', 'potvrdjena', 15, 16),
(40, '2020-06-06', '2020-06-07', 2, 'Nista', 'potvrdjena', 15, 16),
(41, '2020-06-02', '2020-06-03', 2, 'Nista', 'potvrdjena', 14, 16),
(43, '2020-06-05', '2020-06-01', 3, 'nista', 'potvrdjena', 17, 17),
(46, '2020-06-10', '2020-06-13', 2, 'Nista', 'nepotvrdjena', 16, 17),
(47, '2020-07-07', '2020-07-10', 2, 'Nista', 'nepotvrdjena', 16, 17),
(49, '2020-06-18', '2020-06-22', 3, 'Nista', 'potvrdjena', 17, 17),
(50, '2020-06-22', '2020-06-24', 2, 'Nista', 'odbijena', 17, 17),
(51, '2020-06-18', '2020-06-24', 2, 'Nista', 'potvrdjena', 19, 17),
(52, '2020-06-05', '2020-06-08', 2, 'Nista', 'potvrdjena', 19, 17);

-- --------------------------------------------------------

--
-- Table structure for table `smestaj`
--

DROP TABLE IF EXISTS `smestaj`;
CREATE TABLE IF NOT EXISTS `smestaj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(45) NOT NULL,
  `opis` varchar(1500) NOT NULL,
  `cena` int(11) NOT NULL,
  `idVlasnik` int(11) NOT NULL,
  `drzava` varchar(45) NOT NULL,
  `grad` varchar(45) NOT NULL,
  `ulica` varchar(45) NOT NULL,
  `broj` varchar(45) NOT NULL,
  `tipSmestaja` varchar(45) NOT NULL,
  `kapacitet` int(11) NOT NULL,
  `povrsina` int(11) NOT NULL,
  `kuhinja` tinyint(1) NOT NULL,
  `terasa` tinyint(4) NOT NULL,
  `parking` tinyint(4) NOT NULL,
  `lat` varchar(20) NOT NULL,
  `lon` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `smestaj`
--

INSERT INTO `smestaj` (`id`, `naziv`, `opis`, `cena`, `idVlasnik`, `drzava`, `grad`, `ulica`, `broj`, `tipSmestaja`, `kapacitet`, `povrsina`, `kuhinja`, `terasa`, `parking`, `lat`, `lon`) VALUES
(14, 'Aleksandar Apartments', 'Stan se nalazi u centru Valjeva. Smesten je na samoj raskrsnici ulica Dr. Pantica i Sindjeliceve ulice u privatnoj zgradi. Od samog centra je udaljen 200m. Veoma prostran i komforan. U samoj blizini se nalaze prodavnice, pekare, kafici i restorani. Nov je i opremljen novim stvarima. Velicina je 65 m2. Ima besplatan WiFi. Raspolaze kompletno opremljenim kupatilom i kuhinjom. ', 30, 13, 'Srbija', 'Valjevo', 'Pantićeva', '107', 'apartman', 6, 65, 1, 1, 1, '44.272553', '19.890626'),
(15, 'Hotel Metropol', 'Fantastična lokacija hotela Metropol Palace pored veličanstvenog Tašmajdanskog parka poziva vas da istražite brojne znamenitosti, pozorišta i muzeje Beograda bogate domaćim i međunarodnim kulturnim sadržajima, sve na nekoliko minuta hoda of hotela.', 45, 13, 'Srbija', 'Beograd', 'Bulevar Kralja Aleksandra', '67', 'hotelskaSoba', 2, 23, 0, 1, 1, '44.806540', '20.473444'),
(16, 'Vila Beograd', '﻿﻿﻿﻿﻿Vikendica na obali Dedinju, vikend ekolosko naselje se nalazi preko puta usca Save u Dunav.   Povrsine 180 kvadrata, zidana od pune cigle, utvdjena obala, novogradnja, voda, struja led rasveta, asvaltirani put do nasela, od Beograda udaljeno naselje oko 60 km . Moze zamena za stan u Beogradu, uz moju doplatu ili zamena za skuplji auto uz Vasu doplatu.', 120, 13, 'Srbija', 'Beograd', 'Neznanog junaka', '10', 'vikendica', 12, 150, 1, 1, 1, '44.774108', '20.461578'),
(17, 'Kragujevac Apartment', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 35, 14, 'Srbija', 'Kragujevac', 'Karadjordjeva', '6', 'apartman', 4, 45, 1, 1, 1, '44.010062', '20.917019'),
(19, 'Apartment Valjevo', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 25, 15, 'Srbija', 'Valjevo', 'Karadjordjeva', '15', 'soba', 3, 23, 0, 1, 1, '44.271023', '19.888030');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
