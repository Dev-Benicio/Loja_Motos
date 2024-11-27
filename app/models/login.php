<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli;

class login
{
  private static mysqli $conexao = gerente_conexao::conectar();
  
  public static function autenticar(string $user, string $password)
  {
    $query = "
      SELECT * FROM
      funcionario
      WHERE login = '$user' AND senha = '$password'
    ";

    $resultado = self::$conexao->query($query);
    return $resultado->num_rows == 1;
  }
}