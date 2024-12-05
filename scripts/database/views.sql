-- -----------------------------------------------------
-- Views Modelo mais vendido
-- -----------------------------------------------------
CREATE VIEW motos_mais_vendidos AS
SELECT 
    m.modelo AS modelo,
    COUNT(v.id_venda) AS venda
FROM 
    venda v
LEFT JOIN 
    moto m ON v.id_moto = m.id_moto
GROUP BY 
    m.modelo
ORDER BY 
    venda DESC;
 
-- -----------------------------------------------------
-- Views Vendas por vendedor
-- ----------------------------------------------------- 
CREATE VIEW vendas_por_vendedor AS
SELECT 
    f.id_funcionario AS vendedor_id,
    f.nome AS vendedor_nome,
    COUNT(v.id_venda) AS total_vendas,
    SUM(v.valor_total_venda) AS total_valor_vendas
FROM 
    thunder_gears.venda v
JOIN 
    thunder_gears.funcionario f ON v.id_funcionario = f.id_funcionario    
WHERE
	f.status_funcionario = 'ativo'
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
        WHEN m.quantidade_estoque = 0 THEN `Esgotado`
        WHEN m.quantidade_estoque < 15 THEN `Estoque baixo`
        ELSE 'Estoque suficiente'
    END AS status_reposicao,
    '2024-12-10' AS previsao_chegada -- Essa é um data de exemplo
FROM 
    thunder_gears.moto m
WHERE 
    m.status_moto IN (`disponivel`, `esgotado`)
ORDER BY 
    m.quantidade_estoque ASC;
    
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
    END AS descricao_status
FROM 
    thunder_gears.funcionario f
ORDER BY 
    f.nome;
