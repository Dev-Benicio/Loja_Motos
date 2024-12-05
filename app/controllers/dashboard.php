<?php 

namespace App\Controllers;

class dashboard extends controller
{
  public function index()
  {
    $this->call_view('dashboard');
  }
}