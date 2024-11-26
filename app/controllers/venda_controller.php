<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Database\gerente_conexao;

class venda extends controller
{
  public function index(): void
  {
    $this->call_view('lista_vendas');
  }

  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_vendas');
  }

  public function call_edicao_view(): void
  {
    $this->call_view('edicao_vendas');
  }

  public function cadastrar() {
    // Valida se o cliente, funcionário e moto existem pelo ID, verifica se qtd_moto > 0
    // Se existirem, cria uma venda
    if (venda::validate($_POST)) {
        venda::create($_POST) ? moto::estoque($_POST['id_moto']) : false;
    }

    gerente_conexao::fechar_conexao();
  }

  public function listar(int $id = null) {
    venda::read($id);

    gerente_conexao::fechar_conexao();
  }

  public function editar($id) {
    venda::update($id, $_POST);

    gerente_conexao::fechar_conexao();
  }

  public function exluir($id) {
    venda::delete($id);

    gerente_conexao::fechar_conexao();
  }
}
