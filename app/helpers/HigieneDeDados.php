<?php

# Classe com métodos para higienizar dados, como verficar se o dado é nulo, passar para lowercase, etc.
namespace App\Helpers;

class HigieneDeDados
{
  public static function is_null(string $data): bool
  {
    return is_null($data) && empty($data);
  }
}
