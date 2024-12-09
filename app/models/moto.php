<?php

namespace App\Models;

use App\Database\gerente_conexao;
use App\Helpers\higiene_dados;
use mysqli_result;
use Exception;

class moto extends model implements crud
{
	public static function create(array $moto): bool
	{
    parent::init_conexao();
		try {
			parent::$conexao->begin_transaction();
			$colunas = array_keys($moto);
			$interrogacoes = str_repeat('?, ', count($colunas) - 1) . '?';

			$sql = "
						INSERT INTO moto 
							(" . implode(',', $colunas) . ")
						VALUES ({$interrogacoes})
				";

			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param(
				'sssdiisis', // Define o tipo de dados de cada parâmetro
				...array_values($moto)
			);

			if (higiene_dados::is_null(...array_values($moto))) {
				return false;
			}

			if ($stmt->execute()) {
				parent::$conexao->commit();
				return true;
			}

			parent::$conexao->rollback();
			return false;
		} catch (Exception $e) {
			parent::$conexao->rollback();
			return false;
		}
	}

	public static function read(null|int $id = null): array
	{
    parent::init_conexao();
		$sql = "
			SELECT * FROM moto
			". $id ? " WHERE id_moto = ? " : "" ."
			AND status_moto IN ('disponivel', 'esgotado')
		";
		$stmt = parent::$conexao->prepare($sql);
		if ($id) {
			$stmt->bind_param("i", $id);
		}
		$stmt->execute();

		$resultado = $stmt->get_result();
		while ($moto = $resultado->fetch_assoc()) {
			$motos[] = $moto;
		}
		return $motos;
	}


	public static function update(int $id, array $moto): bool
	{
    parent::init_conexao();
		try {
			$colunas = array_keys($moto);
			$set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

			$sql = "UPDATE moto SET {$set} WHERE id_moto = ?";
			$types_bind = gerente_conexao::gerar_types_bind_params(
				array_values($moto),
				$id
			);

			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param(
				$types_bind,
				array_values($moto),
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
    parent::init_conexao();
		try {
			$sql = "UPDATE moto SET status_moto = 'deletado' WHERE id_moto = ?";
			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			return $stmt->execute();
		} catch (Exception $e) {
			return false;
		}
	}

	public static function atualizarEstoqueMoto(int $id, bool $cond): bool
	{
    parent::init_conexao();
		try {
			parent::$conexao->begin_transaction();
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
			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);

			if ($stmt->execute()) {
				parent::$conexao->commit();
				return true;
			}

			parent::$conexao->rollback();
			return false;
		} catch (Exception $e) {
			parent::$conexao->rollback();
			return false;
		}
	}

}