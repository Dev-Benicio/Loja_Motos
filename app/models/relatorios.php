<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli;
use Exception;

class Relatorios
{
  private static mysqli $conexao = gerente_conexao::conectar();

  public static function modeloMaisVendido()
  {
    try {
      self::$conexao->begin_transaction();
      $sql = "SELECT * FROM motos_mais_vendidos LIMIT 1";
      $stmt = self::$conexao->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    } catch (Exception $e) {
      self::$conexao->rollback();
      return false;
    }
  }

  public static function vendedorMaisVendas()
  {
    try {
      self::$conexao->begin_transaction();
      $sql = "SELECT * FROM vendas_por_vendedor LIMIT 1";
      $stmt = self::$conexao->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    } catch (Exception $e) {
      self::$conexao->rollback();
      return false;
    }
  }

  public static function estoqueMotos()
  {
    try {
      self::$conexao->begin_transaction();
      $sql = "SELECT * FROM quantidade_em_estoque";
      $stmt = self::$conexao->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    } catch (Exception $e) {
      self::$conexao->rollback();
      return false;
    }
  }

  public static function statusReposicao()
  {
    try {
      self::$conexao->begin_transaction();
      $sql = "SELECT * FROM status_reposicao WHERE quantidade_estoque < 15";
      $stmt = self::$conexao->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    } catch (Exception $e) {
      self::$conexao->rollback();
      return false;
    }
  }

  public static function statusFuncionarios()
  {
    try {
      self::$conexao->begin_transaction();
      $sql = "SELECT * FROM status_funcionario";
      $stmt = self::$conexao->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    } catch (Exception $e) {
      self::$conexao->rollback();
      return false;
    }
  }
}
