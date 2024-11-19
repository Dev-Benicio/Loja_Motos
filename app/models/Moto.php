<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;

class Moto implements crud
{
	private static mysqli $conexao = gerente_conexao::conectar();
	
	public static function create(array $moto): bool
		{
			return false;
		}

		public static function read(int $id = null): mysqli_result
		{
			return;
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
			return false;
		}
}
