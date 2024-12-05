<?php

namespace App\Models;

use App\Database\gerente_conexao;
use Exception;

class endereco extends model
{
  private const CAMPOS_ENDERECO = [
    'unidade_federativa',
    'cidade',
    'numero',
    'rua'
  ];

  public static function validarSalvarEndereco(array $dados): array
  {
    parent::init_conexao();
    try {
      parent::$conexao->begin_transaction();
      // Filtra e remove os campos que não são de endereço
      $endereco = array_filter(
        array_intersect_key(
          $dados,
          array_flip(self::CAMPOS_ENDERECO)
        ),
        fn($valor) => $valor !== null
      );

      if (empty($endereco)) {
        return [];
      }

      // adiciona endereço de funcionario
      $id_endereco = endereco::create($endereco);

      if ($id_endereco > 0) {
        // Remove os campos de endereço
        foreach (self::CAMPOS_ENDERECO as $campo) {
          unset($dados[$campo]);
        }
        // Adiciona o id_endereco aos dados
        $dados['id_endereco'] = $id_endereco;
        parent::$conexao->commit();
        return $dados;
      }
    } catch (Exception $e) {
      parent::$conexao->rollback();
    }
    return [];
  }

  /**
   * Cria um novo registro de endereço no banco de dados.
   */
  public static function create(array $endereco): int
  {
    parent::init_conexao();
    try {
      parent::$conexao->begin_transaction();
      $colunas = array_keys($endereco);
      // Cria uma string com interrogacoes para cada coluna.
      $interrogacoes = str_repeat('?, ', count($colunas) - 1) . '?';

      $sql = "
        INSERT INTO endereco
          (" . implode(',', $colunas) . ")
        VALUES ({$interrogacoes})
      ";

      $types_bind = gerente_conexao::gerar_types_bind_params(...array_values($endereco));
      $stmt = parent::$conexao->prepare($sql);
      $stmt->bind_param(
        $types_bind,
        ...array_values($endereco)
      );

      // Executa a inserção
      if ($stmt->execute()) {
        $id = parent::$conexao->insert_id;
        parent::$conexao->commit();
        return $id;
      }
      parent::$conexao->rollback();
      return 0;
    } catch (Exception $e) {
      parent::$conexao->rollback();
      return 0;
    }
  }

  public static function update(array $dados): array
  {
    parent::init_conexao();
    try {
      parent::$conexao->begin_transaction();
      // Filtra campos válidos do endereço e remove nulos
      $endereco = array_filter(
        array_intersect_key(
          $dados,
          array_flip(self::CAMPOS_ENDERECO)
        ),
        fn($valor) => $valor !== null
      );

      if (!empty($endereco)) {
        $colunas = array_keys($endereco);
        $set = implode(',', array_map(fn($col) => "{$col} = ?", $colunas));

        $sql = "UPDATE endereco SET {$set} WHERE id_endereco = ?";
        $types_bind = gerente_conexao::gerar_types_bind_params(
          ...array_values($endereco)
        );

        $stmt = parent::$conexao->prepare($sql);
        $stmt->bind_param(
          $types_bind,
          ...array_values($endereco),
          $dados['id_endereco']
        );
        $stmt->execute() ? parent::$conexao->commit() : parent::$conexao->rollback();

        // Remove campos de endereço do array original
        foreach (self::CAMPOS_ENDERECO as $campo) {
          unset($dados[$campo]);
        }
      }
    } catch (Exception $e) {
      parent::$conexao->rollback();
    }
    return $dados;
  }

}