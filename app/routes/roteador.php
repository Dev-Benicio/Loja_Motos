<?php

namespace App\Routes;

use App\Routes\rotas;
use App\Helpers\sessao;

class roteador implements rotas
{
  private const BASE_CONTROLLER_NAMESPACE = "App\\Controllers\\";
  private const CONTROLLERS_PUBLICOS = ["login"];

  /**
   * Chama o controller e o método, passando os parâmetros
   */
  private static function call_controller(
    string $controller,
    string $method,
    array $params = []
  ): void {
    $base_namespace = self::BASE_CONTROLLER_NAMESPACE;
    $controller_path = $base_namespace . $controller . "_controller";

    $is_controller_publico = in_array($controller, self::CONTROLLERS_PUBLICOS);
    if (!$is_controller_publico && !sessao::get_sessao('usuario')) {
      header('Location: ');
      return;
    }

    $controller = new $controller_path();
    $controller->$method($params);
  }

  /**
   * Chama a página de erro 404
   */
  private static function call_404_page(): void
  {
    require 'app/views/error_404.php';
  }

  /**
   * Pega a rota - URI
   * @return string - Retorna a rota
   */
  private static function get_rota(): string
  {
    return $_SERVER['REQUEST_URI'] ?? '/';
  }

  /**
   * Pega o método - GET ou POST
   * @return string - Retorna o método que veio a rota. Ex: GET, POST
   */
  private static function get_method(): string
  {
    return $_SERVER['REQUEST_METHOD'] ?? 'GET';
  }

  /**
   * Remove do ínicio da uri até '/loja_motos'
   * @return string - Retorna a rota sem o nome do site
   */
  private static function tirar_nome_site_uri(string $rota): string
  {
    $pattern = '#^.*/[Ll]oja_[Mm]otos#';
    return preg_replace($pattern, '', $rota);
  }

  /**
   * Chama o controller e o método - passa os parâmetros, quando tiver - vindos da interface rotas, à partir da URI
   */
  public static function rotear(): void
  {
    $uri = self::get_rota();
    $rota_sem_nome_site = self::tirar_nome_site_uri($uri);
    $method = self::get_method();

    // Remove o '/' final da rota se a rota não for a '/' somente
    $rota_sem_nome_site === '/' ?: rtrim($rota_sem_nome_site, '/');

    foreach (self::ROTAS[$method] as $rota => $controller) {
      $pattern = preg_replace(
        ['/{id}/', '/{query}/'], ['(\d+)', '(\?[a-zA-Z0-9_\-=&]+)'],
        $rota
      );

      if (preg_match("#^{$pattern}$#", $rota_sem_nome_site, $matches)) {
        // Remove o primeiro item do array, deixando somente os parâmetros encontradods
        array_shift($matches);
        [$controller, $method] = explode('@', $controller);
        self::call_controller($controller, $method, $matches);
        return;
      }
    }

    self::call_404_page();
  }
}
