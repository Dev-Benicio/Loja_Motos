<?php

namespace App\Controllers;

use App\Controllers\controller;

class dashboard extends controller
{
  public function index(): void
  {
    $this->call_view('dashboard');
  }

  public function call_funcionarios_view(): void
  {
    $this->call_view('relatorio_funcionarios');
  }
}
