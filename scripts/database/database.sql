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
  FOREIGN KEY (`id_endereco`) REFERENCES `endereco`(`id_endereco`) ON DELETE CASCADE
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
  FOREIGN KEY (`id_endereco`) REFERENCES `endereco`(`id_endereco`) ON DELETE CASCADE
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
  FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario`(`id_funcionario`),
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

-- -----------------------------------------------------
-- Views Modelo mais vendido
-- -----------------------------------------------------
CREATE VIEW `motos_mais_vendidos` AS
SELECT 
    m.modelo AS modelo,
    COUNT(v.id_venda) AS venda
FROM 
    vendas v
LEFT JOIN 
    moto m ON v.id_moto = m.id_moto
GROUP BY 
    m.modelo
ORDER BY 
    venda DESC;
 
-- -----------------------------------------------------
-- Views Modelo mais vendido
-- ----------------------------------------------------- 
CREATE VIEW vendas_por_vendedor AS
SELECT 
    f.id_funcionario AS vendedor_id,
    f.nome AS vendedor_nome,
    COUNT(v.id_venda) AS total_vendas,
    SUM(v.valor_total_venda) AS total_valor_vendas
FROM 
    thunder_gears.vendas v
JOIN 
    thunder_gears.funcionario f ON v.id_funcionario = f.id_funcionario
GROUP BY 
    f.id_funcionario
ORDER BY 
    total_vendas DESC;

-- -----------------------------------------------------
-- Views Quantidade em estoque
-- -----------------------------------------------------
CREATE VIEW quantidade_em_estoque AS
SELECT 
    m.id_moto,
    m.modelo,
    m.marca,
    m.quantidade_estoque,
    m.status_moto
FROM 
    thunder_gears.moto m
WHERE 
    m.status_moto = 'disponivel' -- Filtrando apenas as motos disponíveis
ORDER BY 
    m.modelo;
    
-- -----------------------------------------------------
-- Views Reposição do estoque
-- -----------------------------------------------------    
CREATE VIEW status_reposicao AS
SELECT 
    m.id_moto,
    m.modelo,
    m.marca,
    m.quantidade_estoque,
    m.status_moto,
    CASE
        WHEN m.quantidade_estoque < 5 THEN 'Precisa repor'
        ELSE 'Estoque suficiente'
    END AS status_reposicao,
    '2024-12-10' AS previsao_chegada -- Essa é um data de exemplo
FROM 
    thunder_gears.moto m
WHERE 
    m.status_moto = 'disponivel'
ORDER BY 
    m.modelo;
    
-- -----------------------------------------------------
-- Views Status funcionário
-- -----------------------------------------------------    
CREATE VIEW status_funcionario AS
SELECT 
    f.id_funcionario,
    f.nome,
    f.cargo,
    f.status_funcionario,
    f.data_demissao,
    f.data_admissao,
    f.salario,
    f.telefone,
    f.email,
    f.foto_perfil,
    CASE
        WHEN f.status_funcionario = 'ativo' THEN 'Ativo'
        WHEN f.status_funcionario = 'inativo' THEN 'Desligado'
        WHEN f.status_funcionario = 'ferias' THEN 'Férias'
        WHEN f.status_funcionario = 'afastado' THEN 'Afastado'
        ELSE 'Status Indefinido' -- esse daqui é pra quando o cara foi demitido(teve férias permanentekkkkkkkkkkkk)
    END AS descricao_status
FROM 
    thunder_gears.funcionario f
ORDER BY 
    f.nome;
