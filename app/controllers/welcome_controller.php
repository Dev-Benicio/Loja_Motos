<?php

namespace App\Controllers;

use App\Controllers\controller;

class welcome_controller extends controller
{
  public function index()
  {
    return $this->call_view('welcome');
  }
}
