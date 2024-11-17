<?php

namespace App\Controllers;

use App\Controllers\controller;

class cliente extends controller
{
  public function index(): void
  {
    $this->call_view('lista_clientes');
  }

  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_clientes');
  }

  public function call_edicao_view(): void
  {
    $this->call_view('edicao_clientes');
  }

  public function cadastrar() {}

  public function listar(int $id = null) {}

  public function editar($id) {}

  public function exluir($id) {}
}
