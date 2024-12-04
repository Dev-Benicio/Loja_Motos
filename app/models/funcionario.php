<?php

namespace App\Models;

use App\Database\gerente_conexao;
use App\Helpers\higiene_de_dados;
use mysqli, mysqli_result;
use Exception;

class funcionario implements crud
{
  private static mysqli $conexao = gerente_conexao::conectar();

  private const COLUNAS = [
    'funcionario' => [
      'id_funcionario',
      'login_funcionario',
      'senha',
      'nome',
      'cpf',
      'email',
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
    try {
      self::$conexao->begin_transaction();
      // Obtém as colunas da tabela através das chaves do array associativo.
      $colunas = array_keys($funcionario);
      // Cria uma string com interrogacoes para cada coluna.
      $interrogacoes = str_repeat('?, ', count($colunas) - 1) . '?';

      $sql = "
        INSERT INTO funcionario
          (" . implode(',', $colunas) . ")
        VALUES ({$interrogacoes})
      ";

      $stmt = self::$conexao->prepare($sql);
      $stmt->bind_param(
        'ssssssssdssi', // Define o tipo de dados de cada parâmetro
        ...array_values($funcionario),
      );
      if (higiene_de_dados::is_null(...array_values($funcionario))) {
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

  /**
   * Lê registros de funcionários do banco de dados.
   */
  public static function read(int $id = null): mysqli_result
  {
    $colunas = array_merge(
      array_map(fn($col) => "f.{$col}", self::COLUNAS['funcionario']),
      array_map(fn($col) => "e.{$col}", self::COLUNAS['endereco'])
    );

    $select = implode(', ', array_filter($colunas));
    $sql = "SELECT {$select}
            FROM funcionario f
            LEFT JOIN endereco e ON f.id_endereco = e.id_endereco
            WHERE " . implode(' IS NOT NULL AND ', array_map(fn($col) => "$col IS NOT NULL", $colunas))
    ;
    $sql .= $id ? " AND f.id_funcionario = ? AND f.status_funcionario IN ('ativo', 'inativo')"
    : " AND f.status_funcionario IN ('ativo', 'inativo')";
    $stmt = self::$conexao->prepare($sql);

    if ($id) {
      $stmt->bind_param("i", $id);
    }
    $stmt->execute();
    return $stmt->get_result();
  }

  /* 
   * Atualiza um registro de funcionário no banco de dados.
   */
  public static function update(int $id, array $dados): bool
  {
    try {
      self::$conexao->begin_transaction();

      $colunas = array_keys($dados);
      $set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

      $sql = "UPDATE funcionario SET {$set} WHERE id_funcionario = ?";
      $dados['id_funcionario'] = $id;
      $types_bind = gerente_conexao::gerar_types_bind_params(
        ...array_values($dados)
      );
      $stmt = self::$conexao->prepare($sql);
      $stmt->bind_param(
        $types_bind,
        ...array_values($dados)
      );
      if (higiene_de_dados::is_null(...array_values($dados))) {
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

  /* 
   * Exclui um registro de funcionário do banco de dados.
  */
  public static function delete(int $id): bool
  {
    try {
      self::$conexao->begin_transaction();
      $sql = "UPDATE funcionario SET status_funcionario = 'deletado' WHERE id_funcionario = ?";
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
