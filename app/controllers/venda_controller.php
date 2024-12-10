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

    array_walk($vendas, function (&$venda) {
      // Tratar dados que serão exibidos na listagem de vendas
      $venda['cpf'] = higiene_dados::formatar_cpf($venda['cpf']);
      $venda['nome_cliente'] = <<<HTML
        <span class="fw-bold">{$venda['nome_cliente']}</span>
        <br>
        <span class="text-secondary">CPF: {$venda['cpf']}</span>
      HTML;
      $venda['valor_total_venda'] = higiene_dados::formatar_preco($venda['valor_total_venda']);
      $venda['data_venda'] = higiene_dados::formatar_data($venda['data_venda']);

      $venda['editar_remover'] = <<<HTML
        <a
          href="./funcionarios/edicao/{$venda['id_venda']}"
          class="btn fs-5 p-1 link-primary">
          <i class="bi bi-pencil-square" title="Editar"></i>
        </a>
        <a
          href="./vendas/remocao/{$venda['id_venda']}"
          class="btn fs-5 p-1 link-danger">
          <i class="bi bi-x-square" title="Deletar"></i>
        </a>
      HTML;

      // Limpar dados que não serão exibidos na listagem de vendas
      unset($venda['cpf']);
      unset($venda['id_cliente'], $venda['id_funcionario'], $venda['id_moto']);
      unset($venda['status_venda']);
    });

    $this->call_view('lista_vendas', ['vendas' => $vendas]);
  }

  /**
   * Chama a view que permite cadastrar uma venda.
   */
  public function call_view_cadastro(): void
  {
    $motos = [];
    $carrinho = sessao::get_sessao('carrinho') ?? [];

    if (!empty($carrinho)) {
      foreach ($carrinho as $item) {
        [$moto] = \App\Models\moto::read($item[0]);
        if ($moto) {
          $moto['preco'] = higiene_dados::formatar_preco($moto['preco']);
          $moto['foto_moto'] = "/loja_motos/images/motos/{$moto['foto_moto']}";
          $moto['quantidade_carrinho'] = $item[1];
          $motos[] = $moto;
        }
      }
    }
    $this->call_view('cadastro_vendas', ['motos' => $motos]);
  }

  /**
   * Chama a view que permite editar os dados de uma venda.
   * @param int $id Identificador da venda a ser editada.
   */
  public function call_view_edicao(int $id): void
  {
    $this->call_view('edicao_vendas', ['id_venda' => $id]);
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
        [$moto] = moto::read($id[0]);
        if ($moto) {
          $moto['preco'] = higiene_dados::formatar_preco($moto['preco']);
          $moto['foto_moto'] = "/loja_motos/images/motos/{$moto['foto_moto']}";
          $moto['quantidade_carrinho'] = $id[1];
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
    $carrinho_atual = sessao::get_sessao('carrinho') ?? [];
    $encontrou_moto = false;

    foreach ($carrinho_atual as $chave => $item) {
      if ($item[0] == $id) {
        $carrinho_atual[$chave][1]++;
        $encontrou_moto = true;
        break;
      }
    }

    if (!$encontrou_moto) {
      $carrinho_atual[] = [$id, 1];
    }

    sessao::set_sessao('carrinho', $carrinho_atual);
    header('Location: /loja_motos/motos');
    exit;
  }

  /**
   * Remove uma moto do carrinho de compras.
   * @param int $id Identificador da moto a ser removida.
   */
  public function remover_moto_do_carrinho(int $id): void
  {
    $carrinho_atual = sessao::get_sessao('carrinho') ?? [];
    $encontrou_item = false;

    foreach ($carrinho_atual as $chave => $item) {
      if ($item[0] == $id) {
        if ($item[1] > 1) {
          $carrinho_atual[$chave][1]--;
        } else {
          unset($carrinho_atual[$chave]);
        }
        $encontrou_item = true;
        break;
      }
    }

    if ($encontrou_item) {
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
