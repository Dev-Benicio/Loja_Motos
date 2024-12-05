<?php

namespace App\Database;

use App\Helpers\env;
use mysqli;

class gerente_conexao
{
  private static ?mysqli $conexao = null;

  /**
   * Retorna a conexão com o banco de dados.
   * @return mysqli
   */
  public static function get_conexao(): mysqli {
    if (self::$conexao === null) {
      self::$conexao = new mysqli(
        hostname: env::get_env('DB_HOST'),
        username: env::get_env('DB_USER'),
        password: env::get_env('DB_PASS'),
        database: env::get_env('DB_NAME'),
        port: env::get_env('DB_PORT')
      );
    }
    return self::$conexao;
  }

  /**
   * Gera uma string - informando os types para usar na função bind_params() - com os tipos de dados dos parâmetros.
   * @param mixed ...$values os vallores que serão passados para a função bind_params().
   * @return string uma string com os tipos de dados dos parâmetros.
   * Os tipos de dados são:
   *  'i' => int
   *  'd' => float
   *  's' => string
   */
  public static function gerar_types_bind_params(mixed ...$values): string
  {
    $types_array = array_map(
      fn($value) => match (gettype($value)) {
        'int' => 'i',
        'float' => 'd',
        'string' => 's',
        default => 's'
      },
      $values
    );

    $types_string = implode('', $types_array);
    return $types_string;
  }

}