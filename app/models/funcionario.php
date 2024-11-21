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
    $interrogacoes = str_repeat('?, ', count($colunas) -1) . '?';

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
    return $stmt->execute();
  }

  /**
   * Lê registros de funcionários do banco de dados.
   */
  public static function read(int $id = null, array $dados): ?array
  {
    if ($id) {
        $sql = "SELECT f.foto_perfil, f.nome, f.cpf, f.telefone, f.email, f.cargo, f.data_admissao, f.salario, f.status_funcionario, e.cidade, e.id_endereco, e.numero, e.rua, e.unidade_federativa FROM funcionario f INNER JOIN endereco e ON f.id_endereco = e.id_endereco WHERE f.id_funcionario = ?";

        $stmt = self::$conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    } else {
        return self::$conexao->query("SELECT f.foto_perfil, f.nome, f.cpf, f.telefone, f.email, f.cargo, f.data_admissao, f.salario, f.status_funcionario, e.id_endereco, e.cidade, e.numero, e.rua, e.unidade_federativa FROM funcionario");
    }
  }

  /* 
   * Atualiza um registro de funcionário no banco de dados.
   */
  public static function update(int $id, array $dados): bool
  {
    $id_endereco = $dados['id_endereco'];
    $funcionario = endereco::update($id_endereco, $dados);

    $colunas = array_keys($funcionario);
    $set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

    $sql = "UPDATE funcionario SET {$set} WHERE id = {$id}";
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
  */
  public static function delete(int $id): bool
  {
    $sql = "DELETE FROM funcionario WHERE id ?";= 
    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }
}
