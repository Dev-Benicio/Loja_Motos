<?php

namespace App\Helpers;

// Classe com métodos para manipulação de sessão
class Sessao
{
  /*
  * Inicia a sessão
  */
  public static function iniciar_sessao(): void
  {
    session_regenerate_id();
    session_start();
  }

  /*
  * Destrói a sessão
  */
  public static function destruir_sessao(): void
  {
    session_unset();
    $_SESSION = [];
    session_destroy();
  }

  /*
  * Define uma variável de sessão
  * @param string $key A chave da variável a ser definida
  * @param mixed $value O valor da variável a ser definida
  */
  public static function set(string $key, mixed $value): void
  {
    $_SESSION[$key] = $value;
  }

  /*
  * Obtém o valor de uma variável de sessão
  * @param string $key A chave da variável a ser obtida
  * @return mixed O valor da variável
  */
  public static function get(string $key): mixed
  {
    return $_SESSION[$key];
  }
}
