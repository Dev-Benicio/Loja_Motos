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
 $metodo_pagamento = $_POST["metodo_pagamento"];
  $valor_total_venda = $_POST["valor_total_venda"];
  $data_venda = $_POST["data_venda"];
  }

  public function listar(int $id = null) {}

  public function editar($id) {}

  public function exluir($id) {}
}
