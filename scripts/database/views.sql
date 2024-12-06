-- -----------------------------------------------------
-- Views Modelo mais vendido
-- -----------------------------------------------------
CREATE VIEW motos_mais_vendidos AS
SELECT
    m.modelo, SUM(v.quantidade_vendida) AS vendas
FROM
    venda AS v
LEFT JOIN
    moto AS m ON v.id_moto = m.id_moto
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
    f.foto_perfil as vendedor_foto_perfil,
    COUNT(v.id_venda) AS total_vendas,
    SUM(v.valor_total_venda) AS total_valor_vendas
FROM 
    thunder_gears.venda v
JOIN 
    thunder_gears.funcionario f ON v.id_funcionario = f.id_funcionario    
WHERE
	f.status_funcionario = 'ativo' AND f.cargo = 'vendedor'
GROUP BY 
    vendedor_id, vendedor_nome, vendedor_foto_perfil
ORDER BY 
    total_vendas DESC;

-- -----------------------------------------------------
-- Views Quantidade em estoque
-- -----------------------------------------------------
CREATE VIEW quantidade_em_estoque AS
SELECT
    SUM(m.quantidade_estoque) as quantidade_total_motos
FROM
    thunder_gears.moto AS m
WHERE
    m.status_moto = 'disponivel'
ORDER BY
    m.modelo;