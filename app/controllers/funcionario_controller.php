<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\funcionario;
use App\Models\endereco;
use App\Database\gerente_conexao;

class funcionario_controller extends controller
{
  /**
   * Chama a view que lista todos os funcionários. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index()
  {
    $resultado = funcionario::read();
    $funcionarios = $resultado->fetch_all(MYSQLI_ASSOC);
    $this->call_view('lista_funcionarios', ['funcionarios' => $funcionarios]);
  }

  /**
   * Chama a view que permite cadastrar um funcionário.
   */
  public function call_cadastro_view()
  {
    $this->call_view('cadastro_funcionarios');
  }

  /**
   * Chama a view que permite editar os dados de um funcionário.
   * @param int $id Identificador do funcionário a ser editado.
   */
  public function call_edicao_view(int $id)
  {
    $resultado = funcionario::read($id);
    if ($resultado->num_rows === 0) {
      $this->call_view('error_404');
    }
    $funcionario = $resultado->fetch_assoc();
    $this->call_view('edicao_funcionarios', ['funcionario' => $funcionario]);
  }

  /**
   * Chama a view que permite cadastrar um novo funcionário.
   */
  public function cadastrar()
  {
    $funcionario = endereco::validarSalvarEndereco($_POST);
    if (!empty($funcionario)) {
      funcionario::create($funcionario);
    }
  }

  /**
   * Atualiza os dados de um funcionário
   * @param int $id Identificador do funcionário a ser editado.
   */
  public function editar($id)
  {
    $funcionario = endereco::update($_POST);
    funcionario::update($id, $funcionario);
  }

  /**
   * Exclui um funcionário
   * @param int $id Identificador do funcionário a ser excluído.
   */
  public function delete($id)
  {
    funcionario::delete($id);
  }

}