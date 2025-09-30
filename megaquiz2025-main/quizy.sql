-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Wrz 30, 2025 at 03:10 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategoria`
--

INSERT INTO `kategoria` (`id`, `nazwa`) VALUES
(1, 'Historia'),
(2, 'Geografia'),
(3, 'Nauka'),
(4, 'Kultura i sztuka'),
(5, 'Sport'),
(6, 'Technologia'),
(7, 'Języki i literatura'),
(8, 'Popkultura'),
(9, 'Przyroda'),
(10, 'Ciekawostki ogólne');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quizy`
--

CREATE TABLE `quizy` (
  `id` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `data_dodania` datetime NOT NULL,
  `nazwa` text NOT NULL,
  `ilosc_pytan` int(11) NOT NULL,
  `kategoria_id` int(11) NOT NULL,
  `ocena_uz` decimal(5,1) NOT NULL,
  `ilosc_ocen` int(11) NOT NULL,
  `premium` tinyint(1) NOT NULL COMMENT 'true/false'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `quizy`
--

INSERT INTO `quizy` (`id`, `id_autor`, `data_dodania`, `nazwa`, `ilosc_pytan`, `kategoria_id`, `ocena_uz`, `ilosc_ocen`, `premium`) VALUES
(1, 1, '2025-09-18 00:00:00', 'name', 0, 3, 0.9, 10, 0),
(7, 10, '2025-09-30 14:44:43', 'dsfsdfsfsdfdsfdsdfs', 0, 1, 0.0, 0, 0),
(5, 10, '2025-09-30 14:18:50', 'niepremium', 0, 1, 0.0, 0, 0),
(6, 10, '2025-09-30 14:22:09', 'premium', 0, 1, 0.0, 0, 1),
(8, 10, '2025-09-30 15:09:35', 'premium', 67, 1, 0.0, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(16) NOT NULL,
  `email` varchar(60) NOT NULL,
  `haslo` varchar(10) NOT NULL,
  `premium` tinyint(1) NOT NULL,
  `potwierdzony` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `nazwa`, `email`, `haslo`, `premium`, `potwierdzony`, `admin`) VALUES
(1, 'nazwauz', 'mail@mail.com', 'haslo123', 0, 0, 0),
(2, 'mateusz', 'mushkartsi1@gmail.com', 'emilka123', 0, 1, 0),
(8, 'japko', 'jifijifiliski@gmail.com', '', 0, 0, 0),
(9, 'a', 'a@wp.pl', '', 0, 0, 0),
(10, 'userna', 'mailm@mail.com', 'password', 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `znajomi`
--

CREATE TABLE `znajomi` (
  `id_nadawcy` int(11) NOT NULL,
  `id_odbiorcy` int(11) NOT NULL,
  `przyjeto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `znajomi`
--

INSERT INTO `znajomi` (`id_nadawcy`, `id_odbiorcy`, `przyjeto`) VALUES
(2, 1, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `quizy`
--
ALTER TABLE `quizy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quizy`
--
ALTER TABLE `quizy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
