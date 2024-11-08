<?php

namespace App\Controllers;

use App\Controllers\controller;

class login extends controller
{
  public function index()
  {
    $this->call_view('login');
  }
}
