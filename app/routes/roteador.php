<?php

namespace App\Routes;

use App\Routes\rotas;

class roteador implements rotas
{
  private const BASE_CONTROLLER_NAMESPACE = 'app\\Controllers\\';
  private const SITE_BASE_PATH = '/loja_motos';

  /*
   * Chama o controller e o método, passando os parâmetros
   */
  private static function call_controller(
    string $controller,
    string $method,
    array $params = []
  ): void {
    $controller_path = self::BASE_CONTROLLER_NAMESPACE . $controller;
    $controller = new $controller_path();
    $controller->$method($params);
  }

  /*
   * Chama a página de erro 404
   */
  private static function call_404_page(): void
  {
    require 'app/views/error_404.php';
  }

  /*
   * Pega a rota - URI
   */
  private static function get_rota(): string
  {
    return $_SERVER['REQUEST_URI'] ?? '/';
  }

  /*
   * Pega o método - GET ou POST
   */
  private static function get_method(): string
  {
    return $_SERVER['REQUEST_METHOD'] ?? 'GET';
  }

  /*
   * Remove do ínicio da uri até '/loja_motos'
   */
  private static function tirar_nome_site_uri(string $rota): string
  {
    return preg_replace('#^.*' . self::SITE_BASE_PATH . '#', '', $rota);
  }

  /*
   * Chama o controller e o método - passa os parâmetros, quando tiver - vindos da interface rotas, à partir da URI
   */
  public static function rotear()
  {
    $url = self::get_rota();
    $rota_sem_nome_site = self::tirar_nome_site_uri($url);
    $method = self::get_method();

    // Remove o '/' final da rota se a rota não for a '/' somente
    $rota_sem_nome_site === '/' ?: rtrim($rota_sem_nome_site, '/');

    foreach (self::ROTAS[$method] as $rota => $controller) {
      $pattern = preg_replace('/{id}/', '(\d+)', $rota);

      if (preg_match("#^{$pattern}$#", $rota_sem_nome_site, $matches)) {
        // Remove o primeiro elemento do array $matches
        array_shift($matches);
        [$controller, $method] = explode('@', $controller);
        return self::call_controller($controller, $method, $matches);
      }
    }

    return self::call_404_page();
  }
}
