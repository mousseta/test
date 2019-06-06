DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `titre` varchar(80) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `idauteur` int(5) DEFAULT NULL,
  `article` text,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `datenaissance` date DEFAULT NULL,
  `login` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `email` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
