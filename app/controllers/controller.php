<?php

namespace App\Controllers;

abstract class controller
{
  abstract public function index();

  public function call_view(string $view_name)
  {
    $caminho_view = "app/views/{$view_name}.php";
    file_exists($caminho_view) && require_once $caminho_view;
  }
}
