-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema Socialmovies
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Socialmovies
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Socialmovies` DEFAULT CHARACTER SET utf8 ;
USE `Socialmovies` ;

-- -----------------------------------------------------
-- Table `Socialmovies`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Socialmovies`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `Nome` VARCHAR(50) NOT NULL,
  `Username` VARCHAR(25) NULL,
  `Senha` VARCHAR(32) NULL,
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Socialmovies`.`Titulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Socialmovies`.`Titulo` (
  `idTitulos` INT NOT NULL AUTO_INCREMENT,
  `idImdb` VARCHAR(20) NOT NULL,
  `Titulo` VARCHAR(100) NOT NULL,
  `Sinopse` VARCHAR(45) NULL,
  `DataLancamento` VARCHAR(11) NULL,
  `Atores` VARCHAR(255) NULL,
  `Diretores` VARCHAR(255) NULL,
  `Ano` VARCHAR(4) NULL,
  PRIMARY KEY (`idTitulos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Socialmovies`.`Assistido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Socialmovies`.`Assistido` (
  `idAssistido` INT NOT NULL AUTO_INCREMENT,
  `Opiniao` TEXT NULL,
  `Gostou` TINYINT(1) NOT NULL,
  `idTitulos` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idAssistido`),
  CONSTRAINT `fk_Assistido_Titulo1`
    FOREIGN KEY (`idTitulos`)
    REFERENCES `Socialmovies`.`Titulo` (`idTitulos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Assistido_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_Assistido_Titulo1_idx` ON `Socialmovies`.`Assistido` (`idTitulos` ASC);

CREATE INDEX `fk_Assistido_Usuario1_idx` ON `Socialmovies`.`Assistido` (`idUsuario` ASC);


-- -----------------------------------------------------
-- Table `Socialmovies`.`Amizade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Socialmovies`.`Amizade` (
  `idAmizade` INT NOT NULL AUTO_INCREMENT,
  `idAmigoUm` INT NOT NULL,
  `idAmigoDois` INT NOT NULL,
  PRIMARY KEY (`idAmizade`),
  CONSTRAINT `fk_Amizade_Usuario1`
    FOREIGN KEY (`idAmigoUm`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Amizade_Usuario2`
    FOREIGN KEY (`idAmigoDois`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_Amizade_Usuario1_idx` ON `Socialmovies`.`Amizade` (`idAmigoUm` ASC);

CREATE INDEX `fk_Amizade_Usuario2_idx` ON `Socialmovies`.`Amizade` (`idAmigoDois` ASC);


-- -----------------------------------------------------
-- Table `Socialmovies`.`SolicitacaoAmizade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Socialmovies`.`SolicitacaoAmizade` (
  `idSolicitacaoAmizade` INT NOT NULL AUTO_INCREMENT,
  `idSolicitante` INT NOT NULL,
  `idSolicitado` INT NOT NULL,
  PRIMARY KEY (`idSolicitacaoAmizade`),
  CONSTRAINT `fk_SolicitacaoAmizade_Usuario1`
    FOREIGN KEY (`idSolicitante`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_SolicitacaoAmizade_Usuario2`
    FOREIGN KEY (`idSolicitado`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_SolicitacaoAmizade_Usuario1_idx` ON `Socialmovies`.`SolicitacaoAmizade` (`idSolicitante` ASC);

CREATE INDEX `fk_SolicitacaoAmizade_Usuario2_idx` ON `Socialmovies`.`SolicitacaoAmizade` (`idSolicitado` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
