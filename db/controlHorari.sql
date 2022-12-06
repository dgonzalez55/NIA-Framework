DROP DATABASE IF EXISTS `controlHorari`;
CREATE DATABASE IF NOT EXISTS `controlHorari` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `controlHorari`;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(64) NOT NULL,
  `password` CHAR(60) NOT NULL,
  `role` VARCHAR(64) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUser`)
);

DROP TABLE IF EXISTS `marcatges`;
CREATE TABLE IF NOT EXISTS `marcatges` (
  `idMarcatge` INT NOT NULL AUTO_INCREMENT,
  `idUser` INT NOT NULL,
  `tipus` ENUM('Entrada','Sortida') NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idMarcatge`),
  FOREIGN KEY (`idUser`) REFERENCES `users`(`idUser`) ON UPDATE CASCADE ON DELETE CASCADE
);

-- --------------------------------------------------------

INSERT INTO `users`(`email`,`password`,`role`) VALUES('anonim@educem.com','$2y$10$lIs8q5weNERTcLvnf2liDe/kv30eKZNXcEV26g21E5NlxGPrZZ6pG','Usuari sense privilegis');
INSERT INTO `users`(`email`,`password`,`role`) VALUES('trump@educem.com','$2y$10$g4im92dXDQLNexxfmHs0UO2Yn5/Y5/oyG9UTHz/pLF39ds5pq4HSS','Supervisor');
INSERT INTO `users`(`email`,`password`,`role`) VALUES('biden@educem.com','$2y$10$WRSC9uVoMKwgWYVOp6v/muOp8/tWyIxAXWk/qZgihbU6iGhRr1TiO','Administrador');
