<?php

namespace App\Models;

use App\Database\gerente_conexao;
use App\Helpers\higiene_dados;
use mysqli, mysqli_result;
use Exception;

class moto implements crud
{
	private static mysqli $conexao = gerente_conexao::conectar();

	public static function create(array $moto): bool
	{
		try {
			self::$conexao->begin_transaction();
			$colunas = array_keys($moto);
			$interrogacoes = str_repeat('?, ', count($colunas) - 1) . '?';

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

			if (higiene_dados::is_null(...array_values($moto))) {
				return false;
			}

			if ($stmt->execute()) {
				self::$conexao->commit();
				return true;
			}

			self::$conexao->rollback();
			return false;
		} catch (Exception $e) {
			self::$conexao->rollback();
			return false;
		}
	}

	public static function read(int $id = null): mysqli_result
	{
		$sql = $id ? "SELECT * FROM moto WHERE id_moto = ? AND status_moto IN ('disponivel', 'esgotado')" : "SELECT * FROM moto WHERE status_moto IN ('disponivel', 'esgotado')";
		$stmt = self::$conexao->prepare($sql);
		if ($id) {
			$stmt->bind_param("i", $id);
		}
		$stmt->execute();
		return $stmt->get_result();
	}


	public static function update(int $id, array $moto): bool
	{
		try {
			$colunas = array_keys($moto);
			$set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

			$sql = "UPDATE moto SET {$set} WHERE id_moto = ?";
			$types_bind = gerente_conexao::gerar_types_bind_params(
				...array_values($moto),
				$id
			);

			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param(
				$types_bind,
				...array_values($moto),
				$id
			);
			if (higiene_dados::is_null(...array_values($moto))) {
				return false;
			}
			return $stmt->execute();
		} catch (Exception $e) {
			return false;
		}
	}

	public  static function delete(int $id): bool
	{
		try {
			$sql = "UPDATE moto SET status_moto = 'deletado' WHERE id_moto = ?";
			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			return $stmt->execute();
		} catch (Exception $e) {
			return false;
		}
	}

	public static function atualizarEstoqueMoto(int $id, bool $cond): bool
	{
		try {
			self::$conexao->begin_transaction();
			if (!$cond) {
				// Quando cancela venda - aumenta estoque
				$sql = "UPDATE moto 
                SET quantidade_estoque = quantidade_estoque + 1,
                    status_moto = 'disponivel' 
              	WHERE id_moto = ?";
			} else {
				// Quando realiza venda - diminui estoque
				$sql = "UPDATE moto 
                   SET quantidade_estoque = quantidade_estoque - 1,
                       status_moto = CASE 
                           WHEN (quantidade_estoque - 1) = 0 THEN 'indisponivel'
                           ELSE status_moto 
                       END
                   WHERE id_moto = ?";
			}
			$stmt = self::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);

			if ($stmt->execute()) {
				self::$conexao->commit();
				return true;
			}

			self::$conexao->rollback();
			return false;
		} catch (Exception $e) {
			self::$conexao->rollback();
			return false;
		}
	}
}
