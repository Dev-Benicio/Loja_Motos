-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema thunder_gears
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema thunder_gears
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `thunder_gears` DEFAULT CHARACTER SET utf8 ;
USE `thunder_gears` ;

-- -----------------------------------------------------
-- Table `thunder_gears`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`endereco` (
  `id_endereco` INT NOT NULL AUTO_INCREMENT,
  `unidade_federativa` VARCHAR(2) NOT NULL,
  `cidade` VARCHAR(50) NOT NULL,
  `numero` VARCHAR(10) NOT NULL,
  `rua` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_endereco`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thunder_gears`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`cliente` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `telefone` VARCHAR(11) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `endereco_id_endereco` INT NOT NULL,
  PRIMARY KEY (`id_cliente`),
  INDEX `fk_cliente_endereco1_idx` (`endereco_id_endereco` ASC),
  CONSTRAINT `fk_cliente_endereco1`
    FOREIGN KEY (`endereco_id_endereco`)
    REFERENCES `thunder_gears`.`endereco` (`id_endereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thunder_gears`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`funcionario` (
  `id_funcionario` INT NOT NULL AUTO_INCREMENT,
  `login_funcionario` VARCHAR(20) NOT NULL,
  `senha` VARCHAR(20) NOT NULL,
  `nome` VARCHAR(60) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `cargo` VARCHAR(30) NOT NULL,
  `data_admissao` DATE NOT NULL,
  `data_demissao` DATE NULL DEFAULT NULL,
  `salario` DECIMAL(10,2) NOT NULL,
  `status_funcionario` VARCHAR(10) NULL DEFAULT 'ativo',
  `foto_perfil` VARCHAR(255) NOT NULL,
  `endereco_id_endereco` INT NOT NULL,
  PRIMARY KEY (`id_funcionario`),
  INDEX `fk_funcionario_endereco1_idx` (`endereco_id_endereco` ASC),
  CONSTRAINT `fk_funcionario_endereco1`
    FOREIGN KEY (`endereco_id_endereco`)
    REFERENCES `thunder_gears`.`endereco` (`id_endereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thunder_gears`.`moto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`moto` (
  `id_moto` INT NOT NULL AUTO_INCREMENT,
  `marca` VARCHAR(50) NOT NULL,
  `modelo` VARCHAR(50) NOT NULL,
  `combustivel` VARCHAR(20) NOT NULL,
  `preco` DECIMAL(10,2) NOT NULL,
  `ano` INT NOT NULL,
  `potencia_cavalos` INT NOT NULL,
  `consumo_km` VARCHAR(20) NOT NULL,
  `estoque` INT NOT NULL,
  `foto_moto` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_moto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thunder_gears`.`venda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`venda` (
  `id_venda` INT NOT NULL AUTO_INCREMENT,
  `metodo_pagamento` VARCHAR(20) NOT NULL,
  `valor_total_venda` DECIMAL(10,2) NOT NULL,
  `data_venda` DATE NOT NULL,
  `id_cliente` INT NOT NULL,
  `id_funcionario` INT NOT NULL,
  PRIMARY KEY (`id_venda`),
  INDEX (`id_cliente` ASC),
  INDEX (`id_funcionario` ASC),
  CONSTRAINT ``
    FOREIGN KEY (`id_cliente`)
    REFERENCES `thunder_gears`.`cliente` (`id_cliente`),
  CONSTRAINT ``
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `thunder_gears`.`funcionario` (`id_funcionario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thunder_gears`.`quantidade_vendida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`quantidade_vendida` (
  `id_quantidade_vendida` INT NOT NULL AUTO_INCREMENT,
  `id_venda` INT NOT NULL,
  `id_moto` INT NOT NULL,
  `quantidade` INT NOT NULL,
  PRIMARY KEY (`id_quantidade_vendida`),
  INDEX (`id_venda` ASC),
  INDEX (`id_moto` ASC),
  CONSTRAINT ``
    FOREIGN KEY (`id_venda`)
    REFERENCES `thunder_gears`.`venda` (`id_venda`),
  CONSTRAINT ``
    FOREIGN KEY (`id_moto`)
    REFERENCES `thunder_gears`.`moto` (`id_moto`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
