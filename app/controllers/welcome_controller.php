<?php

namespace App\Controllers;

use App\Controllers\controller;

class welcome_controller extends controller
{
  /**
   * Chama a view de boas vindas
   */
  public function index()
  {
    return $this->call_view('welcome');
  }

}