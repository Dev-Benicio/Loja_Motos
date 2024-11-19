<?php

namespace App\Controllers;

use App\Controllers\controller;

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
    $marca = $_POST["marca"];
  $modelo = $_POST["modelo"];
  $combustivel = $_POST["combustivel"];
  $preco = $_POST["preco"];
  $ano = $_POST["ano"];
  $potencia_cavalos = $_POST["potencia_cavalos"];
  $consumo_km = $_POST ["consumo_km"];
  $estoque = $_POST ["estoque"];
  $foto_moto = $_POST ["foto_moto"];
  }

  public function listar(int $id = null) {}

  public function editar($id) {}

  public function exluir($id) {}
}
