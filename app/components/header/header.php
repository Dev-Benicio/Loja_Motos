<?php

namespace App\Components\Header;

use App\Components\Header\navbar;
use App\Components\Header\nav_items;

class header implements nav_items
{
  private string $nome_da_pagina;
  private navbar $navbar;

  public function __construct(string $nome_da_pagina)
  {
    $this->nome_da_pagina = $nome_da_pagina;
  }

  public function render(): string
  {
    return "
      <header class=\"border-bottom\">
      <nav class=\"navbar navbar-expand-lg px-5 pt-3\">
        <div class=\"d-flex justify-content-between align-items-center w-100\">
          <!-- Logo -->
          <div class=\"d-flex flex-column\">
            <span class=\"status-text fw-light mb-0 fs-6\">{$this->nome_da_pagina}</span>
            <h2 class=\"brand-name fw-semibold fs-5 mt-1\">Thunder Gears</h2>
          </div>
          <!-- Navegação -->
          {$this->navbar->render()}
        </div>
      </nav>
    </header>
    ";
  }
}
