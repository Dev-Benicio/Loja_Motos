<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Database\gerente_conexao;

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

  public function cadastrar() {

    gerente_conexao::fechar_conexao();
  }

  public function listar(int $id = null) {

    gerente_conexao::fechar_conexao();
  }

  public function editar($id) {
      moto::update($id, $_POST);

      gerente_conexao::fechar_conexao();
  }

  public function exluir($id) {

    gerente_conexao::fechar_conexao();
  }
}
