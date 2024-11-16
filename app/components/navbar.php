<?php

namespace App\Components;

use App\Components\component;
use App\Helpers\sessao;

class navbar extends component
{
  private const acesso_nav_items = [
    "administrador" => [
      "Home" => "./home",
      "Funcionários" => "./funcionarios",
      "Clientes" => "./clientes",
      "Motos" => "./motos",
      "Vendas" => "./vendas",
      "Relatórios" => "./relatorios",
    ],
    "vendedor" => [
      "Home" => "./home",
      "Clientes" => "./clientes",
      "Motos" => "./motos",
      "Vendas" => "./vendas",
    ],
    "estoquista" => [
      "Home" => "./home",
      "Motos" => "./motos",
    ],
  ];

  /** 
   * Renderiza os itens da navegação em html.
   * @return string Retorna os itens da navegação em html de acordo com o cargo do usuário.
   */
  private function render_items(): string|null
  {
    $cargo_usuario = sessao::get('usuario')['cargo'] ?? 'administrador';

    $nav_items_permitidos = match ($cargo_usuario) {
      "administrador" => self::acesso_nav_items["administrador"],
      "vendedor" => self::acesso_nav_items["vendedor"],
      "estoquista" => self::acesso_nav_items["estoquista"],
      default => [],
    };

    $nav_items = array_map(
      function ($label, $href): string {
        return "
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"{$href}\">
              {$label}
            </a>
          </li>
        ";
      },
      array_keys($nav_items_permitidos),
      array_values($nav_items_permitidos)
    );

    return implode('', $nav_items);
  }

  /**
   * Renderiza a navegação em html.
   * @return string Retorna a navegação renderizada em html.
   */
  public function render(): string
  {
    $nav_items = $this->render_items();

    return <<<HTML
    <nav class="navbar navbar-expand-lg pe-5">
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
