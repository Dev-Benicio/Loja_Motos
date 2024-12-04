<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli;

class login
{
  private static mysqli $conexao = gerente_conexao::conectar();

  public static function autenticar(string $user, string $password): bool
  {
    $sql = "SELECT * FROM funcionario WHERE login = ? AND senha = ?";

    $stmt = self::$conexao->prepare($sql);
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();

    $resultado = $stmt->get_result();
    return $resultado->num_rows === 1;
  }
}
