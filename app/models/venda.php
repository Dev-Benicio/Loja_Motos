<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli_result;
use Exception;

class venda extends model implements crud
{
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
    parent::init_conexao();
    try {
      if (!self::validarColunas($venda)) {
        return false;
      }
      parent::$conexao->begin_transaction();
      $colunas = array_keys($venda);
      $interrogacoes = rtrim(str_repeat('?, ', count($colunas)), ', ');

      $sql = "INSERT INTO venda (" . implode(',', $colunas) . ") VALUES ({$interrogacoes})";
      $stmt = parent::$conexao->prepare($sql);
      if (!$stmt) {
        return false;
      }
      $stmt->bind_param('sdsiii', ...array_values($venda));

      $sucesso = $stmt->execute();
      if ($sucesso) {
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
    $sql = $id
      ? "SELECT * FROM venda WHERE id_funcionario = ? AND status_venda = 'realizada'"
      :
      "SELECT * FROM venda WHERE status_venda = 'realizada'";

    $stmt = parent::$conexao->prepare($sql);
    if ($id) {
      $stmt->bind_param("i", $id);
    }
    $stmt->execute();
    
    $resultado = $stmt->get_result();
    while ($venda = $resultado->fetch_assoc()) {
      $vendas[] = $venda;
    }
    return $vendas;
  }

  public static function update(int $id, array $venda): bool
  {
    parent::init_conexao();
    try {
      if (!self::validarColunas($venda)) {
        return false;
      }
      parent::$conexao->begin_transaction();
      $colunas = array_keys($venda);
      $set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

      $sql = "UPDATE venda SET {$set} WHERE id_venda = ?";
      $stmt = parent::$conexao->prepare($sql);
      if (!$stmt) {
        return false;
      }
      $types_bind = gerente_conexao::gerar_types_bind_params(
        array_values($venda),
        $id
      );

      $valores = [...array_values($venda), $id];
      $stmt->bind_param($types_bind, ...$valores);
      $sucesso = $stmt->execute();
      if ($sucesso) {
        parent::$conexao->commit();
        return true;
      }
      parent::$conexao->rollback();
      return true;
    } catch (Exception $e) {
      parent::$conexao->rollback();
      return false;
    }
  }

  public static function delete(int $id): bool
  {
    parent::init_conexao();
    try {
      parent::$conexao->begin_transaction();
      $sql = "UPDATE venda SET status_venda = 'deletada' WHERE id_venda = ?";
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

  public static function validate(array $venda): bool
  {
    parent::init_conexao();
    $sql = "SELECT 
					(SELECT COUNT(*) FROM cliente WHERE id_cliente = ?) as cliente_exists,
					(SELECT COUNT(*) FROM funcionario WHERE id_funcionario = ?) as func_exists,
					(SELECT COUNT(*) FROM moto WHERE id_moto = ? AND quantidade_moto > 0) as moto_exists";

    $stmt = parent::$conexao->prepare($sql);
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