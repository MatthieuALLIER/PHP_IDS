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
  `id_user` int(11) NOT NULL,
  `answer_text` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_answer`),
  KEY `id_post` (`id_post`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`),
  CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table forum.answer : ~1 rows (environ)
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` (`id_answer`, `id_post`, `id_user`, `answer_text`, `date`) VALUES
	(1, 1, 1, 'Réponse 1', '2021-04-16 15:01:14');
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;

-- Listage de la structure de la table forum. liker
CREATE TABLE IF NOT EXISTS `liker` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  UNIQUE KEY `id_post` (`id_post`,`id_user`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `liker_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`),
  CONSTRAINT `liker_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table forum.liker : ~1 rows (environ)
/*!40000 ALTER TABLE `liker` DISABLE KEYS */;
INSERT INTO `liker` (`id_post`, `id_user`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `liker` ENABLE KEYS */;

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
INSERT INTO `post` (`id_post`, `id_user`, `title`, `post_text`, `post_date`) VALUES
	(1, 1, 'Titre du post de test', 'Ceci est le texte du post de test', '2021-04-11 16:33:08');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Listage de la structure de la table forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table forum.user : ~1 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `pseudo`, `password`) VALUES
	(1, 'pseudo1', 'xxx');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
