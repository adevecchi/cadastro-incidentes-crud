CREATE DATABASE `teste_red`
	CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE `teste_red`;
    
CREATE TABLE `incidentes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `criticidade` enum ('Alta', 'Média', 'Baixa') NOT NULL,
  `tipo` ENUM ('Ataque Brute Force', 'Credenciais Vazadas', 'Ataque de DDoS', 'Atividades anormais de usuário') NOT NULL,
  `status` ENUM ('Aberto', 'Fechado') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;