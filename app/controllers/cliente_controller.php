<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\cliente;
use App\Models\endereco;
use App\Database\gerente_conexao;

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
    gerente_conexao::fechar_conexao();
  }

  public function lista(int $id = null) {
    cliente::read($id);
    
    gerente_conexao::fechar_conexao();
  }

  public function editar($id) {
    $cliente = cliente::update($_POST);
    cliente::update($id, $cliente);

    gerente_conexao::fechar_conexao();
  }

  public function exluir($id) {
    cliente::delete($id);

    gerente_conexao::fechar_conexao();
  }
}
