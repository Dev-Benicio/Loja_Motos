<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli, mysqli_result;
use Exception;

class model
{
  /**
   * Atributo que fornece uma conexão com o banco de dados.
   * 
   * OBS: A conexão deve ser inicializada pelo método `init_conexao()`.
   */
  protected static mysqli $conexao;

  /**
   * Inicializa a conexão com o banco de dados, a qual pode ser acessada pelo atributo `$conexao`.
   */
  protected static function init_conexao()
  {
    self::$conexao = gerente_conexao::get_conexao();
  }

  /**
   * Fecha a conexão com o banco de dados.
   */
  public static function fechar_conexao()
  {
    self::$conexao->close();
  }

}