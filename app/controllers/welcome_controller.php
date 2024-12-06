<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Helpers\sessao;

class welcome_controller extends controller
{
  /**
   * Chama a view de boas vindas
   */
  public function index()
  {
    switch (sessao::get_sessao('usuario')['cargo']) {
      case 'vendedor':
        $texto_boas_vindas = "Olá, Vamos começar mais um dia de vendas?";
        $texto_botao = "Começar a vender";
        $link_botao = "./vendas";
        $nome_usuario = sessao::get_sessao('usuario')['nome'];
        break;
      case 'estoquista':
        $texto_boas_vindas = "Olá, Deseja ver como anda o seu estoque?";
        $texto_botao = "Ver estoque";
        $link_botao = "./estoque";
        $nome_usuario = sessao::get_sessao('usuario')['nome'];
        break;
      case 'gerente':
        $texto_boas_vindas = "Gostaria de ver como anda os négocios?";
        $texto_botao = "Ver relatórios";
        $link_botao = "./dashboard";
        $nome_usuario = sessao::get_sessao('usuario')['nome'];
        break;
      default:
        $texto_boas_vindas = "Ué, quem é tu? Não achei teu cargo";
        $texto_botao = "Bora sair daqui, bora...";
        $link_botao = "./logout";
        $nome_usuario = sessao::get_sessao('usuario')['nome'];
    }
    return $this->call_view('welcome', [
      'texto_boas_vindas' => $texto_boas_vindas,
      'texto_botao' => $texto_botao,
      'link_botao' => $link_botao,
      'nome_usuario' => $nome_usuario,
    ]);
  }

}