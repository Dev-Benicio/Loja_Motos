<?php

namespace App\Controllers;

use App\Controllers\Controller;

class Home extends Controller
{
  public function index()
  {
    return $this->call_view('dashboard');
  }
}
