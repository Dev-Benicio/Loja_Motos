INSERT INTO `cliente`
  (id_cliente, nome, cpf, id_endereco, telefone, email, data_nascimento)
VALUES (
  0,
  "José Benício Rocha",
  "11111111111",
  "Naquela rua",
  "61999999999",
  "josepatolinha@gmail.com",
  '2005-04-13'
);

INSERT INTO `funcionario`
	(id_funcionario, login, senha, nome, CPF, endereco, telefone, email, cargo, data_admissao, salario)
VALUES (
  '0',
  'admin',
  'root',
  'Daniel Medeiros', 
  '22222222222',
  'Rua do limoeiro',
  '61988888888',
  'dielotakuloko@gmail.com',
  'administrador',
  '2024-11-07',
  1900.500
);

INSERT INTO `moto`
	(id_moto, marca, modelo, tipo_motor, preco, estoque, potencia_cavalos, consumo_km)
VALUES
  (0, "Yamaha", "TX 8090", "combustão", 13090.560, "2" "10", "10km/L");

INSERT INTO `venda` VALUES(0, "PIX", 12890.000, "2024-11-07", 0, 0);

-- -----------------------------------------------------
-- Segundo - cliente
-- -----------------------------------------------------

INSERT INTO `cliente` VALUES (0, "Aloísio Chulapa", "11111111111", "Naquela outra rua", "61999999999", "Alu.Chulapaa@gmail.com", '1984-04-20');

SELECT * from cliente;

INSERT INTO `funcionario`
	(id_funcionario, login_funcionario, senha, nome, CPF, endereco, telefone, email, cargo, data_admissao, salario)
VALUES (
  '0',
  'admin',
  'root',
  'Marcos Demacol', 
  '33333333333',
  'São Paulo',
  '61988888888',
  'sentiFirmeza@gmail.com',
  'administrador',
  '2024-11-07',
  1900.500
);

INSERT INTO `moto`
	(is_moto, marca, modelo, tipo_motor, preco, estoque potencia_cavalos, consumo_km)
VALUES(0, "Honda", "CG 160 Titan", "combustão", 13090.560, "10", "10km/L");

INSERT INTO `venda` VALUES(0, "Credito", 12890.000, "12", "2024-11-07", 0, 0);

-- -----------------------------------------------------
-- Terceiro - cliente
-- -----------------------------------------------------

INSERT INTO `cliente` VALUES (0, "Junior filho de junior", "11111111111", "Ali naquela rua", "61999999999", "Junior.FJunior@gmail.com", '2000-04-12');

SELECT * from cliente;

INSERT INTO `funcionario`
	(id_funcionario, login_funcionario, senha, nome, CPF, endereco, telefone, email, cargo, data_admissao, salario)
VALUES (
  '0',
  'admin',
  'root',
  'Leandro Marmota', 
  '77777777777',
  'Rio de Janeiro',
  '61988888888',
  'marmotaaa.Lea@gmail.com',
  'administrador',
  '2024-11-07',
  1900.500
);

INSERT INTO `moto`
	(ID_moto, marca, modelo, tipo_motor, preco, estoque, potencia_cavalos, consumo_km)
VALUES(0, "Kawazaki", "Ninja  ZX-10R", "combustão", 13090.560, "10", "10", "10km/L");

INSERT INTO `venda` VALUES(0, "Credito", 120190.000, "2024-11-07", 0, 0);
