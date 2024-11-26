<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\funcionario;
use App\Models\endereco;

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
  }

  public function lista($id = null) {
    funcionario::read($id);
  }

  public function editar($id) {
    $funcionario = endereco::update($_POST);
    funcionario::update($id, $funcionario);
  }

  public function delete($id) {
    funcionario::delete($id);
  }
}
