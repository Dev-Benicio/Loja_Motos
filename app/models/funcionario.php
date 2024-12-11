<?php

namespace App\Models;

use App\Database\gerente_conexao;
use App\Helpers\higiene_dados;
use Exception;

class funcionario extends model implements crud
{
  private const COLUNAS = [
    'funcionario' => [
      'id_funcionario',
      'login',
      'senha',
      'nome',
      'cpf',
      'email',
      'telefone',
      'cargo',
      'data_admissao',
      'data_demissao',
      'salario',
      'status_funcionario',
      'foto_perfil',
      'id_endereco'
    ],
    'endereco' => [
      'id_endereco',
      'unidade_federativa',
      'cidade',
      'numero',
      'rua'
    ]
  ];

  /**
   * Cria um novo registro de funcionário no banco de dados.
   */
  public static function create(array $funcionario): bool
  {
    parent::init_conexao();
    try {
      parent::$conexao->begin_transaction();

      // Remove valores nulos e limpa os dados
      $funcionario = array_filter($funcionario, fn($valor) => $valor !== null);
      $colunas = array_keys($funcionario);
      $valores = array_values($funcionario);
      $interrogacoes = str_repeat('?, ', count($colunas) - 1) . '?';
      $sql = "INSERT INTO funcionario (" . implode(',', $colunas) . ") 
                VALUES ({$interrogacoes})";

      // Gera tipos dinâmicos baseado nos valores
      $types = '';
      foreach ($valores as $valor) {
        if (is_int($valor)) $types .= 'i';
        elseif (is_float($valor) || is_double($valor)) $types .= 'd';
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

  /**
   * Lê registros de funcionários do banco de dados.
   */
  public static function read(null|int $id = null): array
  {
    parent::init_conexao();
    $colunas = array_merge(
      array_map(fn($col) => "f.{$col}", self::COLUNAS['funcionario']),
      array_map(fn($col) => "e.{$col}", self::COLUNAS['endereco'])
    );

    $select = implode(', ', array_filter($colunas));
    $sql = "
      SELECT {$select}
      FROM funcionario f
      LEFT JOIN endereco e ON f.id_endereco = e.id_endereco
      WHERE " . implode(
      ' IS NOT NULL AND ',
      array_map(fn($col) => "$col IS NOT NULL", $colunas)
    );

    $sql .= $id ? " AND f.id_funcionario = ? AND f.status_funcionario IN ('ativo', 'inativo')"
      : " AND f.status_funcionario IN ('ativo', 'inativo')";
    $stmt = parent::$conexao->prepare($sql);

    if ($id) {
      $stmt->bind_param("i", $id);
    }
    $stmt->execute();

    $resultado = $stmt->get_result();
    while ($row = $resultado->fetch_assoc()) {
      $funcionarios[] = $row;
    }
    return $funcionarios;
  }

  /* 
   * Atualiza um registro de funcionário no banco de dados.
   */
  public static function update(int $id, array $dados): bool
  {
    parent::init_conexao();

    try {
      parent::$conexao->begin_transaction();

      // Remove valores nulos
      $dados = array_filter($dados, fn($valor) => $valor !== null);
      $colunas = array_keys($dados);
      $set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));
      $sql = "UPDATE funcionario SET {$set} WHERE id_funcionario = ?";

      // Preparamos os valores na ordem correta
      $valores = array_values($dados);
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

  /* 
   * Exclui um registro de funcionário do banco de dados.
  */
  public static function delete(int $id): bool
  {
    parent::init_conexao();
    try {
      parent::$conexao->begin_transaction();
      $sql = "UPDATE funcionario SET status_funcionario = 'deletado' WHERE id_funcionario = ?";
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
