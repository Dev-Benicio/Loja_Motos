<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\cliente;
use App\Models\endereco;
use App\Database\gerente_conexao;

class cliente_controller extends controller
{
  /** 
   * Chama a view que lista todos os clientes. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index(): void
  {
    $clientes = cliente::read();
    $clientes = $clientes->fetch_all(MYSQLI_ASSOC);
    gerente_conexao::fechar_conexao();
    $this->call_view('lista_clientes', ['clientes' => $clientes]);
  }

  /**
   * Chama a view que permite cadastrar um novo cliente.
   */
  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_clientes');
  }

  /**
   * Chama a view que permite editar os dados de um cliente.
   * @param int $id Identificador do cliente a ser editado.
   * @return void
   */
  public function call_edicao_view(int $id): void
  {
    $resultado = cliente::read($id);
    if ($resultado->num_rows === 0) {
      $this->call_view('error_404');
    }

    $cliente = $resultado->fetch_assoc();
    $this->call_view('edicao_clientes', ['cliente' => $cliente]);
  }

  public function cadastrar(): void
  {
    $cliente = endereco::validarSalvarEndereco($_POST);
    if (!empty($cliente)) {
      cliente::create($cliente);
    }
    gerente_conexao::fechar_conexao();
  }

  public function editar($id)
  {
    $cliente = endereco::update($_POST);
    cliente::update($id, $cliente);
    gerente_conexao::fechar_conexao();
  }

  public function exluir($id)
  {
    cliente::delete($id);
    gerente_conexao::fechar_conexao();
  }
}
