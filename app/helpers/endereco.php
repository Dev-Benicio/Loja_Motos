<?php

namespace App\Helpers;

use Exception;

class endereco
{
  /**
   * Pega o endereço por CEP
   * @param string $cep O CEP a ser pesquisado
   * @return array Retorna o endereço em formato de array
   */
  public static function get_endereco_por_cep(string $cep): array
  {
    $cep = preg_replace('/[^0-9]/', '', $cep);
    if (!higiene_dados::check_cep($cep)) {
      return [];
    }

    try {
      $url = "https://brasilapi.com.br/api/cep/v1/{$cep}";
      $response = file_get_contents($url);
      return json_decode($response, true);
    } catch (Exception $e) {
      return false;
    }
  }
  
}