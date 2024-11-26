<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\cliente;
use App\Models\endereco;

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

  public function cadastrar() {
    $cliente = endereco::validarSalvarEndereco($_POST);
    if (!empty($cliente)) {
      cliente::create($cliente);
    }
  }

  public function lista(int $id = null) {
    cliente::read($id);
  }

  public function editar($id) {
    $cliente = cliente::update($_POST);
    cliente::update($id, $cliente);
  }

  public function exluir($id) {
    cliente::delete($id);
  }
}
