<?php

namespace App\Components;

use App\Components\component;

class input extends component
{
  private string $type;
  private string $name;
  private string $value;
  private string $placeholder;
  private string $label;

  public function __construct(string $type, string $name, string $value, string $placeholder)
  {
    $this->type = $type;
    $this->name = $name;
    $this->value = $value;
    $this->placeholder = $placeholder;
  }

  public function render(): string
  {
    return "
      <input
        class=\"form-control\"
        type=\"{$this->type}\"
        name=\"{$this->name}\"
        value=\"{$this->value}\"
        placeholder=\"{$this->placeholder}\"
      >
    ";
  }
}
