<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli;

class login
{
  public static function autenticar(string $user, string $password)
  {
    $conexao = gerente_conexao::conectar();
    $query = "
      SELECT * FROM
      funcionario
      WHERE login = '$user' AND senha = '$password'
    ";

    $resultado = $conexao->query($query);

    gerente_conexao::fechar_conexao();
    return $resultado->num_rows == 1;
  }
}