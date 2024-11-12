<?php

namespace App\Database;

use mysqli, mysqli_result;

class banco_de_dados
{
  private static mysqli $conexao;

  # Conecta ao banco de dados
  public static function conectar(
    string $hostName = "localhost",
    string $userName = "root",
    string $userPasswd = "",
    string $databaseName = "thunder_gears",
  ): bool|mysqli {
    self::$conexao = mysqli_connect(
      hostname: $hostName,
      username: $userName,
      password: $userPasswd,
      database: $databaseName
    );
    return self::$conexao;
  }

  public function query(string $query) {
    return self::$conexao->query($query);
  }

  # Fecha a conexão com o banco de dados
  public static function fechar_conexao(): bool
  {
    return mysqli_close(self::$conexao);
  }

  # Prepara a consulta para ser executada
  private static function preparar_consulta(string $query = ""): bool
  {
    /* $stmt = $this->conexao->prepare($query);
    $stmt->bind_param("ss", $username, $password); */
  }

  # Retorna uma string com as condições da consulta
  private static function tratar_condicoes(array $conditions): string
  {
    if (count($conditions) > 0) {
      $conditionsOfColumns = array_map(
        callback: fn($key): string => "{$key} = '{$conditions[$key]}'",
        array: array_keys($conditions)
      );

      $conditionsOfColumns = implode(" AND ", $conditionsOfColumns);
    }
    return $conditionsOfColumns ?? "";
  }

  # Cria uma nova linha na tabela
  public static function cadastrar(
    string $tableName,
    array $columns,
    array $values
  ): bool {
    $columns = implode(", ", $columns);
    $values = implode("', '", $values);

    $insertQuery = "
      INSERT INTO `{$tableName}`
        ({$columns})
      VALUES
        ('{$values}')
    ";

    return self::$conexao->query($insertQuery);
  }

  # Atualiza uma linha/s na tabela
  public static function atualizar(): bool {}

  # Seleciona uma linha/s da tabela
  public static function selecionar(
    string $tableName,
    array|string $columns = "*",
    array $conditions = []
  ): bool|mysqli_result {
    if (is_array($columns))
      $columns = implode(", ", $columns);

    $conditions = self::tratar_condicoes($conditions);

    $selectQuery = "
      SELECT {$columns}
      FROM `{$tableName}`
      " . ($conditions ? "WHERE {$conditions}" : "");

    return self::$conexao->query($selectQuery) ?? [];
  }

  # Deleta uma linha/s da tabela
  public static function deletar(): bool {}
}
