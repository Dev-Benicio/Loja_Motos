<?php

namespace App\Components;

class input_text extends component
{
  private string $id;
  private string $label;
  private string $placeholder;
  private string $type;
  private string $value;

  /**
   * Construtor do componente input_text.
   * @param string $id Identificador do input.
   * @param string $label Etiqueta do input.
   * @param string $placeholder Placeholder do input.
   * @param string $type Tipo do input.
   * @param string $value Valor do input.
   */
  public function __construct(
    string $id,
    string $label,
    string $placeholder,
    string $type,
    string $value
  ) {
    $this->id = $id;
    $this->label = $label;
    $this->placeholder = $placeholder;
    $this->type = $type;
    $this->value = $value;
  }

  /**
   * Renderiza o componente input_text.
   * @return string Retorna o componente input_text em forma de string.
   */
  public function render(): string
  {
    return <<<Input
      <div class="col-md-6">  
        <label for="{$this->id}" class="form-label">{$this->label}</label>
        <input type="{$this->type}" class="form-control input-field" id="{$this->id}" placeholder="{$this->placeholder}" value="{$this->value}">
      </div>
    Input;
  }
  
}