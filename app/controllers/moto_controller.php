<?php

namespace App\Controllers;

use App\Controllers\controller;

class moto extends controller
{
  public function index(): void
  {
    $this->call_view('lista_motos');
  }

  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_motos');
  }

  public function call_edicao_view(): void
  {
    $this->call_view('edicao_motos');
  }

  public function cadastrar() {}

  public function listar(int $id = null) {}

  public function editar($id) {}

  public function exluir($id) {}
}
