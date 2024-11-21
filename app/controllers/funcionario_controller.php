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
    $endereco = endereco::endereco($_POST);
    $id_endereco = endereco::create($endereco);
    if ($id_endereco > 0) {
      funcionario::create($_POST, $id_endereco);
    }
  }

  public function editar($id) {
    funcionario::update($id, $_POST);
  }
}
