<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\funcionario;
use App\Models\endereco;
use App\Database\gerente_conexao;

class funcionario_controller extends controller
{
  public function index()
  {
    $this->call_view("funcionarios");
  }

  public function cadastrar()
  {
    $funcionario = endereco::validarSalvarEndereco($_POST);
    if (!empty($funcionario)) {
      funcionario::create($funcionario);
    }
    gerente_conexao::fechar_conexao();
  }

  public function lista($id = null) {
    funcionario::read($id);

    gerente_conexao::fechar_conexao();
  }

  public function editar($id) {
    $funcionario = endereco::update($_POST);
    funcionario::update($id, $funcionario);

    gerente_conexao::fechar_conexao();
  }

  public function delete($id) {
    funcionario::delete($id);

    gerente_conexao::fechar_conexao();
  }
}
