<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Helpers\higiene_dados;
use App\Helpers\sessao;
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
    $vendas = venda::read();
    $this->call_view('lista_vendas', ['vendas' => $vendas]);
  }

  /**
   * Chama a view que permite cadastrar uma venda.
   */
  public function call_cadastro_view(): void
  {
    $this->call_view('cadastro_vendas');
  }

  /**
   * Chama a view que permite editar os dados de uma venda.
   * @param int $id Identificador da venda a ser editada.
   */
  public function call_edicao_view(): void
  {
    $this->call_view('edicao_vendas');
  }

  /**
   * Chama a view que lista os produtos no carrinho de compras.
   */
  public function call_carrinho_view(): void
  {
    $ids_motos = sessao::get_sessao('carrinho') ?? [];
    $motos = [];

    if (!empty($ids_motos)) {
      foreach ($ids_motos as $id) {
        [ $moto ] = moto::read($id);
        if ($moto) {
          $moto['preco'] = higiene_dados::formatar_preco($moto['preco']);
          $moto['foto_moto'] = "/loja_motos/images/motos/{$moto['foto_moto']}";
          $motos[] = $moto;
        }
      }
    }

    $this->call_view('carrinho_de_compras', ['motos' => $motos]);
  }

  /**
   * Adiciona uma moto ao carrinho de compras.
   * @param int $id Identificador da moto a ser adicionada.
   */
  public function adicionar_moto_ao_carrinho($id): void
  {
    // Debug para ver o ID recebido
    var_dump('ID recebido:', $id);
    
    $carrinho_atual = sessao::get_sessao('carrinho') ?? [];
    // Debug para ver o carrinho atual
    var_dump('Carrinho atual:', $carrinho_atual);
    
    if (!in_array($id, $carrinho_atual)) {
      $carrinho_atual[] = $id;
      sessao::set_sessao('carrinho', $carrinho_atual);
    }
    
    // Debug para ver o carrinho após adição
    var_dump('Carrinho após adição:', sessao::get_sessao('carrinho'));
    
    header('Location: /loja_motos/motos');
    exit;
  }

  /**
   * Remove uma moto do carrinho de compras.
   * @param int $id Identificador da moto a ser removida.
   */
  public function remover_moto_do_carrinho($id): void
  {
    $carrinho_atual = sessao::get_sessao('carrinho') ?? [];
    
    if (($chave = array_search($id, $carrinho_atual)) !== false) {
      unset($carrinho_atual[$chave]);
      sessao::set_sessao('carrinho', array_values($carrinho_atual));
    }
    
    header('Location: /loja_motos/vendas/carrinho');
    exit;
  }

  /**
   * Cadastra uma venda
   */
  public function cadastrar()
  {
    // Realizavalidação de dados, e se tem moto disponivel no estoque
    if (venda::validate($_POST)) {
      // Se a venda for realizada com sucesso, diminui a quantidade de moto no estoque já que uma moto foi vendida
      venda::create($_POST) ? moto::atualizarEstoqueMoto($_POST['id_moto'], true) : false;
    }
  }

  /**
   * Atualiza os dados de uma venda
   * @param int $id Identificador da venda a ser editada.
   */
  public function editar($id)
  {
    $venda_atual = venda::read($id);
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
  }

  /**
   * Exclui uma venda
   * @param int $id Identificador da venda a ser excluída
   */
  public function exluir($id)
  {
    $venda = venda::read($id);
    if ($venda) {
      // Primeiro tenta excluir a venda
      if (venda::delete($id)) {
        // Se excluiu com sucesso, atualiza o estoque
        if (moto::atualizarEstoqueMoto($venda['id_moto'], false)) {
          $redirect = true;
        }
      }
    }

    $redirect = false;
    $redirect ? $this->call_view('lista_vendas') : $this->call_view('erro');
  }

}