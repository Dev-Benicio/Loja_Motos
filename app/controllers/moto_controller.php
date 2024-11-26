<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Database\gerente_conexao;
use App\Models\moto;

class moto extends controller
{
  public function index(): void
  {
    $array = moto::read($id);
    gerente_conexao::fechar_conexao();
    $this->call_view('lista_motos', $array);
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
    moto::create($_POST);
    gerente_conexao::fechar_conexao();
  }

  public function editar($id) {
      moto::update($id, $_POST);

      gerente_conexao::fechar_conexao();
  }

  public function exluir($id) {
    moto::delete($id);
    gerente_conexao::fechar_conexao();
  }
}
