<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\funcionario;
use App\Models\endereco;

class funcionario_controller extends controller
{
  /**
   * Chama a view que lista todos os funcionários. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index()
  {
    $resultado = funcionario::read();
    $funcionarios = $resultado->fetch_assoc();
    $this->call_view('lista_funcionarios', ['funcionarios' => $funcionarios]);
  }

  public function cadastrar()
  {
    $endereco = endereco::endereco($_POST);
    $id_endereco = endereco::create($endereco);
    if ($id_endereco > 0) {
      funcionario::create($_POST, $id_endereco);
    }
  }

  public function editar($id)
  {
    funcionario::update($id, $_POST);
  }
}
