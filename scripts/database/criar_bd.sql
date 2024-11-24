SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema thunder_gears
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `thunder_gears` DEFAULT CHARACTER SET utf8;
USE `thunder_gears` ;

-- -----------------------------------------------------
-- Table `thunder_gears`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`cliente` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `id_endereco` INT NOT NULL,
  `telefone` VARCHAR(11) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  PRIMARY KEY (`id_cliente`),
  FOREIGN KEY (`id_endereco`) REFERENCES `endereco`(`id_endereco`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `thunder_gears`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`funcionario` (
  `id_funcionario` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(20) NOT NULL,
  `senha` VARCHAR(20) NOT NULL,
  `nome` VARCHAR(60) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `id_endereco` INT NOT NULL,
  `telefone` VARCHAR(11) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `cargo` VARCHAR(30) NOT NULL,
  `data_admissao` DATE NOT NULL,
  `data_demissao` DATE,
  `salario` DECIMAL(10, 2) NOT NULL,
  `status_funcionario` VARCHAR(10) DEFAULT 'ativo', -- status: ativo, inativo
  `foto_perfil` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_funcionario`),
  FOREIGN KEY (`id_endereco`) REFERENCES `endereco`(`id_endereco`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `thunder_gears`.`moto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`moto` (
  `id_moto` INT NOT NULL AUTO_INCREMENT,
  `marca` VARCHAR(50) NOT NULL,
  `modelo` VARCHAR(50) NOT NULL,
  `tipo_motor` VARCHAR(20) NOT NULL, -- tipo de motor: combustivel, diesel, gasolina, eletrico
  `preco` DECIMAL(10,2) NOT NULL,
  `ano` YEAR NOT NULL,
  `potencia_cavalos` INT NOT NULL,
  `consumo_km` VARCHAR(20) NOT NULL,
  `quantidade_estoque` INT NOT NULL,
  `foto_moto` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_moto`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `thunder_gears`.`venda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`venda` (
  `id_venda` INT NOT NULL AUTO_INCREMENT,
  `metodo_pagamento` VARCHAR(20) NOT NULL,
  `valor_total_venda` DECIMAL(10,2) NOT NULL,
  `data_venda` DATE NOT NULL,
  `quantidade_vendida` INT NOT NULL DEFAULT 1,
  `id_cliente` INT NOT NULL,
  `id_funcionario` INT NOT NULL,
  `id_moto` INT NOT NULL,
  PRIMARY KEY (`id_venda`),
  FOREIGN KEY (`id_cliente`) REFERENCES `cliente`(`id_cliente`),
  FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario`(`id_funcionario`)
  FOREIGN KEY (`id_moto`) REFERENCES `moto`(`id_moto`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `thunder_gears`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thunder_gears`.`endereco` (
  `id_endereco` INT NOT NULL AUTO_INCREMENT,
  `unidade_federativa` CHAR(2) NOT NULL,
  `cidade` VARCHAR(50) NOT NULL,
  `numero` VARCHAR(10) NOT NULL,
  `rua` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_endereco`)
) ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
