<?php

namespace App\Models;

use App\Helpers\higiene_dados;
use App\Database\gerente_conexao;
use mysqli_result;
use Exception;

class cliente extends model implements crud
{
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
		parent::init_conexao();
		try {
			parent::$conexao->begin_transaction();
			$colunas = array_keys($cliente);
			// Obtém as colunas da tabela através das chaves do array associativo.
			$interrogacoes = str_repeat('?, ', count($colunas) - 1) . '?';

			$sql = "
				INSERT INTO cliente
					(" . implode(',', $colunas) . ")
				VALUES ({$interrogacoes})
			";
			$types_bind = gerente_conexao::gerar_types_bind_params(array_values($cliente));
			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param(
				$types_bind,
				...array_values($cliente)
			);
			if (higiene_dados::is_null(...array_values($cliente))) {
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

	public static function read(null|int $id = null): mysqli_result
	{
		self::init_conexao();
		$colunas = array_merge(
			array_map(fn($col) => "c.{$col}", self::COLUNAS['cliente']),
			array_map(fn($col) => "e.{$col}", self::COLUNAS['endereco'])
		);

		$select = implode(', ', array_filter($colunas));
		$sql = "SELECT {$select}
            FROM cliente c
            LEFT JOIN endereco e ON c.id_endereco = e.id_endereco
            WHERE " . implode(
			' IS NOT NULL AND ',
			array_map(fn($col) => "$col IS NOT NULL", $colunas)
		);

		$sql .= $id ? " AND c.id_cliente = ? AND c.status_cliente = 'ativo'"
			: " AND c.status_cliente = 'ativo'";
		$stmt = parent::$conexao->prepare($sql);

		if ($id) {
			$stmt->bind_param("i", $id);
		}
		$stmt->execute();
		return $stmt->get_result();
	}

	public static function update(int $id, array $cliente): bool
	{
		parent::init_conexao();
		try {
			parent::$conexao->begin_transaction();
			$colunas = array_keys($cliente);
			$set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

			$sql = "UPDATE cliente SET {$set} WHERE id_cliente = ?";
			$types_bind = gerente_conexao::gerar_types_bind_params(
				array_values($cliente),
				$id
			);

			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param(
				$types_bind,
				array_values($cliente),
				$id
			);
			if (higiene_dados::is_null(...array_values($cliente))) {
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

	public  static function delete(int $id): bool
	{
		parent::init_conexao();
		try {
			parent::$conexao->begin_transaction();
			$sql = "UPDATE cliente SET status_cliente = 'deletado' WHERE id_cliente = ?";
			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			if (!$stmt) {
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
}
