<?php

namespace App\Models;

use mysqli;
use Exception;

class relatorios extends model
{
  /**
   * Retorna os 5 modelos mais vendidos
   * @return array Array com os modelos mais vendidos ou array vazio
   */
  public static function modelo_mais_vendido(): array
  {
    parent::init_conexao();
    try {
      $sql = "SELECT * FROM motos_mais_vendidos LIMIT 5";
      $stmt = parent::$conexao->prepare($sql);
      $stmt->execute();

      $modelos_mais_vendidos = [];
      $resultado = $stmt->get_result();
      while ($linha = $resultado->fetch_assoc()) {
        $modelos_mais_vendidos[] = $linha;
      }
      return $modelos_mais_vendidos;
    } catch (Exception $e) {
      return [];
    }
  }


  /**
   * Retorna os 3 vendedores com maior número de vendas
   * @return array Array com dados dos vendedores ou array vazio se erro
   */
  public static function vendedores_com_mais_vendas(): array
  {
    parent::init_conexao();
    try {
      $sql = "SELECT * FROM vendas_por_vendedor LIMIT 3";
      $stmt = parent::$conexao->prepare($sql);
      $stmt->execute();

      $resultado = $stmt->get_result();
      return $resultado->fetch_all(MYSQLI_ASSOC) ?: [];
    } catch (Exception $e) {
      return [];
    }
  }

  /**
   * Retorna quantidade de motos em estoque
   * @return int Quantidade de motos ou 0 se erro
   */
  public static function estoque_motos(): int
  {
    parent::init_conexao();
    try {
      $sql = "SELECT * FROM quantidade_em_estoque";
      $stmt = parent::$conexao->prepare($sql);
      $stmt->execute();

      $result = $stmt->get_result();
      return (int)($result->fetch_row()[0] ?? 0);
    } catch (Exception $e) {
      return 0;
    }
  }

  // Para status_reposicao e status_funcionarios
  public static function status_reposicao(): mysqli|false
  {
    parent::init_conexao();
    try {
      $sql = "SELECT * FROM status_reposicao WHERE quantidade_estoque < 15";
      $stmt = parent::$conexao->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    } catch (Exception $e) {
      return false;
    }
  }


  /**
   * Retorna dados da view status_funcionario
   * @return array Array com status dos funcionários ou array vazio se erro
   */
  public static function status_funcionarios(): array
  {
    parent::init_conexao();
    try {
      $sql = "SELECT * FROM status_funcionario";
      $stmt = parent::$conexao->prepare($sql);
      $stmt->execute();

      return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?: [];
    } catch (Exception $e) {
      return [];
    }
  }
}
