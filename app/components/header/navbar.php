<?php

namespace App\Components\Header;

class navbar implements nav_items
{
  private function render_nav_items(): string
  {
    return "";
  }

  public function render(): string
  {
    return "
    <!-- Navegação -->
    <div class=\"collapse navbar-collapse justify-content-end\" id=\"navbarNav\">
      <ul class=\"navbar-nav gap-2\" style=\"font-size: 1.1rem;\">
        <li class=\"nav-item\">
          <a class=\"nav-link active\" aria-current=\"page\" href=\"#\">Home</a>
        </li>
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"#\">Clientes</a>
        </li>
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"#\">Motos</a>
        </li>
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"#\">Vendas</a>
        </li>
        <li class=\"nav-item d-flex align-items-center justify-content-center ms-4\">
          <i class=\"bi bi-person-circle fs-4\"></i>
        </li>
      </ul>
    </div>
    ";
  }
}
