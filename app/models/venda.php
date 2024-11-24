<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;

class Vendas implements crud
{
	private const CoLUNAS = [
		venda => 'ID_venda',
		'forma_pagamento',
		'valor',
		'data',
		'ID_funcionario',
		'ID_cliente'
	];
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
			'sdsiii', // Define o tipo de dados de cada parâmetro
			...array_values($venda),
		);
		// manipula quantidade de motos no estoque e motos vendidas
		if($stmt->execute()){
			// soma +1 na quantidade_vendida, -1 na quantidade_estoque
			$stmt = self::$conexao->prepare("UPDATE venda SET quantidade_moto_vendida = quantidade_moto_vendida + 1 WHERE id_cliente = $venda['id_cliente']");
			$stmt->execute();
			return true;
		}
		return false;
	} 

	public static function read(int $id = null): mysqli_result
	{
		if ($id) {
			$sql = "SELECT * FROM venda WHERE id_funcionario = $id";
			$stmt = self::$conexao->prepare($sql);
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

	public static function validate(array $venda): bool
	{
		$stmt = self::$conexao->prepare("SELECT * FROM cliente WHERE id_cliente = $venda['id_cliente']");
		$stmt->execute();
		$cliente = $stmt->get_result();
		if ($cliente->num_rows == 0) {
			return false;
		}

		$stmt = self::$conexao->prepare("SELECT * FROM funcionario WHERE id_funcionario = $venda['id_funcionario']");
		$stmt->execute();
		$funcionario = $stmt->get_result();

		if ($funcionario->num_rows == 0) {
			return false;
		}

		// verificar se existe unidades de moto na entidade moto existem
		$stmt = self::$conexao->prepare("SELECT * FROM moto WHERE id_moto = $venda['id_moto'] AND quantidade_moto > 0");
		$stmt->execute();
		$moto = $stmt->get_result();
		if ($moto->num_rows == 0) {
			return false;
		}
		return true;
	}
}
