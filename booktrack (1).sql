-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 18 sep. 2024 à 22:48
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `booktrack`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(100) NOT NULL,
  `admin_mail` varchar(100) NOT NULL,
  `admin_pass` text NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_mail`, `admin_pass`) VALUES
(4, 'Eliel', 'elielnikiema16@gmail.com', '$2y$10$yji6p8SImIr0uxaGZTgKC.pAm5x8HjVWgaCI/V1wdp4z7efSq29Wi');

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `book_id` int NOT NULL AUTO_INCREMENT,
  `book_quote` int NOT NULL,
  `book_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `book_auth` varchar(100) NOT NULL,
  `book_copies` int NOT NULL,
  `library_id` int NOT NULL,
  PRIMARY KEY (`book_id`),
  UNIQUE KEY `UNIQUE` (`book_quote`),
  KEY `lib_bk_id` (`library_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`book_id`, `book_quote`, `book_title`, `book_auth`, `book_copies`, `library_id`) VALUES
(1, 1684058, 'Kotlin,Développement Mobile', 'Eliel NIKIEMA', 5, 11),
(2, 7419543, 'Systèmes d\'exploitations', 'Eliel NIKIEMA', 1, 13),
(3, 9654734, 'Programmation Java', 'Eliel NIKIEMA', 8, 12),
(5, 1684059, 'lat', 'lat', 2, 11),
(11, 12458678, 'raf', 'raf', 7, 17),
(10, 16840588, 'eliel', 'eliel', 14, 11),
(9, 95245689, 'eliel', 'eliel', 10, 11),
(13, 94681654, 'test', 'test', 24, 11),
(14, 99999999, 'rgeugehuge', 'gjzrz', 7, 17),
(15, 11111111, 'azertyuiozertrytuy etzrz', 'jvvgvgg', 5, 17);

-- --------------------------------------------------------

--
-- Structure de la table `borrow`
--

DROP TABLE IF EXISTS `borrow`;
CREATE TABLE IF NOT EXISTS `borrow` (
  `borrow_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `book_id` int NOT NULL,
  `librarian_id` int NOT NULL,
  `borrow_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `borrow_return` date NOT NULL,
  `borrow_status` enum('En cours','Retard','Retourné','') NOT NULL DEFAULT 'En cours',
  `notification_sent` tinyint(1) NOT NULL,
  PRIMARY KEY (`borrow_id`),
  KEY `stu_brw_id` (`student_id`),
  KEY `bk_brw_id` (`book_id`),
  KEY `libra_fk_ky` (`librarian_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `borrow`
--

INSERT INTO `borrow` (`borrow_id`, `student_id`, `book_id`, `librarian_id`, `borrow_date`, `borrow_return`, `borrow_status`, `notification_sent`) VALUES
(30, 1, 10, 15, '2024-09-11 23:37:00', '2024-09-11', 'Retourné', 0),
(26, 1, 10, 15, '2024-09-11 15:29:03', '2024-09-11', 'Retourné', 0),
(29, 10, 10, 15, '2024-09-11 23:08:03', '2024-09-11', 'Retourné', 0),
(24, 2, 10, 15, '2024-09-11 15:17:39', '2024-09-11', 'Retourné', 0),
(23, 2, 10, 15, '2024-09-11 15:17:30', '2024-09-11', 'Retourné', 1),
(28, 9, 10, 15, '2024-09-11 20:49:17', '2024-09-11', 'Retourné', 0),
(31, 1, 10, 15, '2024-09-11 23:37:10', '2024-09-11', 'Retourné', 0),
(32, 1, 10, 15, '2024-09-11 23:37:18', '2024-09-11', 'Retourné', 0),
(33, 2, 9, 15, '2024-09-11 23:37:36', '2024-09-11', 'Retourné', 0),
(34, 1, 1, 15, '2024-09-11 23:48:47', '2024-09-12', 'Retourné', 0),
(35, 1, 5, 15, '2024-09-12 01:20:19', '2024-09-12', 'Retourné', 0),
(36, 2, 1, 15, '2024-09-12 01:23:16', '2024-09-12', 'Retourné', 0),
(37, 9, 1, 15, '2024-09-10 01:23:43', '2024-09-11', 'Retard', 1),
(38, 11, 11, 13, '2024-09-12 15:55:43', '2024-09-18', 'Retourné', 0),
(39, 11, 11, 13, '2024-09-12 15:55:59', '2024-09-12', 'Retourné', 0),
(40, 1, 5, 15, '2024-09-13 12:47:38', '2024-09-13', 'Retourné', 0),
(41, 11, 11, 13, '2024-09-13 12:48:37', '2024-09-13', 'Retourné', 0),
(42, 1, 1, 15, '2024-09-14 21:08:35', '2024-09-24', 'En cours', 0),
(43, 1, 5, 15, '2024-09-14 21:09:20', '2024-09-18', 'Retourné', 0),
(44, 1, 5, 15, '2024-09-18 21:45:13', '2024-09-18', 'Retourné', 0),
(45, 1, 1, 15, '2024-09-18 21:47:38', '2024-09-28', 'En cours', 0),
(46, 1, 13, 15, '2024-09-18 22:17:43', '2024-09-28', 'En cours', 0),
(47, 11, 11, 13, '2024-09-18 22:26:18', '2024-09-28', 'En cours', 0),
(48, 11, 11, 13, '2024-09-18 22:26:25', '2024-09-18', 'Retourné', 0),
(49, 11, 14, 13, '2024-09-18 22:27:19', '2024-09-28', 'En cours', 0),
(50, 11, 15, 13, '2024-09-18 22:29:08', '2024-09-28', 'En cours', 0);

-- --------------------------------------------------------

--
-- Structure de la table `librarian`
--

DROP TABLE IF EXISTS `librarian`;
CREATE TABLE IF NOT EXISTS `librarian` (
  `librarian_id` int NOT NULL AUTO_INCREMENT,
  `librarian_name` varchar(100) NOT NULL,
  `librarian_mail` varchar(100) NOT NULL,
  `librarian_tel` varchar(100) NOT NULL,
  `librarian_pass` text NOT NULL,
  `library_id` int NOT NULL,
  `must_changes` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`librarian_id`),
  KEY `lib_lib_id` (`library_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `librarian`
--

INSERT INTO `librarian` (`librarian_id`, `librarian_name`, `librarian_mail`, `librarian_tel`, `librarian_pass`, `library_id`, `must_changes`) VALUES
(14, 'Eliel', 'elielnikiema16@gmail.com', '+226 77156305', '$2y$10$4kBK881W6AV4YQBo99.LmuNb2ZkJtkz0SBEHHFRjOm52qpl2IaBWm', 12, 0),
(13, 'Rafiatou', '', '+226 75787180', '$2y$10$hq.pW5DH3xlOrUB3zLFkyOT/P1xjWQpdCo13/6LO8zTqMDuBBwFKK', 17, 0),
(15, 'latif', 'elielnikiema16@gmail.com', '+226 75787179', '$2y$10$3dRkrTyjNHr3.d9UCPrmYOo.aICSGGdf4RWED38XVdvxPgHSsKdSC', 11, 0),
(16, 'test', '', '+226 75787179', '$2y$10$SqITS8.WNge3cNOIkQSH/u18IwBknXJNt9hDjS9apd5KOrDQIeL/O', 11, 0);

-- --------------------------------------------------------

--
-- Structure de la table `library`
--

DROP TABLE IF EXISTS `library`;
CREATE TABLE IF NOT EXISTS `library` (
  `library_id` int NOT NULL AUTO_INCREMENT,
  `library_name` varchar(100) NOT NULL,
  PRIMARY KEY (`library_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`library_id`, `library_name`) VALUES
(17, 'lm'),
(13, 'IUT'),
(18, 'tst'),
(12, 'ESI'),
(11, 'Gc');

-- --------------------------------------------------------

--
-- Structure de la table `notice`
--

DROP TABLE IF EXISTS `notice`;
CREATE TABLE IF NOT EXISTS `notice` (
  `notice_id` int NOT NULL AUTO_INCREMENT,
  `librarian_id` int NOT NULL,
  `notice_date` datetime NOT NULL,
  `notice_msg` text NOT NULL,
  PRIMARY KEY (`notice_id`),
  KEY `lib_nt_id` (`librarian_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int NOT NULL AUTO_INCREMENT,
  `student_ine` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `student_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `student_mail` varchar(100) NOT NULL,
  `library_id` int NOT NULL,
  `student_pass` text NOT NULL,
  `creation_date` timestamp NOT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `student_ine` (`student_ine`),
  KEY `lib_stu_id` (`library_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`student_id`, `student_ine`, `student_name`, `student_mail`, `library_id`, `student_pass`, `creation_date`) VALUES
(1, 'N00162020221', 'Eliel NIKIEMA', 'elielnikiema16@gmail.com', 11, '$2y$10$LUnThMcmCblJiTHtVPSkLech3FoGxBG8DaYHlyoA6KWNT29Ybjm0C', '2024-08-31 18:16:46'),
(2, 'N11111111111', 'Déborah KARFO', 'gertrude@wendpassia.com', 11, 'gertrude', '2024-08-31 18:16:55'),
(3, 'N02182024222', 'Doriane POUAN', 'dodopouan@yahoo.fr', 13, 'doriane', '2024-08-31 18:17:03'),
(11, 'N00172024221', 'josue sekone', 'sekonejosue12@gmail.com', 17, '$2y$10$zur0Ylikg6oSiE.s8Dbr1eviw6SEgnXSsc7LX9qC12mm6ncXQrXbO', '2024-09-12 15:53:45'),
(8, 'N00000000000', 'picolo', 'nacana170@gmail.com', 11, '$2y$10$.r.wnYzTmHUsPyuoimLALu7LT4eeZkRJcFlCNzlD1PfrtHJLQEVC2', '2024-09-07 18:36:33'),
(9, 'N99999999999', 'wendkuni', 'elielnikiema646@gmail.com', 11, '$2y$10$9eBCsYgroCWBanS5WGRia.KNLTtTVXY/ZBkrKJ18XWC7geZmIYmoy', '2024-09-07 19:00:27'),
(10, 'N88888888888', 'kuni', 'elielnikiema95@gmail.com', 11, '$2y$10$vLWt7HIHOboDSeqlVL8AMO8pc8JJ2LjvJx3LYb/V5OH9tH2.cUBDS', '2024-09-07 19:25:57');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
