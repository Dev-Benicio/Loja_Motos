<?php

namespace App\Routes;

use App\Routes\rotas;

class roteador implements rotas
{
  private static function call_controller(
    string $controller,
    string $method,
    array $params = []
  ) {
    $controller_path = 'app\\controllers\\' . $controller;
    $controller = new $controller_path();
    $controller->$method($params);
  }

  /*
   * Chamar a página de erro 404
   */
  private static function call_404_page()
  {
    require 'app/views/error_404.php';
  }

  /*
   * Pegar a rota - URI
   */
  private static function get_rota()
  {
    return $_SERVER['REQUEST_URI'];
  }

  /*
   * Remover do ínicio da uri até '/loja_motos'
   */
  private static function extrair_uri(string $rota)
  {
    $url_pattern = '#^.*\/loja_motos#';
    return preg_replace($url_pattern, '', $rota);
  }

  /*
   * Pegar o método - GET ou POST
   */
  private static function get_method()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  /*
   * Chamar o controller e o método vindos da interface rotas, à partir da URI
   */
  public static function rotear()
  {
    // Pegar a rota
    $rota = self::get_rota();
    $rota_extraida = self::extrair_uri($rota);

    // Pegar o método
    $method = self::get_method();
    // Verificar se a rota existe
    $rota_existente = self::ROTAS[$method][$rota_extraida] ?? null;

    // Chamar o controller e o método
    if ($rota_existente) {
      [$controller, $method] = explode('@', $rota_existente);
      return self::call_controller($controller, $method);
    }

    // Se não existir a rota, chamar a página de erro 404
    return self::call_404_page();
  }
}
