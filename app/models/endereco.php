<?php

class endereco implements crud
{
  private static mysqli $conexao = gerente_conexao::conectar();
  public static function endereco(array $_POST){
    // Campos específicos de endereço
    $camposEndereco = [
        'unidade_federativa',
        'cidade', 
        'numero', 
        'rua'
    ];

    // Filtra e remove os campos de endereço
    return array_filter(
        array_intersect_key(
            $_POST, 
            array_flip($camposEndereco)
        ), 
        fn($valor) => $valor !== null
    );
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
}