<?php

namespace App\Controllers;

abstract class controller
{
  /**
   * Chama a view principal que deve ser acessada ao chamar um determinado controller
   */
  abstract public function index();

  /**
   * Chama uma view e passa, quando tiver, os parâmetros para serem acessados na view.
   * @param string $view_name Nome da view que deseja chamar.
   * @param array $params Array associativo com os parâmetros a serem passados.
   */
  public function call_view(string $view_name, array $params = []): void
  {
    $caminho_view = "app/views/{$view_name}.php";

    if (!file_exists($caminho_view)) {
      require_once "app/views/error_404.php";
      exit;
    }

    // Cada elemento do array associativo é transformado em uma variável
    extract($params);
    require_once $caminho_view;
    exit;
  }

}