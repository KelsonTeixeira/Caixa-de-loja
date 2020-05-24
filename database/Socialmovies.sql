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
  `Lancamento` VARCHAR(11) NULL,
  `Atores` VARCHAR(255) NULL,
  `Diretores` VARCHAR(255) NULL,
  `Ano` VARCHAR(4) NULL,
  PRIMARY KEY (`idTitulos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Socialmovies`.`Amizade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Socialmovies`.`Amizade` (
  `Usuario_idUsuario` INT NOT NULL,
  `Usuario_idUsuario1` INT NOT NULL,
  `idAmizade` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idAmizade`, `Usuario_idUsuario1`, `Usuario_idUsuario`),
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario1`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_Usuario_has_Usuario_Usuario1_idx` ON `Socialmovies`.`Amizade` (`Usuario_idUsuario1` ASC);

CREATE INDEX `fk_Usuario_has_Usuario_Usuario_idx` ON `Socialmovies`.`Amizade` (`Usuario_idUsuario` ASC);


-- -----------------------------------------------------
-- Table `Socialmovies`.`Assistido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Socialmovies`.`Assistido` (
  `idAssistido` INT NOT NULL AUTO_INCREMENT,
  `Opiniao` TEXT NULL,
  `Gostou` TINYINT(1) NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  `Titulo_idTitulos` INT NOT NULL,
  PRIMARY KEY (`idAssistido`, `Usuario_idUsuario`, `Titulo_idTitulos`),
  CONSTRAINT `fk_Opiniao_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Opiniao_Titulo1`
    FOREIGN KEY (`Titulo_idTitulos`)
    REFERENCES `Socialmovies`.`Titulo` (`idTitulos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_Opiniao_Usuario1_idx` ON `Socialmovies`.`Assistido` (`Usuario_idUsuario` ASC);

CREATE INDEX `fk_Opiniao_Titulo1_idx` ON `Socialmovies`.`Assistido` (`Titulo_idTitulos` ASC);


-- -----------------------------------------------------
-- Table `Socialmovies`.`SolicitacaoDeAmizade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Socialmovies`.`SolicitacaoDeAmizade` (
  `Usuario_idUsuario` INT NOT NULL,
  `Solicitante` INT NOT NULL,
  `idSolicitacaoDeAmizade` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idSolicitacaoDeAmizade`, `Usuario_idUsuario`, `Solicitante`),
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario2`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario3`
    FOREIGN KEY (`Solicitante`)
    REFERENCES `Socialmovies`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_Usuario_has_Usuario_Usuario3_idx` ON `Socialmovies`.`SolicitacaoDeAmizade` (`Solicitante` ASC);

CREATE INDEX `fk_Usuario_has_Usuario_Usuario2_idx` ON `Socialmovies`.`SolicitacaoDeAmizade` (`Usuario_idUsuario` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
