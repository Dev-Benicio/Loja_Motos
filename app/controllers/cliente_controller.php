<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\cliente;

class cliente_controller extends controller
{
  /** 
   * Chama a view que lista todos os clientes. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index(): void
  {
    $clientes = cliente::read();
    $clientes = $clientes->fetch_assoc();
    $this->call_view('lista_clientes', ['clientes' => $clientes]);
  }

  /**
   * Chama a view que permite cadastrar um novo cliente.
   */
  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_clientes');
  }

  /* 
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

  public function cadastrar()
  {
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $endereco = $_POST["endereco"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["data_nascimento"];
  }

  public function editar($id)
  {
    cliente::update($id, $_POST);
  }

  public function exluir($id) {}
}
