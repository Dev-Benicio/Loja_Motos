<?php

namespace App\Helpers;

class permissao
{
  /**
   * Verifica se o usuário possui permissão para acessar a página.
   * @param string $cargo Cargo do usuário.
   * @return bool Retorna true se o usuário possui permissão para acessar a página, false caso contrário.
   */
  public static function possui_permisao(string $cargo): bool
  {
    return false;
  }

}