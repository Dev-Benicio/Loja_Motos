<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\funcionario;
use App\Models\endereco;
use App\Helpers\higiene_dados;
use App\Helpers\sessao;

class funcionario_controller extends controller
{
  /**
   * Chama a view que lista todos os funcionários. Se os dados não existirem, 
   * a view de erro é chamada.
   */
  public function index()
  {
    $funcionarios = funcionario::read();

    array_walk($funcionarios, function (&$funcionario) {
      $funcionario_endereco = [
        'cidade' => $funcionario['cidade'],
        'unidade_federativa' => $funcionario['unidade_federativa'],
        'rua' => $funcionario['rua'],
        'numero' => $funcionario['numero'],
      ];

      // Formatar os dados que serão mostrados na listagem
      $funcionario['endereco'] = higiene_dados::formatar_endereco($funcionario_endereco);
      $funcionario['telefone'] = higiene_dados::formatar_telefone($funcionario['telefone']);
      $funcionario['data_demissao'] = higiene_dados::formatar_data($funcionario['data_admissao']);
      $funcionario['cpf'] = higiene_dados::formatar_cpf($funcionario['cpf']);

      // Remover os dados que não serão mostrados na listagem
      unset($funcionario['foto_perfil']);
      unset($funcionario['salario']);
      unset($funcionario['login']);
      unset($funcionario['senha']);
      unset($funcionario['data_demissao']);
      unset($funcionario['id_endereco']);
      unset($funcionario['cidade']);
      unset($funcionario['unidade_federativa']);
      unset($funcionario['rua']);
      unset($funcionario['numero']);

      // Adicionar campo de 'Ações' na listagem
      $funcionario['editar_deletar'] = <<<HTML
        <a
          href="./funcionarios/edicao/{$funcionario['id_funcionario']}"
          class="btn fs-5 p-1 link-primary">
          <i class="bi bi-pencil-square" title="Editar"></i>
        </a>
        <a
          href="./funcionarios/remocao/{$funcionario['id_funcionario']}"
          class="btn fs-5 p-1 link-danger">
          <i class="bi bi-x-square" title="Deletar"></i>
        </a>
      HTML;
    });

    $this->call_view('lista_funcionarios', ['funcionarios' => $funcionarios]);
  }

  /**
   * Chama a view que permite cadastrar um funcionário.
   */
  public function call_view_cadastro()
  {
    $this->call_view('cadastro_funcionarios');
  }

  /**
   * Chama a view que permite editar os dados de um funcionário.
   * @param int $id Identificador do funcionário a ser editado.
   */
  public function call_view_edicao(int $id)
  {
    [ $funcionario ] = funcionario::read($id);
    if (count($funcionario) === 0) {
      $this->call_view('error_404');
    }
    $funcionario['telefone'] = higiene_dados::formatar_telefone($funcionario['telefone']);
    $funcionario['cpf'] = higiene_dados::formatar_cpf($funcionario['cpf']);
    $this->call_view('edicao_funcionarios', ['funcionario' => $funcionario]);
  }

  /**
   * Chama a view que permite visualizar o perfil do usuário logado.
   */
  public function call_view_perfil()
  {
    $id_funcionario = sessao::get_sessao('usuario')['id'];
    [$funcionario] = funcionario::read($id_funcionario);

    $funcionario['endereco'] = "{$funcionario['rua']}, {$funcionario['numero']}, {$funcionario['cidade']}, {$funcionario['unidade_federativa']}";
    $funcionario['telefone'] = higiene_dados::formatar_telefone($funcionario['telefone']);
    $funcionario['foto_perfil'] = "/loja_motos/images/funcionarios/{$funcionario['foto_perfil']}";
    $this->call_view('perfil', ['funcionario' => $funcionario]);
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
    header('Location: /loja_motos/funcionarios');
    exit;
  }
}
