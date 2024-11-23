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
<?php

namespace App\Controllers;

use App\Controllers\controller;

class funcionario extends controller
{
  public function index(): void
  {
    $this->call_view('lista_funcionarios');
  }

  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_funcionarios');
  }

  public function call_edicao_view(): void
  {
    $this->call_view('edicao_funcionarios');
  }

  public function cadastrar() {
  $login_funcionario
  $senha
  $nome
  $cpf
  $endereco
  $telefone
  $email
  $cargo
  $data_admissao
  $data_demissao
  $salario
  $status_funcionario
  $foto_perfil
  }

  public function listar(int $id = null) {}

  public function editar($id) {}

  public function exluir($id) {}
}
