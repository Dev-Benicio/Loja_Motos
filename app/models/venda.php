<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;
use Exception;

class venda implements crud
{
  private static mysqli $conexao = gerente_conexao::conectar();

  private const COLUNAS = [
    'id_venda',
    'forma_pagamento',
    'valor',
    'data',
    'id_funcionario',
    'id_cliente'
  ];

  public static function create(array $venda): bool
  {
    try {
      if (!self::validarColunas($venda)) {
        return false;
      }
      self::$conexao->begin_transaction();
      $colunas = array_keys($venda);
      $interrogacoes = rtrim(str_repeat('?, ', count($colunas)), ', ');

      $sql = "INSERT INTO venda (" . implode(',', $colunas) . ") VALUES ({$interrogacoes})";
      $stmt = self::$conexao->prepare($sql);
      if (!$stmt) {
        return false;
      }
      $stmt->bind_param('sdsiii', ...array_values($venda));

      $sucesso = $stmt->execute();
      if ($sucesso) {
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
    $sql = $id
      ? "SELECT * FROM venda WHERE id_funcionario = ?"
      : "SELECT * FROM venda";

    $stmt = self::$conexao->prepare($sql);
    if ($id) {
      $stmt->bind_param("i", $id);
    }
    $stmt->execute();
    return $stmt->get_result();
  }


  public static function update(int $id, array $venda): bool
  {
    try {
      if (!self::validarColunas($venda)) {
        return false;
      }
      self::$conexao->begin_transaction();
      $colunas = array_keys($venda);
      $set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

      $sql = "UPDATE venda SET {$set} WHERE id_venda = ?";
      $stmt = self::$conexao->prepare($sql);
      if (!$stmt) {
        return false;
      }
      $types_bind = gerente_conexao::gerar_types_bind_params(
        ...array_values($venda),
        $id
      );

      $valores = [...array_values($venda), $id];
      $stmt->bind_param($types_bind, ...$valores);
      $sucesso = $stmt->execute();
      if ($sucesso) {
        self::$conexao->commit();
        return true;
      }
      self::$conexao->rollback();
      return true;
    } catch (Exception $e) {
      self::$conexao->rollback();
      return false;
    }
  }


  public static function delete(int $id): bool
  {
    try {
      self::$conexao->begin_transaction();
      $sql = "DELETE FROM venda WHERE id_venda = ?";
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


  public static function validate(array $venda): bool
  {
    $sql = "SELECT 
					(SELECT COUNT(*) FROM cliente WHERE id_cliente = ?) as cliente_exists,
					(SELECT COUNT(*) FROM funcionario WHERE id_funcionario = ?) as func_exists,
					(SELECT COUNT(*) FROM moto WHERE id_moto = ? AND quantidade_moto > 0) as moto_exists";

    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param(
      "iii",
      $venda['id_cliente'],
      $venda['id_funcionario'],
      $venda['id_moto']
    );
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    return $result['cliente_exists'] > 0
      && $result['func_exists'] > 0
      && $result['moto_exists'] > 0;
  }
  private static function validarColunas(array $dados): bool
  {
    return count(array_diff(array_keys($dados), self::COLUNAS)) === 0;
  }
}
