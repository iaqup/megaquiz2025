-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Paź 07, 2025 at 10:02 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

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
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `ocena` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oceny`
--

INSERT INTO `oceny` (`id`, `quiz_id`, `uzytkownik_id`, `ocena`) VALUES
(1, 12, 25, 3),
(2, 12, 25, 3),
(3, 12, 25, 4),
(4, 14, 25, 2),
(5, 14, 25, 3),
(6, 14, 25, 4),
(7, 17, 25, 2),
(9, 19, 26, 5),
(10, 19, 25, 4),
(11, 12, 25, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `odpowiedzi`
--

CREATE TABLE `odpowiedzi` (
  `id` int(11) NOT NULL,
  `pytanie_id` int(11) NOT NULL,
  `tresc` varchar(1024) NOT NULL,
  `poprawna` tinyint(1) NOT NULL DEFAULT 0,
  `kolejnosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `odpowiedzi`
--

INSERT INTO `odpowiedzi` (`id`, `pytanie_id`, `tresc`, `poprawna`, `kolejnosc`) VALUES
(13, 4, 'sdf', 1, NULL),
(14, 4, 'sdf', 0, NULL),
(15, 4, 'sdf', 0, NULL),
(16, 4, 'sdf', 0, NULL),
(17, 5, 'sdf', 0, NULL),
(18, 5, 'dsf', 1, NULL),
(19, 5, 'sdf', 0, NULL),
(20, 5, 'sdf', 0, NULL),
(21, 6, '324', 0, NULL),
(22, 6, '234', 0, NULL),
(23, 6, '234', 0, NULL),
(24, 6, '234', 1, NULL),
(25, 7, '24', 0, NULL),
(26, 7, '24', 0, NULL),
(27, 7, '24', 1, NULL),
(28, 7, '24', 0, NULL),
(29, 8, 'asd', 0, 1),
(30, 8, 'asd', 0, 2),
(31, 8, 'asd', 1, 3),
(32, 8, 'ad', 0, 4),
(33, 9, 'asd', 0, 1),
(34, 9, 'asd', 1, 2),
(35, 9, 'asd', 0, 3),
(36, 9, 'ads', 0, 4),
(37, 10, 'asd', 0, 1),
(38, 10, 'ad', 1, 2),
(39, 10, 'asd', 0, 3),
(40, 10, 'asd', 0, 4),
(52, 15, 'asd', 0, 1),
(53, 15, 'sad', 1, 2),
(54, 15, 'sad', 0, 3),
(55, 15, 'asd', 0, 4),
(56, 16, 'asd', 0, 1),
(57, 16, 'asd', 1, 2),
(58, 16, 'asd', 0, 3),
(59, 16, 'asd', 0, 4),
(60, 17, 'asd', 1, 1),
(61, 17, 'asd', 0, 2),
(62, 17, 'asd', 0, 3),
(63, 17, 'asd', 0, 4),
(64, 18, 'asd', 0, 1),
(65, 18, 'asd', 0, 2),
(66, 18, 'asd', 1, 3),
(67, 18, 'asd', 0, 4),
(76, 21, 'sdf', 1, 1),
(77, 21, 'sdfg', 0, 2),
(78, 21, 'sdfg', 0, 3),
(79, 21, 'sdfg', 0, 4),
(80, 22, 'asd', 1, 1),
(81, 22, 'sdfg', 0, 2),
(82, 22, 'sdg', 0, 3),
(83, 22, 'dsg', 0, 4),
(84, 23, 'sdg', 0, 1),
(85, 23, 'sdg', 0, 2),
(86, 23, 'sdg', 0, 3),
(87, 23, 'sdf', 1, 4),
(88, 24, 'asdsadg', 0, 1),
(89, 24, 'zxxcsg', 0, 2),
(90, 24, 'zxc', 1, 3),
(91, 24, 'asdasdg', 0, 4),
(92, 25, 'asdadg', 0, 1),
(93, 25, 'asda', 1, 2),
(94, 25, 'sadag', 0, 3),
(95, 25, 'asdadg', 0, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `odpowiedzi_uzytkownika`
--

CREATE TABLE `odpowiedzi_uzytkownika` (
  `id` int(11) NOT NULL,
  `wynik_id` int(11) NOT NULL,
  `pytanie_id` int(11) NOT NULL,
  `odpowiedz_id` int(11) DEFAULT NULL,
  `odpowiedz_tekst` text DEFAULT NULL,
  `punkty` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pytania`
--

CREATE TABLE `pytania` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `typ` enum('abcd','otwarte') NOT NULL DEFAULT 'abcd',
  `kolejnosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pytania`
--

INSERT INTO `pytania` (`id`, `quiz_id`, `tresc`, `typ`, `kolejnosc`) VALUES
(4, 12, 'dsdsfsf', 'abcd', NULL),
(5, 12, 'sdfsfsfs', 'abcd', NULL),
(6, 12, 'dfsfs', 'abcd', NULL),
(7, 12, '2342424', 'abcd', NULL),
(8, 13, 'sadasd', 'abcd', 1),
(9, 13, 'asdadaadasda', 'abcd', 2),
(10, 14, 'asd', 'abcd', 1),
(15, 16, 'asdasd', 'abcd', 1),
(16, 16, 'asdad', 'abcd', 2),
(17, 16, 'asd', 'abcd', 3),
(18, 17, 'asd', 'abcd', 1),
(21, 19, 'dsfsd', 'abcd', 1),
(22, 19, 'sdgsdg', 'abcd', 2),
(23, 19, 'sdgsdg', 'abcd', 3),
(24, 19, 'dfsdfsdf', 'abcd', 4),
(25, 19, 'adas', 'abcd', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quizy`
--

CREATE TABLE `quizy` (
  `id` int(11) NOT NULL,
  `id_autor` int(11) DEFAULT NULL,
  `data_dodania` datetime NOT NULL,
  `nazwa` mediumtext NOT NULL,
  `ilosc_pytan` int(11) NOT NULL,
  `kategoria_id` int(11) DEFAULT NULL,
  `ocena_uz` decimal(5,1) NOT NULL,
  `ilosc_ocen` int(11) NOT NULL,
  `premium` tinyint(1) NOT NULL COMMENT 'true/false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizy`
--

INSERT INTO `quizy` (`id`, `id_autor`, `data_dodania`, `nazwa`, `ilosc_pytan`, `kategoria_id`, `ocena_uz`, `ilosc_ocen`, `premium`) VALUES
(12, 25, '2025-10-02 10:00:53', 'skibidi', 7, 1, 2.8, 4, 0),
(13, 25, '2025-10-02 10:06:52', 'skibidi', 2, 1, 0.0, 0, 0),
(14, 25, '2025-10-02 10:09:13', 'skibidi', 2, 1, 3.0, 3, 0),
(16, 25, '2025-10-02 10:57:51', 'skibidi', 5, 1, 0.0, 0, 0),
(17, 25, '2025-10-02 11:00:09', 'asd', 1, 1, 2.0, 1, 0),
(19, 26, '2025-10-02 11:46:25', 'skibidi', 5, 3, 4.5, 2, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(16) NOT NULL,
  `email` varchar(60) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `premium` tinyint(1) NOT NULL,
  `potwierdzony` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `nazwa`, `email`, `haslo`, `premium`, `potwierdzony`, `admin`) VALUES
(25, 'asdasd', 'jacek12prokop@gmail.com', '$2y$10$jBqewraMif8ZzGM8wm720ecXtlR//0vOvLuH0xW9vSzALSAGroscK', 0, 1, 0),
(26, 'asdasd', 'jacek12prokop@gmail.com', '$2y$10$DLH5t394i7n0K1ilsiJ1f.U.gAtS7j4DphkBblOWQsfMwcZV2zcpO', 0, 1, 0),
(27, 'dfgdfg', 'jacek12prokop@gmail.com', '$2y$10$CKNPYsRGnueuXOa51SAPKuy.ncf1lQDURhU9J3bO2oFy2dIkr1.Va', 0, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wyniki`
--

CREATE TABLE `wyniki` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) NOT NULL,
  `punkty` int(11) NOT NULL,
  `maks_punkty` int(11) NOT NULL,
  `procent` decimal(5,2) NOT NULL,
  `odpowiedzi_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`odpowiedzi_json`)),
  `data_wykonania` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 1, 1),
(13, 12, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `odpowiedzi`
--
ALTER TABLE `odpowiedzi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pytanie_id` (`pytanie_id`);

--
-- Indeksy dla tabeli `odpowiedzi_uzytkownika`
--
ALTER TABLE `odpowiedzi_uzytkownika`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wynik_id` (`wynik_id`),
  ADD KEY `pytanie_id` (`pytanie_id`),
  ADD KEY `odpowiedz_id` (`odpowiedz_id`);

--
-- Indeksy dla tabeli `pytania`
--
ALTER TABLE `pytania`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indeksy dla tabeli `quizy`
--
ALTER TABLE `quizy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_quizy_kategoria` (`kategoria_id`),
  ADD KEY `fk_quizy_autor` (`id_autor`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `wyniki`
--
ALTER TABLE `wyniki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `odpowiedzi`
--
ALTER TABLE `odpowiedzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `odpowiedzi_uzytkownika`
--
ALTER TABLE `odpowiedzi_uzytkownika`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pytania`
--
ALTER TABLE `pytania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `quizy`
--
ALTER TABLE `quizy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wyniki`
--
ALTER TABLE `wyniki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `oceny`
--
ALTER TABLE `oceny`
  ADD CONSTRAINT `oceny_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizy` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oceny_ibfk_2` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `odpowiedzi`
--
ALTER TABLE `odpowiedzi`
  ADD CONSTRAINT `odpowiedzi_ibfk_1` FOREIGN KEY (`pytanie_id`) REFERENCES `pytania` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odpowiedzi_uzytkownika`
--
ALTER TABLE `odpowiedzi_uzytkownika`
  ADD CONSTRAINT `odpowiedzi_uzytkownika_ibfk_1` FOREIGN KEY (`wynik_id`) REFERENCES `wyniki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `odpowiedzi_uzytkownika_ibfk_2` FOREIGN KEY (`pytanie_id`) REFERENCES `pytania` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `odpowiedzi_uzytkownika_ibfk_3` FOREIGN KEY (`odpowiedz_id`) REFERENCES `odpowiedzi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pytania`
--
ALTER TABLE `pytania`
  ADD CONSTRAINT `pytania_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quizy`
--
ALTER TABLE `quizy`
  ADD CONSTRAINT `fk_quizy_autor` FOREIGN KEY (`id_autor`) REFERENCES `uzytkownicy` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_quizy_kategoria` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `wyniki`
--
ALTER TABLE `wyniki`
  ADD CONSTRAINT `wyniki_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `wyniki_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
