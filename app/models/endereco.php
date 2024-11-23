<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli;

class endereco
{
  private static mysqli $conexao = gerente_conexao::conectar();

  public static function validarSalvarEndereco(array $dados){
    // Campos específicos de endereço
    $camposEndereco = [
        'unidade_federativa',
        'cidade', 
        'numero', 
        'rua'
    ];

    // Filtra e remove os campos que nãos são de endereço
    $endereco = array_filter(
        array_intersect_key(
            $_POST, 
            array_flip($camposEndereco)
        ), 
        fn($valor) => $valor !== null
    );
    // adiciona endereço de funcionario
    $id_endereco = endereco::create($endereco);

    if ($id_endereco > 0) {
      // Remove os campos de endereço
      foreach ($camposEndereco as $campo) {
          unset($dados[$campo]);
      }
      // Adiciona o id_endereco aos dados
      $dados['id_endereco'] = $id_endereco;
      return $dados;
    }
  }
  /**
   * Cria um novo registro de endereço no banco de dados.
   */
  public static function create(array $endereco): int
  {
      $colunas = array_keys($endereco);
      // Cria uma string com interrogacoes para cada coluna.
      $interrogacoes = str_repeat('?, ', count($colunas));

      $sql = "
        INSERT INTO endereco
          (" . implode(',', $colunas) . ")
        VALUES ({$interrogacoes})
      ";

      $stmt = self::$conexao->prepare($sql);
      $stmt->bind_param(
        'ssss', // Define o tipo de dados de cada parâmetro
        ...array_values($endereco),
      );

      // Executa a inserção
      $resultado = $stmt->execute();

      // Verifica se a inserção foi bem-sucedida
      if ($resultado) {
          // Retorna o ID do último registro inserido
          return self::$conexao->insert_id;
      }

      // Retorna 0 ou lança uma exceção em caso de falha
      return 0;
  }

  public static function update(array $dados) {
    $camposEndereco = [
        'unidade_federativa',
        'cidade', 
        'numero', 
        'rua'
    ];

    $colunas = // do atributo de Endereço
      
    // atualiza dados de endereco
    $sql = "UPDATE endereco SET {$set} WHERE id_enderco = {$dados['id_endereco']}";
    $types_bind = gerente_conexao::gerar_types_bind_params(
      ...array_values($campoEndereco)
    );

    // executa a query de endereco
    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param(
      $types_bind,
      ...array_values($campoEndereco)
    );

    // remove dados de endereco do array $dados
    // unset($dados['id_endereco']); ...
    // ...

    // retorna variavel $dados, sem os dados de endereco
    return $stmt->execute();
  }

  public static function delete(int $id): bool {
    $sql = "DELETE FROM endereco WHERE id_enderco = ?";
    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }
}
