<?php

namespace App\Controllers;

use App\Controllers\controller;

class dashboard_controller extends controller
{
  public function index(): void
  {
    $this->call_view('dashboard');
  }
}
