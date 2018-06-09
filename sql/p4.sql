-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 08 juin 2018 à 11:27
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `p4`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_comment` datetime NOT NULL,
  `report` int(11) NOT NULL DEFAULT '0',
  `moderation` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`ID`, `title`, `date_create`, `content`) VALUES
(1, 'Mon premier récit test', '2018-05-18 14:49:51', '\r\n\r\nConstituendi autem sunt qui sint in amicitia fines et quasi termini diligendi. De quibus tres video sententias ferri, quarum nullam probo, unam, ut eodem modo erga amicum adfecti simus, quo erga nosmet ipsos, alteram, ut nostra in amicos benevolentia illorum erga nos benevolentiae pariter aequaliterque respondeat, tertiam, ut, quanti quisque se ipse facit, tanti fiat ab amicis.\r\n\r\nQuapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere non potest; deinde cum similis sensus exstitit amoris, si aliquem nacti sumus cuius cum moribus et natura congruamus, quod in eo quasi lumen aliquod probitatis et virtutis perspicere videamur.\r\n\r\nAlii summum decus in carruchis solito altioribus et ambitioso vestium cultu ponentes sudant sub ponderibus lacernarum, quas in collis insertas cingulis ipsis adnectunt nimia subtegminum tenuitate perflabiles, expandentes eas crebris agitationibus maximeque sinistra, ut longiores fimbriae tunicaeque perspicue luceant varietate liciorum effigiatae in species animalium multiformes.\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_sign` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` int(11) NOT NULL DEFAULT '0',
  `country` varchar(255) NOT NULL DEFAULT 'undefinied',
  `avatar_path` varchar(255) NOT NULL DEFAULT 'undefinied',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `login`, `password`, `email`, `date_sign`, `admin`, `country`, `avatar_path`) VALUES
(1, 'Jean-Pierre', '$2y$10$ZbI9aoV4u94WjHWe6KNcRucZSnT.jAhldx44KZH6dYIoekGLgKCUq', 'jean.jean@gmail.com', '2018-05-29 19:34:43', 0, 'undefinied', 'undefinied'),
(2, 'Marc', '$2y$10$A.jjx1Ns4Bd9ZkWx6lNGLecqu2p7yaKMOtgxJ4hS2pQ.vvi9Bt/gO', 'marc.marc@gmail.com', '2018-05-31 10:44:58', 0, 'undefinied', 'undefinied'),
(3, 'Marie', '$2y$10$JrxK2iKE48rt/GHfeHt40e60qYC1wyvMJOSdYMBl6pPAaeDvp1h7e', 'marie.marie@gmail.com', '2018-05-31 16:52:31', 0, 'undefinied', 'undefinied'),
(6, 'Raymond', '$2y$10$LOKj7BXxs7LdoS2gIbB4subXgMk9T/VkUFZ0UxOv7R93dho66wtgi', 'raymond@gmail.com', '2018-05-31 17:48:49', 0, 'undefinied', 'undefinied'),
(7, 'Guillaume', '$2y$10$N7tWR3DAV0R7ZFJ51WYt6.uamMf/3FVd1kfQoclcIL5nnRte9hCUi', 'guigui@gmail.com', '2018-06-01 14:43:17', 0, 'France', 'public/images/user_avatar/7.jpg'),
(8, 'Jean-Philippe', '$2y$10$U53Ld/kdpfSyIbEKLcwh.uNeqyrKFNK36OP.sRw9kq1c/vjkXGizK', 'philou@gmail.com', '2018-06-06 21:39:06', 0, 'undefinied', 'undefinied');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
