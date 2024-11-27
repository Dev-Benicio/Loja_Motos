<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Database\gerente_conexao;

class venda_controller extends controller
{
  /**
   * Chama a view que lista todas as vendas. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index(): void {
    $resultado = venda::read();
    $vendas = $resultado->fetch_all(MYSQLI_ASSOC); // Pegar todas as vendas, não só uma
    gerente_conexao::fechar_conexao();
    $this->call_view('lista_vendas', ['vendas' => $vendas]);
  }


  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_vendas');
  }

  public function call_edicao_view(): void
  {
    $this->call_view('edicao_vendas');
  }

  public function cadastrar() {
    // Valida se o cliente, funcionário e moto existem pelo ID, verifica se qtd_moto > 0
    // Se existirem, cria uma venda
    if (venda::validate($_POST)) {
        venda::create($_POST) ? moto::estoque($_POST['id_moto']) : false;
    }

    gerente_conexao::fechar_conexao();
  }

  public function editar($id) {
    venda::update($id, $_POST);
    // se existir redireciona para a pagina de vendas

    // se não existir, redireciona para a pagina de erro
    gerente_conexao::fechar_conexao();
  }

  public function exluir($id) {
    venda::delete($id);
    
    gerente_conexao::fechar_conexao();
  }
}
