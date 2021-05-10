-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           10.5.9-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour forum
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `forum`;

-- Listage de la structure de la table forum. answer
CREATE TABLE IF NOT EXISTS `answer` (
  `id_answer` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `reference_answer` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `answer_text` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_answer`),
  KEY `id_post` (`id_post`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`),
  CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table forum.answer : ~5 rows (environ)
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
REPLACE INTO `answer` (`id_answer`, `id_post`, `reference_answer`, `id_user`, `answer_text`, `date`) VALUES
	(1, 1, 0, 2, 'First answer', '2021-04-16 15:01:14'),
	(2, 1, 0, 1, 'Second answer', '2021-04-21 11:40:05'),
	(3, 1, 1, 1, 'Answer to the first answer', '2021-04-19 16:17:16'),
	(4, 1, 2, 1, 'Answer to the second answer', '2021-04-21 11:40:11'),
	(5, 1, 3, 1, 'level 3 answer', '2021-04-21 11:43:23');
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;

-- Listage de la structure de la table forum. answer_like
CREATE TABLE IF NOT EXISTS `answer_like` (
  `id_answer` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_answer`,`id_user`),
  KEY `FK__user` (`id_user`,`id_answer`) USING BTREE,
  CONSTRAINT `FK__answer` FOREIGN KEY (`id_answer`) REFERENCES `answer` (`id_answer`),
  CONSTRAINT `FK__user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table forum.answer_like : ~1 rows (environ)
/*!40000 ALTER TABLE `answer_like` DISABLE KEYS */;
REPLACE INTO `answer_like` (`id_answer`, `id_user`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `answer_like` ENABLE KEYS */;

-- Listage de la structure de la table forum. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `title` text NOT NULL,
  `post_text` text NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table forum.post : ~1 rows (environ)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
REPLACE INTO `post` (`id_post`, `id_user`, `title`, `post_text`, `post_date`) VALUES
	(1, 1, 'Titre du post de test', 'Ceci est le texte du post de test', '2021-04-11 16:33:08');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Listage de la structure de la table forum. post_like
CREATE TABLE IF NOT EXISTS `post_like` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_post`,`id_user`) USING BTREE,
  KEY `id_user` (`id_user`,`id_post`) USING BTREE,
  CONSTRAINT `post_like_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`),
  CONSTRAINT `post_like_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table forum.post_like : ~2 rows (environ)
/*!40000 ALTER TABLE `post_like` DISABLE KEYS */;
REPLACE INTO `post_like` (`id_post`, `id_user`) VALUES
	(1, 1),
	(1, 2);
/*!40000 ALTER TABLE `post_like` ENABLE KEYS */;

-- Listage de la structure de la table forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table forum.user : ~2 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`id_user`, `pseudo`, `password`) VALUES
	(1, 'pseudo1', 'xxx'),
	(2, 'mallier', '27032204');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
