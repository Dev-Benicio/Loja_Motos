<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Database\gerente_conexao;
use App\Models\moto;

class moto_controller extends controller
{
  /* 
   * Chama a view que lista todas as motos. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index(): void
  {
    $resultado = moto::read();
    $motos = $resultado->fetch_all(MYSQLI_ASSOC);
    $this->call_view('lista_motos', ['motos' => $motos]);
  }

  /**
   * Chama a view que permite cadastrar uma moto.
   */
  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_motos');
  }

  /**
   * Chama a view que permite editar os dados de uma moto.
   * @param int $id Identificador da moto a ser editada.
   */
  public function call_edicao_view(): void
  {
    $this->call_view('edicao_motos');
  }

  /**
   * Cadastra motos
   */
  public function cadastrar()
  {
    moto::create($_POST);
  }

  /**
   * Atualiza os dados de uma moto
   * @param int $id Identificador do moto a ser editado.
   */
  public function editar($id)
  {
    moto::update($id, $_POST);
  }

  /**
   * Exclui uma moto
   * @param int $id Identificador do moto a ser excluído.
   */
  public function exluir($id)
  {
    moto::delete($id);
  }

}