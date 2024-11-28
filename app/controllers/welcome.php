<?php

namespace App\Controllers;

use App\Controllers\Controller;

class welcome extends Controller
{
  public function index()
  {
    return $this->call_view('welcome');
  }
}
