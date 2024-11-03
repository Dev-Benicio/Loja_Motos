<?php

namespace App\Helpers;

class higiene_de_dados
{
  public static function is_null(string $data): bool
  {
    return is_null($data) && empty($data);
  }
}
