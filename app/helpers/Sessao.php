<?php

namespace App\Helpers;

// Classe com métodos para manipulação de sessão
class sessao
{
  /**
   * Inicia uma nova sessão e exlui a antiga
   */
  public static function iniciar_sessao(): void
  {
    if (session_status() === PHP_SESSION_ACTIVE) {
      session_regenerate_id(true);
    }
    session_set_cookie_params(['httponly' => true]);
    session_start();
  }

  /**
   * Destrói a sessão
   */
  public static function limpar_sessao(): void
  {
    session_unset();
    $_SESSION = [];
    session_destroy();
  }

  /**
   * Define uma variável de sessão
   * @param string $key A chave da variável a ser definida
   * @param mixed $value O valor da variável a ser definida
   */
  public static function set_sessao(string $key, mixed $value): void
  {
    $_SESSION[$key] = $value;
  }

  /**
   * Obtém o valor de uma variável de sessão
   * @param string $key A chave da variável a ser obtida
   * @return mixed O valor da variável
   */
  public static function get_sessao(string $key): mixed
  {
    return $_SESSION[$key] ?? null;
  }
}
