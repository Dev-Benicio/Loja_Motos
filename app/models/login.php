<?php

namespace App\Models;

use App\Database\gerente_conexao;
use mysqli_sql_exception;

class login extends model
{
  private static array $credenciais = [
    "id" => null,
    "nome" => null,
    "cargo" => null,
  ];

  /**
   * Autentica os credenciais do usuário. Quando autenticado com sucesso, define os valores do atributo $credenciais que podem ser acessados pelo método `get_credenciais()`.
   * @param string $user Nome de usuário.
   * @param string $password Senha do usuário.
   * @return bool Retorna true se as credenciais do usuário forem válidas, false caso contrário.
   */
  public static function autenticar(string $user, string $password): bool
  {
    parent::init_conexao();
    try {
      $sql = "SELECT * FROM funcionario WHERE login = ? AND senha = ?";

      $stmt = parent::$conexao->prepare($sql);
      $stmt->bind_param("ss", $user, $password);
      $stmt->execute();
      $resultado = $stmt->get_result();

      if ($resultado->num_rows === 1) {
        $credenciais = $resultado->fetch_assoc();
        self::set_credenciais($credenciais);
        return true;
      }
    } catch (mysqli_sql_exception $e) {
      echo "
        <script>
          console.error('Erro: " . addslashes($e->getMessage()) . "');
        </script>
      ";
    }
    parent::$conexao->close();
    return false;
  }

  /**
   * Defini os valores do atributo $credenciais.
   * @param array{
   *   id: int,
   *   nome: string,
   *   cargo: string
   * } $credenciais Array contendo os dados do usuário.
   */
  private static function set_credenciais(array $credenciais): void
  {
    [
      "id" => self::$credenciais["id"],
      "nome" => self::$credenciais["nome"],
      "cargo" => self::$credenciais["cargo"],
    ] = $credenciais;
  }

  /**
   * Retorna o atributo $credenciais.
   * @return array{
   *   id: int,
   *   nome: string,
   *   cargo: string
   * }
   */
  public static function get_credenciais(): array
  {
    return self::$credenciais;
  }

}