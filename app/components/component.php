<?php

namespace App\Components;

abstract class component
{
  /** 
   * @var string[] Array associativo contendo atributos do HTML. A chave é o nome do atributo e o valor é o valor do atributo.
   */
  private array $attributes;

  public function set_attributes(array $attributes): void
  {
    $this->attributes = $attributes;
  }

  public function get_attributes(): array
  {
    return $this->attributes;
  }

  /** 
   * Renderiza o componente em tela.
   * @return string Retorna uma string com o conteúdo do componente em html
   */
  abstract public function render(): string;

}