<?php

namespace App\Models;

use App\Database\gerente_conexao;
use App\Helpers\higiene_de_dados;
use mysqli, mysqli_result;

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
    if (higiene_de_dados::is_null(...array_values($funcionario))) {
      return false;
    }
    return $stmt->execute();
  }

  /**
   * Lê registros de funcionários do banco de dados.
   */
  public static function read(int $id = null): mysqli_result
  {
    // Monta array de colunas com aliases das tabelas
    $colunas = array_merge(
        array_map(fn($col) => "f.{$col}", self::COLUNAS['funcionario']),
        array_map(fn($col) => "e.{$col}", self::COLUNAS['endereco'])
    );
    $select = implode(', ', array_filter($colunas));
    $sql = "SELECT {$select} 
            FROM funcionario f 
            LEFT JOIN endereco e ON f.id_endereco = e.id_endereco
    ";
    
    // Adiciona filtro de não nulos dinamicamente
    $sql .= " AND " . implode(' IS NOT NULL AND ', 
        array_map(fn($col) => "$col IS NOT NULL", $colunas)
    );

    // Adiciona WHERE por ID se fornecido
    if ($id !== null) {
        $sql .= " WHERE f.id_funcionario = ?";
        $stmt = self::$conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    return self::$conexao->query($sql);
  }

  /* 
   * Atualiza um registro de funcionário no banco de dados.
   */
  public static function update(int $id, array $dados): bool
  {
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
    return $stmt->execute();
  }

  /* 
   * Exclui um registro de funcionário do banco de dados.
  */
  public static function delete(int $id): bool
  {
    $sql = "DELETE FROM funcionario WHERE id_funcionario = ?";
    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }
}
