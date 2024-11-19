<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;

class funcionario implements crud
{
  private static mysqli $conexao = gerente_conexao::conectar();

  /**
   * Cria um novo registro de funcionário no banco de dados.
   */
  public static function create(array $funcionario): bool
  {
    // Obtém as colunas da tabela através das chaves do array associativo.
    $colunas = array_keys($funcionario);
    // Cria uma string com interrogacoes para cada coluna.
    $interrogacoes = str_repeat('?, ', count($colunas));

    $sql = "
      INSERT INTO funcionario
        (" . implode(',', $colunas) . ")
      VALUES ({$interrogacoes})
    ";

    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param(
      'sssssssdss', // Define o tipo de dados de cada parâmetro
      ...array_values($funcionario),
    );

    return $stmt->execute();
  }

  /**
   * Lê registros de funcionários do banco de dados.
   */
  public static function read(int $id = null): mysqli_result
  {
    if ($id) {
      $sql = "SELECT * FROM funcionario WHERE id = ?";
      $stmt = self::$conexao->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      return $stmt->get_result();
    }
    return self::$conexao->query("SELECT * FROM funcionario");
  }

  /* 
   * Atualiza um registro de funcionário no banco de dados.
   */
  public static function update(int $id, array $funcionario): bool
  {
    $colunas = array_keys($funcionario);
    $set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

    $sql = "UPDATE funcionario SET {$set} WHERE id = ?";
    $types_bind = gerente_conexao::gerar_types_bind_params(
      ...array_values($funcionario)
    );

    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param(
      $types_bind,
      ...array_values($funcionario)
    );

    return $stmt->execute();
  }

  /* 
   * Exclui um registro de funcionário do banco de dados.
   * @param int $id O ID do registro a ser excluído.
   * @return bool Retorna true se a exclusão for bem-sucedida, false caso contrário.
  */
  public static function delete(int $id): bool
  {
    $sql = "DELETE FROM funcionario WHERE id = ?";
    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }
}
