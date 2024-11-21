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
    $funcionario = endereco::endereco($_POST);
    if ($id_endereco > 0) {
      funcionario::create($funcionario);
    } // se não for retorna erro na URl e volta para a página de cadastro
  }

  public function read ($id) {
      // chama read de endereco
      // chama read de funcionario + endereco
  }

  public function editar($id) {
    funcionario::update($id, $_POST);
  }

  public function delete($id) {

  }
}
