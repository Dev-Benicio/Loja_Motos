<?php

namespace App\Controllers;

use App\Controllers\controller;
use App\Models\relatorios;

class dashboard_controller extends controller
{
  /**
   * Chama a view que traz relatórios do loja.
   */
  public function index(): void
  {
    $modelos_mais_vendidos = relatorios::modelo_mais_vendido();
    $vendedores_com_mais_vendas = relatorios::vendedores_com_mais_vendas();
    $vendedores_com_mais_vendas[''] = 
    $estoque_motos = relatorios::estoque_motos();

    $this->call_view('dashboard', [
      'modelos_mais_vendidos' => $modelos_mais_vendidos,
      'vendedores_com_mais_vendas' => $vendedores_com_mais_vendas,
      'estoque_motos' => $estoque_motos,
    ]);
  }

}
