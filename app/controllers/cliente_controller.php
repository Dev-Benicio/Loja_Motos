<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Helpers\higiene_dados;
use App\Models\cliente;
use App\Models\endereco;

class cliente_controller extends controller
{
  /** 
   * Chama a view que lista todos os clientes. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index(): void
  {
    $clientes = cliente::read();

    array_walk($clientes, function (&$cliente) {
      $cliente_endereco = [
        'cidade' => $cliente['cidade'],
        'unidade_federativa' => $cliente['unidade_federativa'],
        'rua' => $cliente['rua'],
        'numero' => $cliente['numero'],
      ];

      // Formatar os dados que serão mostrados na listagem
      $cliente['endereco'] = higiene_dados::formatar_endereco($cliente_endereco);
      $cliente['telefone'] = higiene_dados::formatar_telefone($cliente['telefone']);
      $cliente['data_nascimento'] = higiene_dados::formatar_data($cliente['data_nascimento']);
      $cliente['cpf'] = higiene_dados::formatar_cpf($cliente['cpf']);

      // Remover os dados que não serão mostrados na listagem
      unset($cliente['id_endereco']);
      unset($cliente['cidade']);
      unset($cliente['unidade_federativa']);
      unset($cliente['rua']);
      unset($cliente['numero']);

      // Adicionar campo de 'Ações' na listagem
      $cliente['editar_deletar'] = <<<Botoes
        <a href="./clientes/edicao/{$cliente['id_cliente']}" class="btn fs-5 p-1 link-primary">
          <i class="bi bi-pencil-square" title="Editar"></i>
        </a>
        <a href="./clientes/remocao/{$cliente['id_cliente']}" class="btn fs-5 p-1 link-danger">
          <i class="bi bi-x-square" title="Deletar"></i>
        </a>
      Botoes;
    });

    $this->call_view('lista_clientes', ['clientes' => $clientes]);
  }

  /**
   * Chama a view que permite cadastrar um novo cliente.
   */
  public function call_view_cadastro(): void
  {
    $this->call_view('cadastro_clientes');
  }

  /**
   * Chama a view que permite editar os dados de um cliente.
   * @param int $id Identificador do cliente a ser editado.
   */
  public function call_view_edicao(int $id): void
  {
    [$cliente] = cliente::read($id);
    if (count($cliente) === 0) {
      $this->call_view('error_404');
    }

    // Formatar os dados que serão mostrados na listagem
    $cliente['telefone'] = higiene_dados::formatar_telefone($cliente['telefone']);
    $cliente['data_nascimento'] = date('Y/m/d', strtotime($cliente['data_nascimento']));
    $cliente['data_nascimento'] = str_replace('/', '-', $cliente['data_nascimento']);
    $cliente['cpf'] = higiene_dados::formatar_cpf($cliente['cpf']);

    $this->call_view('edicao_clientes', ['cliente' => $cliente]);
  }

  /**
   * Cadastra clientes
   */
  public function cadastrar(): void
  { 
    $cliente = endereco::validarSalvarEndereco($_POST);
    if (!empty($cliente)) {
      cliente::create($cliente);
    }
  }

  /**
   * Atualiza os dados de um cliente
   * @param int $id Identificador do cliente a ser editado.
   */
  public function editar($id): void
  {
    $cliente = endereco::update($_POST);
    cliente::update($id, $cliente);
  }

  /**
   * Exclui um cliente
   * @param int $id Identificador do cliente a ser excluído.
   */
  public function exluir($id): void
  {
    cliente::delete($id);
  }

}