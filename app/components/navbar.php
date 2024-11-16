<?php

namespace App\Components;

use App\Components\component;

class navbar extends component
{
  private const acesso_nav_items = [
    "administrador" => [
      "Home" => "/home",
      "Funcionários" => "/funcionarios",
      "Clientes" => "/clientes",
      "Motos" => "/motos",
      "Vendas" => "/vendas",
      "Relatórios" => "/relatorios",
    ],
    "vendedor" => [
      "Home" => "/home",
      "Clientes" => "/clientes",
      "Motos" => "/motos",
      "Vendas" => "/vendas",
    ],
    "estoquista" => [
      "Home" => "/home",
      "Motos" => "/motos",
    ],
  ];

  private function render_items(): string
  {
    $cargo_usuario = $_SESSION['usuario']['cargo'];

    $nav_items_permitidos = match ($cargo_usuario) {
      "administrador" => self::acesso_nav_items["administrador"],
      "vendedor" => self::acesso_nav_items["vendedor"],
      "estoquista" => self::acesso_nav_items["estoquista"],
      default => [],
    };

    $nav_items = array_map(
      function ($item): string {
        [$label, $href] = $item;
        return "
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"{$href}\">
              {$label}
            </a>
          </li>
        ";
      },
      $nav_items_permitidos
    );

    return implode('', $nav_items);
  }

  /**
   * @param string $nivel_acesso Nível de acesso do usuário.
   */
  public function render(): string
  {
    $nav_items = $this->render_items();
    
    return <<<HTML
    <nav class="navbar navbar-expand-lg px-5 pt-3">
      <div class="d-flex justify-content-between align-items-center w-100">
        <!-- Botão que abre e fecha a navegação, quando a tela é pequena -->
        <button 
          class="navbar-toggler border-0 bg-transparent"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <i class="navbar-toggler-icon"></i>
        </button>
        <!-- Navegação -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav gap-2" style="font-size: 1.1rem;">
            {$nav_items}
            <li class="nav-item d-flex align-items-center justify-content-center ms-4">
              <i class="bi bi-person-circle fs-5"></i>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    HTML;
  }
}