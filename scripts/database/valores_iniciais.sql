INSERT INTO `cliente` VALUES (0, "José Benício Rocha", "11111111111", "Naquela rua", "61999999999", "josepatolinha@gmail.com", '2005-04-13');

SELECT * from cliente;

INSERT INTO `funcionario`
	(ID_funcionario, login, senha, nome, CPF, endereco, telefone, email, cargo, data_admissao, salario)
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
	(ID_moto, marca, modelo, tipo_motor, preco, potencia_cavalos, consumo_km)
VALUES(0, "Yamaha", "TX 8090", "combustão", 13090.560, "10", "10km/L");

INSERT INTO `venda` VALUES(0, "PIX", 12890.000, "2024-11-07", 0, 0);
