<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Database\gerente_conexao;
use App\Models\venda;
use App\Models\moto;

class venda_controller extends controller
{
  /**
   * Chama a view que lista todas as vendas. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index(): void
  {
    $resultado = venda::read();
    $vendas = $resultado->fetch_all(MYSQLI_ASSOC);
    gerente_conexao::fechar_conexao();
    $this->call_view('lista_vendas', ['vendas' => $vendas]);
  }

  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_vendas');
  }

  public function call_edicao_view(): void
  {
    $this->call_view('edicao_vendas');
  }

  public function cadastrar()
  {
    // Realizavalidação de dados, e se tem moto disponivel no estoque
    if (venda::validate($_POST)) {
      // Se a venda for realizada com sucesso, diminui a quantidade de moto no estoque já que uma moto foi vendida
      venda::create($_POST) ? moto::atualizarEstoqueMoto($_POST['id_moto'], true) : false;
    }
    gerente_conexao::fechar_conexao();
  }

  public function editar($id)
  {
    $venda_atual = venda::read($id)->fetch_assoc();
    // Realiza a atualização de vendas
    if (venda::update($id, $_POST)) {
      // Só executa se o status tiver sido alterado
      if (isset($_POST['status_venda']) && $_POST['status_venda'] !== $venda_atual['status_venda']) {
        if ($_POST['status_venda'] === 'CANCELADA') {
          moto::atualizarEstoqueMoto($venda_atual['id_moto'], false);
        } else if ($_POST['status_venda'] === 'CONCLUIDA') {
          moto::atualizarEstoqueMoto($venda_atual['id_moto'], true);
        }
      }
    }
    gerente_conexao::fechar_conexao();
  }

  public function exluir($id)
  {
    $venda = venda::read($id)->fetch_assoc();
    if ($venda) {
      // Primeiro tenta excluir a venda
      if (venda::delete($id)) {
        // Se excluiu com sucesso, atualiza o estoque
        if (moto::atualizarEstoqueMoto($venda['id_moto'], false)) {
          $redirect = true;
        }
      }
    }
    gerente_conexao::fechar_conexao();
    $redirect = false;
    $redirect ? $this->call_view('lista_vendas') : $this->call_view('erro');
  }
}
