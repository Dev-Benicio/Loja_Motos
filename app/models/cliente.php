<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;

class cliente implements crud
{
	private static mysqli $conexao = gerente_conexao::conectar();

	public static function create(array $cliente): bool
	{
		$colunas = array_keys($cliente);
		// Obtém as colunas da tabela através das chaves do array associativo.
		$interrogacoes = str_repeat('?, ', count($colunas));

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
		if ($id) {
			$sql = "SELECT * FROM cliente WHERE id = ?";
			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			return $stmt->get_result();
		} else {
			return self::$conexao->query("SELECT * FROM cliente");
		}
	}

	public static function update(int $id, array $cliente): bool
	{
			$colunas = array_keys($cliente);
			$set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

			$sql = "UPDATE cliente SET {$set} WHERE id = {$id}";
			$types_bind = gerente_conexao::gerar_types_bind_params(
				...array_values($cliente)
			);

			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param(
				$types_bind,
				...array_values($cliente)
			);

			return $stmt->execute();
	}

	public  static function delete(int $id): bool
	{
			$sql = "DELETE FROM cliente WHERE id = ?";
			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			return $stmt->execute();
	}
}