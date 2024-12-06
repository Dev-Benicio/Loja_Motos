<?php

namespace App\Controllers;

use App\Models\login;
use App\Helpers\sessao;

class login_controller extends controller
{
  /**
   * Chama a view que permite o usuário logar.
   */
  public function index(): void
  {
    $this->call_view("login");
  }

  /**
   * Verifica se as credenciais do usuário são válidas.
   * Se as credenciais forem válidas, define as credenciais do usuário na variável de sessão e redireciona para a página de welcome.
   */
  public function validar_login(): void
  {
    $user = $_POST["user"];
    $password = $_POST["password"];
    
    $is_autenticado = login::autenticar($user, $password);
    $nova_url = "?error=true";

    if ($is_autenticado) {
      sessao::set_sessao("usuario", login::get_credenciais());
      $nova_url = "welcome";
    }
    header("Location: {$nova_url}");
    exit;
  }

  /**
   * Limpa as credenciais do usuário que estão na variável de sessão "usuario".
   */
  public function logout(): void
  {
    sessao::limpar_sessao();
    header("Location: /");
    exit;
  }
  
}