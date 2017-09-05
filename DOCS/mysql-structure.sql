-- MySQL Script generated by MySQL Workbench
-- Mon Sep  4 11:01:12 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `biblioteca` DEFAULT CHARACTER SET utf8 ;
USE `biblioteca` ;

-- -----------------------------------------------------
-- Table `biblioteca`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biblioteca`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COMMENT 'Nome do usuário',
  `email` VARCHAR(255) NOT NULL COMMENT 'E-mail do usuário',
  `password` VARCHAR(255) NOT NULL COMMENT 'Senha do usuário utilizando MD5',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biblioteca`.`book_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biblioteca`.`book_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(125) NOT NULL COMMENT 'Nome da categoria',
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biblioteca`.`book`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biblioteca`.`book` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_book_category` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL COMMENT 'Nome do livro',
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_book_book_category_idx` (`id_book_category` ASC),
  CONSTRAINT `fk_book_book_category`
    FOREIGN KEY (`id_book_category`)
    REFERENCES `biblioteca`.`book_category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biblioteca`.`renter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biblioteca`.`renter` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COMMENT 'Nome do locatário',
  `cpf` INT NOT NULL COMMENT 'CPF do locatário',
  `email` VARCHAR(255) NOT NULL COMMENT 'Email do locatário',
  `date_of_birth` DATE NOT NULL COMMENT 'Data de nascimento do locatário',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biblioteca`.`rental`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biblioteca`.`rental` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_renter` INT NOT NULL,
  `id_book` INT NOT NULL,
  `rent_date` DATE NULL  COMMENT 'Data do aluguel',
  `predicted_return_date` DATE NOT NULL COMMENT 'Data de previsão da devolução',
  `return_date` DATE NOT NULL COMMENT 'Data da devolução',
  `predicted_price` DOUBLE NOT NULL COMMENT 'Valor previsto do aluguel',
  `payment_price` DOUBLE NULL COMMENT 'Valor do pagamento',
  INDEX `fk_renter_has_book_book1_idx` (`id_book` ASC),
  INDEX `fk_renter_has_book_renter1_idx` (`id_renter` ASC),
  PRIMARY KEY (`id`),
  INDEX `renter_book` (`id_book` ASC, `id_renter` ASC),
  CONSTRAINT `fk_renter_has_book_renter1`
    FOREIGN KEY (`id_renter`)
    REFERENCES `biblioteca`.`renter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_renter_has_book_book1`
    FOREIGN KEY (`id_book`)
    REFERENCES `biblioteca`.`book` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `biblioteca`.`user_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `biblioteca`.`user_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL COMMENT 'Código do usuário',
  `id_book_category` INT NULL COMMENT 'código da categoria do livro',
  `id_book` INT NULL COMMENT 'código do livro',
  `id_rental` INT NULL COMMENT 'código do aluguel',
  `id_renter` INT NULL COMMENT 'código do locatário',
  `action` ENUM('cadastro', 'atualizado', 'deletado') NOT NULL COMMENT 'Ação',
  `description` TEXT NOT NULL COMMENT 'Descrição do log',
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `id_user`),
  INDEX `fk_user_log_user1_idx` (`id_user` ASC),
  INDEX `fk_user_log_book_category1_idx` (`id_book_category` ASC),
  INDEX `fk_user_log_book1_idx` (`id_book` ASC),
  INDEX `fk_user_log_rental1_idx` (`id_rental` ASC),
  INDEX `fk_user_log_renter1_idx` (`id_renter` ASC),
  CONSTRAINT `fk_user_log_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `biblioteca`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_log_book_category1`
    FOREIGN KEY (`id_book_category`)
    REFERENCES `biblioteca`.`book_category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_log_book1`
    FOREIGN KEY (`id_book`)
    REFERENCES `biblioteca`.`book` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_log_rental1`
    FOREIGN KEY (`id_rental`)
    REFERENCES `biblioteca`.`rental` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_log_renter1`
    FOREIGN KEY (`id_renter`)
    REFERENCES `biblioteca`.`renter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `biblioteca`.`user` (`name`, `email`, `password`) VALUES ('Rafael Mitsuo Moriya', 'rm.moriya@gmail.com', '$2y$10$Wa3K57IV81PMJ/3Wirue5.Y3J1y4h2vyulu9z.XNQEQvJqwyWzTGW');