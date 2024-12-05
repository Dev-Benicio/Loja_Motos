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
  private function render_items(string $item_ativo = ''): string|null
  {
    $cargo_usuario = sessao::get_sessao('usuario')['cargo'];

    $nav_items_permitidos = match ($cargo_usuario) {
      "administrador" => self::acesso_nav_items["administrador"],
      "vendedor" => self::acesso_nav_items["vendedor"],
      "estoquista" => self::acesso_nav_items["estoquista"],
      default => [],
    };

    $nav_items = array_map(
      function ($label, $href) use ($item_ativo): string {
        $actve_class_link = "nav-link active bg-dark text-white-80 rounded-2 py-1 px-2";
        $is_item_ativo = $item_ativo === $label;
        $class_link = $is_item_ativo ? $actve_class_link : 'nav-link';

        return "
          <li class=\"nav-item d-flex align-items-center\">
            <a class=\"{$class_link}\" href=\"{$href}\">
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
  public function render(string $item_ativo = ''): string
  {
    $nav_items = $this->render_items($item_ativo);

    return <<<HTML
    <nav class="navbar navbar-expand-lg px-5 w-100">
      <div class="container-fluid d-flex justify-content-between align-items-center w-100">
        <!-- Nome do site e da página atual -->
        <div class="nav-bar-brand">
          <span class="status-text fw-light mb-0 fs-6">Dashboard</span>
          <h2 class="brand-name fw-semibold fs-5 mt-1">Thunder Gears</h2>
        </div>
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
            <li class="nav-item d-flex align-items-center dropdown">
              <button
                type="button"
                class="dropdown-toggle border-0 outline-0 bg-transparent"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-person-circle fs-5 ps-2"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end mt-2">
                <li><a class="dropdown-item" href="perfil">Meu perfil</a></li>
                <li>
                  <button type="button" class="dropdown-item">
                    Trocar tema
                  </button>
                </li>
                <li><a class="dropdown-item" href="logout">Sair</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    HTML;
  }
}
