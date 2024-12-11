<?php

namespace App\Models;

use App\Helpers\higiene_dados;
use App\Database\gerente_conexao;
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

			// Remove valores nulos
			$cliente = array_filter($cliente, fn($valor) => $valor !== null);
			$colunas = array_keys($cliente);
			$valores = array_values($cliente);
			$interrogacoes = str_repeat('?, ', count($colunas) - 1) . '?';
			$sql = "INSERT INTO cliente (" . implode(',', $colunas) . ") 
                VALUES ({$interrogacoes})";

			// Gera tipos corretos baseado nos valores
			$types = '';
			foreach ($valores as $valor) {
				if (is_int($valor)) $types .= 'i';
				elseif (is_float($valor)) $types .= 'd';
				else $types .= 's';
			}

			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param($types, ...$valores);

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
		self::init_conexao();
		$colunas = array_merge(
			array_map(fn($col) => "c.{$col}", self::COLUNAS['cliente']),
			array_map(fn($col) => "e.{$col}", self::COLUNAS['endereco'])
		);

		$select = implode(', ', array_filter($colunas));
		$sql = "
			SELECT {$select}
			FROM cliente c
			LEFT JOIN endereco e ON c.id_endereco = e.id_endereco
			WHERE ";

		$sql .= implode(
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

		$resultado = $stmt->get_result();
		while ($row = $resultado->fetch_assoc()) {
			$clientes[] = $row;
		}
		return $clientes;
	}

	public static function update(int $id, array $cliente): bool
	{
		parent::init_conexao();
		try {
			parent::$conexao->begin_transaction();

			// Remove valores nulos
			$cliente = array_filter($cliente, fn($valor) => $valor !== null);
			$colunas = array_keys($cliente);
			$set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));
			$sql = "UPDATE cliente SET {$set} WHERE id_cliente = ?";

			// Preparamos os valores na ordem correta
			$valores = array_values($cliente);
			$valores[] = $id;  // Adiciona o ID por último

			// Geramos os tipos baseados nos valores
			$types = '';
			foreach ($valores as $valor) {
				if (is_int($valor)) $types .= 'i';
				elseif (is_float($valor)) $types .= 'd';
				else $types .= 's';
			}

			$stmt = parent::$conexao->prepare($sql);
			$stmt->bind_param($types, ...$valores);

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
