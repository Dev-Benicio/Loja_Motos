--------------------------------------------------------------------------------
-- Motos
--------------------------------------------------------------------------------
INSERT INTO moto
  (modelo, marca, ano, tipo_motor, potencia_cavalos, preco, consumo_km, quantidade_estoque, foto_moto)
VALUES
('CBR 1000RR', 'Honda', 2023, 'Combustão', 214, 120000.00, 12, 5, 'cbr1000rr.jpg'),
('Ninja ZX-10R', 'Kawasaki', 2023, 'Combustão', 203, 115000.00, 15, 3, 'ninja-zx10r.jpg'),
('GSX-R1000', 'Suzuki', 2023, 'Combustão', 202, 110000.00, 14, 4, 'gsxr1000.jpg'),
('YZF R1', 'Yamaha', 2023, 'Combustão', 200, 118000.00, 15, 6, 'yzf-r1.jpg'),
('Panigale V4', 'Ducati', 2023, 'Combustão', 214, 150000.00, 16, 2, 'panigale-v4.jpg'),
('S1000RR', 'BMW', 2023, 'Combustão', 207, 135000.00, 15, 4, 's1000rr.jpg'),
('RSV4', 'Aprilia', 2023, 'Combustão', 217, 140000.00, 16, 3, 'rsv4.jpg'),
('MT-09', 'Yamaha', 2023, 'Combustão', 119, 55000.00, 18, 8, 'mt09.jpg'),
('Z900', 'Kawasaki', 2023, 'Combustão', 125, 52000.00, 19, 7, 'z900.jpg'),
('Street Triple', 'Triumph', 2023, 'Combustão', 123, 65000.00, 17, 5, 'street-triple.jpg');

--------------------------------------------------------------------------------
-- Funcionarios
--------------------------------------------------------------------------------
INSERT INTO endereco
 (unidade_federativa, cidade, numero, rua)
VALUES
('SP', 'São Paulo', 123, 'Rua das Flores'),
('SP', 'Campinas', 456, 'Avenida Brasil'),
('RJ', 'Rio de Janeiro', 789, 'Rua do Sol'),
('MG', 'Belo Horizonte', 321, 'Rua das Palmeiras'),
('PR', 'Curitiba', 654, 'Avenida das Araucárias')

INSERT INTO funcionario
  (login, senha, nome, cpf, id_endereco, telefone, email, cargo, data_admissao, salario, foto_perfil)
VALUES
('joao silva', 'senha123', 'João Silva', '12345678901', 1, '11999887766', 'joao.silva@email.com', 'vendedor', '2023-01-15', 3500.00, 'joao.jpg'),
('maria santos', 'senha456', 'Maria Santos', '23456789012', 2, '11988776655', 'maria.santos@email.com', 'estoquista', '2022-08-20', 5500.00, 'maria.jpg'),
('pedro oliveira', 'senha789', 'Pedro Oliveira', '34567890123', 3, '11977665544', 'pedro.oliveira@email.com', 'estoquista', '2023-03-10', 4000.00, 'pedro.jpg'),
('ana costa', 'senha321', 'Ana Costa', '45678901234', 4, '11966554433', 'ana.costa@email.com', 'vendedor', '2023-02-01', 3500.00, 'ana.jpg'),
('carlos ferreira', 'senha654', 'Carlos Ferreira', '56789012345', 5, '11955443322', 'carlos.ferreira@email.com', 'gerente', '2022-11-05', 4000.00, 'carlos.jpg')

--------------------------------------------------------------------------------
-- Clientes
--------------------------------------------------------------------------------

INSERT INTO endereco
 (unidade_federativa, cidade, numero, rua)
VALUES
('SP', 'São Paulo', 789, 'Rua dos Pinheiros'),
('RJ', 'Niterói', 234, 'Avenida Beira Mar'),
('MG', 'Uberlândia', 567, 'Rua das Acácias'),
('RS', 'Porto Alegre', 890, 'Rua dos Andradas'),
('SC', 'Florianópolis', 123, 'Avenida Beira Mar Norte'),
('PR', 'Londrina', 456, 'Rua Sergipe'),
('BA', 'Salvador', 789, 'Avenida Oceânica'),
('PE', 'Recife', 321, 'Rua da Aurora'),
('GO', 'Goiânia', 654, 'Avenida Goiás'),
('DF', 'Brasília', 987, 'Quadra 202 Sul')

INSERT INTO cliente
  (nome, cpf, id_endereco, telefone, email, data_nascimento)
VALUES
('Roberto Silva', '78901234567', 6, '11944332211', 'roberto.silva@email.com', '1990-05-15'),
('Amanda Santos', '89012345678', 7, '21933221100', 'amanda.santos@email.com', '1988-08-22'),
('Lucas Oliveira', '90123456789', 8, '31922110099', 'lucas.oliveira@email.com', '1995-03-10'),
('Juliana Costa', '01234567890', 9, '41911009988', 'juliana.costa@email.com', '1992-11-30'),
('Fernando Lima', '12345678901', 10, '51900998877', 'fernando.lima@email.com', '1985-07-25'),
('Mariana Souza', '23456789012', 11, '61988776655', 'mariana.souza@email.com', '1993-09-18'),
('Ricardo Santos', '34567890123', 12, '71977665544', 'ricardo.santos@email.com', '1987-12-05'),
('Patricia Ferreira', '45678901234', 13, '81966554433', 'patricia.ferreira@email.com', '1991-04-20'),
('Gabriel Almeida', '56789012345', 14, '62955443322', 'gabriel.almeida@email.com', '1994-06-12'),
('Camila Rodrigues', '67890123456', 15, '61944332211', 'camila.rodrigues@email.com', '1989-02-28')

--------------------------------------------------------------------------------
-- Vendas
--------------------------------------------------------------------------------

INSERT INTO venda
  (id_funcionario, id_cliente, id_moto, metodo_pagamento, valor_total_venda, data_venda, quantidade_vendida)
VALUES
(1, 1, 1, 'Cartão de Crédito', 15000.00, '2023-01-20', 1),
(2, 2, 3, 'Financiamento', 25000.00, '2023-02-15', 1),
(4, 3, 2, 'PIX', 18000.00, '2023-03-10', 3),
(1, 4, 4, 'Cartão de Débito', 22000.00, '2023-04-05', 1),
(2, 5, 5, 'Dinheiro', 20000.00, '2023-05-12', 1),
(4, 6, 6, 'Cartão de Crédito', 17000.00, '2023-06-20', 2),
(1, 7, 7, 'PIX', 19000.00, '2023-07-15', 1),
(2, 8, 8, 'Financiamento', 23000.00, '2023-08-10', 1),
(4, 9, 9, 'Cartão de Débito', 21000.00, '2023-09-05', 1),
(1, 10, 10, 'Dinheiro', 16000.00, '2023-10-01', 1)
