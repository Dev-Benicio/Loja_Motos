<?php

namespace App\Controllers;

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
    funcionario::create($funcionario);
  }

  public function read ($id) {
      funcionario::read($id, $_POST);
  }

  public function editar($id) {
    funcionario::update($id, $_POST);
  }

  public function delete($id) {

  }
}
