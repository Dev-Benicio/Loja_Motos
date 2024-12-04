<?php

namespace App\Database;

use App\Helpers\env;
use mysqli;

class gerente_conexao
{
  private static mysqli $conexao;
  private static const CONFIG_CONEXAO = [
    'hostname' => env::get('DB_HOST'),
    'username' => env::get('DB_USER'),
    'user_passwd' => env::get('DB_PASSWD'),
    'database' => env::get('DB_NAME'),
  ];

  /**
   * Fornece uma conexão com o banco de dados.
   * @param string $hostname
   * @param string $username
   * @param string $user_passwd
   * @param string $database
   * @return bool|mysqli
   */
  public static function conectar(): bool|mysqli
  {
    self::$conexao = mysqli_connect(
      hostname: self::CONFIG_CONEXAO['hostname'],
      username: self::CONFIG_CONEXAO['username'],
      password: self::CONFIG_CONEXAO['user_passwd'],
      database: self::CONFIG_CONEXAO['database'],
    );
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

  /**
   * Fecha a conexão com o banco de dados.
   * @return bool
   */
  public static function fechar_conexao(): bool
  {
    return self::$conexao->close();
  }
}
