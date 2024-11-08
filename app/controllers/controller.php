<?php

namespace App\Controllers;

abstract class controller
{
  abstract public function index();

  public function call_view($view_name)
  {
    require_once "app/views/{$view_name}.php";
  }
}
