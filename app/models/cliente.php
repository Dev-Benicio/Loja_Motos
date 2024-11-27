<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;

class cliente implements crud
{
	private static mysqli $conexao = gerente_conexao::conectar();

	private const COLUNAS = [
			'cliente' => [
				'id_cliente',
				'nome',
				'cpf',
				'telefone',
				'email',
				'data_nascimento',
				'id_endereco',
			],
			'endereco' => [
				'id_endereco',
				'unidade_federativa',
				'cidade',
				'numero',
				'rua'
			],
	];

	public static function create(array $cliente): bool
	{
		$colunas = array_keys($cliente);
		// Obtém as colunas da tabela através das chaves do array associativo.
		$interrogacoes = str_repeat('?, ', count($colunas) -1) . '?';

		$sql = "
			INSERT INTO cliente
				(" . implode(',', $colunas) . ")
			VALUES ({$interrogacoes})
		";

		$stmt = self::$conexao->prepare($sql);
		$stmt->bind_param(
			'ssssss', // Define o tipo de dados de cada parâmetro
			...array_values($cliente),
		);

		return $stmt->execute();
	}

	public static function read(int $id = null): mysqli_result
	{
    // Monta array de colunas com aliases das tabelas
    $colunas = array_merge(
        array_map(fn($col) => "c.{$col}", self::COLUNAS['cliente']),
        array_map(fn($col) => "e.{$col}", self::COLUNAS['endereco'])
    );
    $select = implode(', ', array_filter($colunas));

    $sql = "SELECT {$select} 
            FROM cliente c
            LEFT JOIN endereco e ON c.id_endereco = e.id_endereco
    ";
    
    // Adiciona filtro de não nulos dinamicamente
    $sql .= " AND " . implode(' IS NOT NULL AND ', 
        array_map(fn($col) => "$col IS NOT NULL", $colunas)
    );

    // Adiciona WHERE por ID se fornecido
    if ($id !== null) {
        $sql .= " WHERE c.id_cliente = ?";
        $stmt = self::$conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    return self::$conexao->query($sql);
	}

	public static function update(int $id, array $cliente): bool
	{
			$colunas = array_keys($cliente);
			$set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

			$sql = "UPDATE cliente SET {$set} WHERE id_cliente = ?";
			$types_bind = gerente_conexao::gerar_types_bind_params(
				...array_values($cliente),
				$id
			);

			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param(
				$types_bind,
				...array_values($cliente),
				$id
			);

			return $stmt->execute();
	}

	public  static function delete(int $id): bool
	{
			$sql = "DELETE FROM cliente WHERE id_cliente = ?";
			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			return $stmt->execute();
	}
}