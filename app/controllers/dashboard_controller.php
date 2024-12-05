<?php

namespace App\Controllers;

use App\Controllers\controller;

class dashboard_controller extends controller
{
  /**
   * Chama a view que traz relatórios do loja.
   */
  public function index(): void
  {
    $this->call_view('dashboard');
  }

}
