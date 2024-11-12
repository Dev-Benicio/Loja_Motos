<?php

  namespace App\Models;

  use App\Database\banco_de_dados;

  class login {
      public function autenticar(string $user, string $password) {
        $conexao = banco_de_dados::conectar();
        $query = "SELECT * FROM funcionario WHERE login = '$user' AND senha = '$password'";
        $result = $conexao->query($query);

        banco_de_dados::fechar_conexao();
        
        return $result->num_rows == 1;
      }
  }