-- MySQL Script generated by MySQL Workbench
-- Thu Jun 13 12:26:38 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dbcursouni
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbcursouni
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbcursouni` DEFAULT CHARACTER SET utf8 ;
USE `dbcursouni` ;

-- -----------------------------------------------------
-- Table `dbcursouni`.`usuariox`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`usuariox` (
  `idusuariox` INT NOT NULL AUTO_INCREMENT,
  `dnix` CHAR(8) NOT NULL,
  `apelx` VARCHAR(80) NOT NULL,
  `nomx` VARCHAR(80) NOT NULL,
  `celx` CHAR(9) NOT NULL,
  `dirx` VARCHAR(150) NULL,
  `emailx` VARCHAR(80) NOT NULL,
  `fotox` TEXT NULL,
  `fecha` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idusuariox`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`categoriax`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`categoriax` (
  `idcategoriax` INT NOT NULL AUTO_INCREMENT,
  `nomx` VARCHAR(100) NOT NULL,
  `descx` VARCHAR(150) NULL,
  PRIMARY KEY (`idcategoriax`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`cursox`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`cursox` (
  `idcursox` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `docentex` TEXT NOT NULL,
  `estadox` TINYINT NOT NULL,
  `idcategoriax` INT NOT NULL,
  PRIMARY KEY (`idcursox`),
  CONSTRAINT `categoriax1`
    FOREIGN KEY (`idcategoriax`)
    REFERENCES `dbcursouni`.`categoriax` (`idcategoriax`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`temax`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`temax` (
  `idtemax` INT NOT NULL AUTO_INCREMENT,
  `temx` TEXT NOT NULL,
  `estadox` TINYINT NOT NULL,
  `idcursox` INT NOT NULL,
  PRIMARY KEY (`idtemax`),
  CONSTRAINT `cursox1`
    FOREIGN KEY (`idcursox`)
    REFERENCES `dbcursouni`.`cursox` (`idcursox`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`tipo_recursox`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`tipo_recursox` (
  `idtipo_recursox` INT NOT NULL AUTO_INCREMENT,
  `tipox` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`idtipo_recursox`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`recursox`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`recursox` (
  `idrecursox` INT NOT NULL AUTO_INCREMENT,
  `recurso` TEXT NOT NULL,
  `f_regis` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `icono` TEXT NULL,
  `idtipo_recursox` INT NOT NULL,
  `idtemax` INT NOT NULL,
  PRIMARY KEY (`idrecursox`),
  CONSTRAINT `tipo_recursox`
    FOREIGN KEY (`idtipo_recursox`)
    REFERENCES `dbcursouni`.`tipo_recursox` (`idtipo_recursox`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `temax1`
    FOREIGN KEY (`idtemax`)
    REFERENCES `dbcursouni`.`temax` (`idtemax`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`usux`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`usux` (
  `idusux` INT NOT NULL AUTO_INCREMENT,
  `usux` VARCHAR(120) NOT NULL,
  `clvx` VARCHAR(150) NOT NULL,
  `estadox` TINYINT NOT NULL,
  `idusuariox` INT NOT NULL,
  PRIMARY KEY (`idusux`),
  CONSTRAINT `usuariox1`
    FOREIGN KEY (`idusuariox`)
    REFERENCES `dbcursouni`.`usuariox` (`idusuariox`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`viewx`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`viewx` (
  `idviewx` INT NOT NULL AUTO_INCREMENT,
  `view_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `user_ip` TEXT NULL,
  `idrecursox` INT NOT NULL,
  `idusux` INT NOT NULL,
  PRIMARY KEY (`idviewx`),
  CONSTRAINT `recursox1`
    FOREIGN KEY (`idrecursox`)
    REFERENCES `dbcursouni`.`recursox` (`idrecursox`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `usux1`
    FOREIGN KEY (`idusux`)
    REFERENCES `dbcursouni`.`usux` (`idusux`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`encuestax`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`encuestax` (
  `idencuestax` INT NOT NULL AUTO_INCREMENT,
  `titulox` VARCHAR(255) NOT NULL,
  `descripx` TEXT NULL,
  `f_creacion` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idencuestax`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`preguntax`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`preguntax` (
  `idpreguntax` INT NOT NULL AUTO_INCREMENT,
  `texto_pregunta` TEXT NOT NULL,
  `tipo_pregunta` ENUM('multiple_choice', 'single_choice', 'text') NOT NULL,
  `idencuestax` INT NOT NULL,
  PRIMARY KEY (`idpreguntax`),
  CONSTRAINT `encuestax1`
    FOREIGN KEY (`idencuestax`)
    REFERENCES `dbcursouni`.`encuestax` (`idencuestax`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`opcionx`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`opcionx` (
  `idopcionx` INT NOT NULL AUTO_INCREMENT,
  `texto_opcionx` TEXT NOT NULL,
  `idpreguntax` INT NOT NULL,
  PRIMARY KEY (`idopcionx`),
  CONSTRAINT `preguntax1`
    FOREIGN KEY (`idpreguntax`)
    REFERENCES `dbcursouni`.`preguntax` (`idpreguntax`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`respuestax`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`respuestax` (
  `idrespuestax` INT NOT NULL,
  `texto_respuesta` TEXT NULL,
  `f_respuesta` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `idpreguntax` INT NOT NULL,
  `idusux` INT NOT NULL,
  `idopcionx` INT NULL,
  PRIMARY KEY (`idrespuestax`),
  CONSTRAINT `preguntax2`
    FOREIGN KEY (`idpreguntax`)
    REFERENCES `dbcursouni`.`preguntax` (`idpreguntax`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `usux2`
    FOREIGN KEY (`idusux`)
    REFERENCES `dbcursouni`.`usux` (`idusux`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `opcionx1`
    FOREIGN KEY (`idopcionx`)
    REFERENCES `dbcursouni`.`opcionx` (`idopcionx`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`sliderx`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`sliderx` (
  `idsliderx` INT NOT NULL AUTO_INCREMENT,
  `imagen` TEXT NOT NULL,
  `descripcion` TEXT NOT NULL,
  PRIMARY KEY (`idsliderx`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`sugerenciax`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`sugerenciax` (
  `idsugerenciax` INT NOT NULL AUTO_INCREMENT,
  `descx` TEXT NOT NULL,
  `f_registro` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `idusux` INT NOT NULL,
  PRIMARY KEY (`idsugerenciax`),
  CONSTRAINT `usux3`
    FOREIGN KEY (`idusux`)
    REFERENCES `dbcursouni`.`usux` (`idusux`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbcursouni`.`notificacionx`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcursouni`.`notificacionx` (
  `idnotificacionx` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `mensaje` TEXT NOT NULL,
  `leido` TINYINT NULL DEFAULT 0,
  `fec` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `idusux` INT NOT NULL,
  PRIMARY KEY (`idnotificacionx`),
  CONSTRAINT `usux4`
    FOREIGN KEY (`idusux`)
    REFERENCES `dbcursouni`.`usux` (`idusux`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
