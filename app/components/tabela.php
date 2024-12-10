<?php

namespace App\Components;
use App\Components\component;

class tabela extends component
{
  private array $linhas;
  private array $cabecalho;

  /**
   * Construtor do componente tabela.
   * @param array $cabecalho Array contendo os nomes das colunas da tabela.
   * @param array $linhas Array contendo outros arrays, cada array deve conter uma linha da tabela.
   */
  public function __construct(array $cabecalho, array $linhas)
  {
    $this->cabecalho = $cabecalho;
    $this->linhas = $linhas;
  }

  /** 
   * Renderiza o cabeçelho da tabela, tranformando o atributo array $cabecalho em string.
   * @return string Retorna o cabeçalho da tabela em forma de string com as tags html.
   */
  private function render_cabecalho(): string
  {
    $cabecalhos = array_map(
      fn($cabecalho) => "<th scope=\"col\">$cabecalho</th>",
      $this->cabecalho
    );

    $cabecalho = implode('', $cabecalhos);
    return "<tr>{$cabecalho}</tr>";
  }

  /**
   * Renderiza as linhas da tabela, tranformando o atributo array $linhas em string.
   * @return string Retorna as linhas da tabela em forma de string com as tags html.
   */
  public function render_linhas(): string
  {
    if (empty($this->linhas) || count($this->linhas) === 0) {
      return "
        <tr>
          <td colspan=\"{$this->cabecalho}\">Nenhum dado encontrado</td>
        </tr>
      ";
    }

    $linhas = "";
    foreach ($this->linhas as $linha) {
      $linha = array_map(
        fn($item) => "<td>{$item}</td>",
        $linha
      );
      $linha = implode("", $linha);
      $linhas .= "<tr>{$linha}</tr>";
    }

    return $linhas;
  }

  /**
   * Renderiza a tabela, convertendendo o cabeçalho e as linhas em string.
   * @return string Retorna a tabela em forma de string com as tags html.
   */
  public function render(): string
  {
    return "
      <table class=\"table table-striped table-hover table-borderless w-100 overflow-hidden rounded-3 shadow-sm\">
        <thead class=\"thead table-dark\">
          {$this->render_cabecalho()}
        </thead>
        <tbody class=\"tbody overflow-hidden\" style=\"height: 500px;\">
          {$this->render_linhas()}
        </tbody>
      </table>
    ";
  }
  
}