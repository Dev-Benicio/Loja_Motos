<?php

namespace App\Helpers;

class higiene_de_dados
{
  /**
  * Verifica se os dados são nulos ou vazios
  * @param string ...$data Os dados a serem verificados
  * @return bool Retorna true se os dados são nulos ou vazios, caso contrário, false
  */
  public static function is_null(string ...$data): bool
  {
    foreach ($data as $dado) {
      if (is_null($dado) && empty($dado)) {
        return true;
      }
    }
    return false;
  }
}
