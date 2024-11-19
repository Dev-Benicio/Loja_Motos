<?php

namespace App\Controllers;

use App\Models\funcionario;

class funcionario_controller extends controller
{
  public function index()
  {
    $this->call_view("funcionarios");
  }

  public function cadastrar()
  {
    funcionario::create($_POST);
  }

  public function editar($id) {
    funcionario::update($id, $_POST);
  }
}
