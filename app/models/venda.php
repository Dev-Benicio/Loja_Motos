<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;

class venda implements crud
{
	private static mysqli $conexao = gerente_conexao::conectar();

	public static function create(array $venda): bool
	{
		$colunas = array_keys($venda);

		$interrogacoes = str_repeat('?, ', count($colunas));

		$sql = "
				INSERT INTO venda
					(" . implode(',', $colunas) . ")
				VALUES ({$interrogacoes})
		";

		$stmt = self::$conexao->prepare($sql);
		$stmt->bind_param(
			'sdsii', // Define o tipo de dados de cada parâmetro
			...array_values($venda),
		);

		return $stmt->execute();
	}

	public static function read(int $id = null): mysqli_result
	{
		if ($id) {
			$sql = "SELECT * FROM venda WHERE id = ?";
			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			return $stmt->get_result();
		} else {
				return self::$conexao->query("SELECT * FROM venda");
		}
	}

	public static function update(int $id, array $venda): bool
	{
			$colunas = array_keys($venda);
			$set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

			$sql = "UPDATE venda SET {$set} WHERE id = {$id}";
			$types_bind = gerente_conexao::gerar_types_bind_params(
				...array_values($venda)
			);
			
			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param(
				$types_bind,
				...array_values($venda)
			);

			return $stmt->execute();
	}

	public  static function delete(int $id): bool
	{
		$sql = "DELETE FROM venda WHERE id = ?";
		$stmt = self::$conexao->prepare($sql);
		$stmt->bind_param("i", $id);
		return $stmt->execute();
	}
}
