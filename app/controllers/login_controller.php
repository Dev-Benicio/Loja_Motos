<?php

namespace App\Controllers;

use App\Models\login;
use App\Database\gerente_conexao;

class login_controller extends controller
{
  /**
   * Chama a view que permite o usuário logar.
   */
  public function index()
  {
    $this->call_view("login");
  }

    public function valida_login() {
        $user = $_POST["user"];
        $password = $_POST["password"];
        
        $is_login_valido = login::autenticar($user, $password);
        gerente_conexao::fechar_conexao();
        
        $is_login_valido ? header("Location: /dashboard") : header("Location: /");
    }
    
}
