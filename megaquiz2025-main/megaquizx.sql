-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 18 Wrz 2025, 10:08
-- Wersja serwera: 10.5.29-MariaDB-0+deb11u1
-- Wersja PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `megaquiz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quizy`
--

CREATE TABLE `quizy` (
  `id` int(11) NOT NULL,
  `id_tworzącego` int(11) NOT NULL,
  `data_dodania` datetime NOT NULL,
  `nazwa` text NOT NULL,
  `kategoria_id` int(11) NOT NULL,
  `ocena_uz` decimal(10,0) NOT NULL,
  `ilosc_ocen` int(11) NOT NULL,
  `premium` tinyint(1) NOT NULL COMMENT 'true/false'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Zrzut danych tabeli `quizy`
--

INSERT INTO `quizy` (`id`, `id_tworzącego`, `data_dodania`, `nazwa`, `kategoria_id`, `ocena_uz`, `ilosc_ocen`, `premium`) VALUES
(1, 1, '2025-09-18 00:00:00', 'name', 3, '4', 10, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(16) NOT NULL,
  `email` varchar(60) NOT NULL,
  `haslo` varchar(10) NOT NULL,
  `potwierdzony` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `nazwa`, `email`, `haslo`, `potwierdzony`) VALUES
(1, 'nazwauz', 'mail@mail.com', 'haslo123', 0),
(2, 'mateusz', 'mushkartsi1@gmail.com', 'emilka', 0),
(8, 'japko', 'jifijifiliski@gmail.com', '', 0),
(9, 'a', 'a@wp.pl', '', 0);

--
-- Indeksy dla zrzutów tabel
--

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
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `quizy`
--
ALTER TABLE `quizy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
