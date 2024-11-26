<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;

class Moto implements crud
{
	private static mysqli $conexao = gerente_conexao::conectar();

	public static function create(array $moto): bool
	{
			$colunas = array_keys($moto);
			$interrogacoes = str_repeat('?, ', count($colunas));

			$sql = "
					INSERT INTO moto 
						(" . implode(',', $colunas) . ")
					VALUES ({$interrogacoes})
			";

			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param(
				'sssdiisis', // Define o tipo de dados de cada parâmetro
				...array_values($moto)
			);
	}

		public static function read(int $id = null): mysqli_result
		{
			if ($id) {
				$sql = "SELECT * FROM moto WHERE id = ?";
				$stmt = self::$conexao->prepare($sql);
				$stmt->bind_param("i", $id);
				$stmt->execute();
				return $stmt->get_result();
			}
			return self::$conexao->query("SELECT * FROM moto");
		}

		public static function update(int $id, array $moto): bool
		{
				$colunas = array_keys($moto);
				$set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

				$sql = "UPDATE moto SET {$set} WHERE id = {$id}";
				$types_bind = gerente_conexao::gerar_types_bind_params(
					...array_values($moto)
				);
				
				$stmt = self::$conexao->prepare($sql);
				$stmt->bind_param(
					$types_bind,
					...array_values($moto)
				);

				return $stmt->execute();
		}

		public  static function delete(int $id): bool
		{
			$sql = "DELETE FROM moto WHERE id = ?";
			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			return $stmt->execute();
		}
		
		public static function estoque(int $id): bool
		{
			$stmt = self::$conexao->prepare("UPDATE moto SET quantidade_estoque = quantidade_estoque - 1 WHERE id_moto = {$venda['id_moto']}");
			$stmt->execute();
		}
}
