<?php

namespace App\Controllers;

use App\Controllers\controller;

class venda extends controller
{
  public function index(): void
  {
    $this->call_view('lista_vendas');
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
    if (venda::create($_POST)) {
      // na entidade moto chama a função de estoque para remover 1 da unidade de qunatidade de moto no estoque
    }
  }

  public function listar(int $id = null) {}

  public function editar($id) {
    venda::update($id, $_POST);
  }

  public function exluir($id) {}
}
