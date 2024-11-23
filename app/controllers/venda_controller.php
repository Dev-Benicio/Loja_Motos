<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\venda;

class venda_controller extends controller
{
  /**
   * Chama a view que lista todas as vendas. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index(): void
  {
    $resultado = venda::read();
    $vendas = $resultado->fetch_assoc();
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

  public function cadastrar() {}

  public function editar($id)
  {
    venda::update($id, $_POST);
  }
}
