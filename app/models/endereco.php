<?php

namespace App\Models;

use App\Database\gerente_conexao;
use App\Helpers\higiene_dados;
use Exception;

class endereco extends model
{
  const CAMPOS_ENDERECO = [
    'cep',
    'cidade',
    'unidade_federativa',
    'rua',
    'numero'
  ];

  public static function validarSalvarEndereco(array $dados): array
  {
    parent::init_conexao();

    try {
      parent::$conexao->begin_transaction();

      // Busca dados do CEP na API
      $dadosAPI = self::get_endereco_por_cep($dados['cep']);

      // Monta array com dados do endereço
      $endereco = [
        'unidade_federativa' => $dadosAPI['state'],
        'cidade' => $dadosAPI['city'],
        'numero' => $dados['numero'], // Número vem do formulário
        'rua' => $dadosAPI['street'],
        'cep' => $dadosAPI['cep']
      ];

      // Filtra campos válidos
      $endereco = array_filter(
        array_intersect_key(
          $endereco,
          array_flip(self::CAMPOS_ENDERECO)
        ),
        fn($valor) => $valor !== null
      );

      if (empty($endereco)) {
        return [];
      }

      $id_endereco = endereco::create($endereco);

      if ($id_endereco > 0) {
        foreach (self::CAMPOS_ENDERECO as $campo) {
          unset($dados[$campo]);
        }
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

      $types_bind = gerente_conexao::gerar_types_bind_params(...$endereco);
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

      $id_endereco = $dados['id_endereco'];

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

        // Preparamos os valores na ordem correta
        $valores = array_values($endereco);
        $valores[] = $id_endereco;

        // Geramos os tipos baseados nos valores
        $types = str_repeat('s', count($valores) - 1) . 'i';

        $stmt = parent::$conexao->prepare($sql);
        $stmt->bind_param($types, ...$valores);

        if ($stmt->execute()) {
          parent::$conexao->commit();
        } else {
          parent::$conexao->rollback();
        }

        // Remove campos de endereço do array original
        foreach (self::CAMPOS_ENDERECO as $campo) {
          unset($dados[$campo]);
        }
      }

      $dados['id_endereco'] = $id_endereco;
    } catch (Exception $e) {
      parent::$conexao->rollback();
    }

    return $dados;
  }

  /**
   * Pega o endereço por CEP
   * @param string $cep O CEP a ser pesquisado
   * @return array Retorna o endereço em formato de array
   */
  public static function get_endereco_por_cep(string $cep): array
  {
    // Limpa o CEP mantendo apenas números
    $cep = preg_replace('/[^0-9]/', '', $cep);

    // Valida o CEP
    if (higiene_dados::check_cep($cep)) {
      return [];
    }

    try {
      $url = "https://brasilapi.com.br/api/cep/v1/{$cep}";
      $contexto = stream_context_create([
        'http' => [
          'timeout' => 5,
          'method' => 'GET'
        ]
      ]);
      $response = file_get_contents($url, false, $contexto);

      if ($response === false) {
        return [];
      }

      $dados = json_decode($response, true);
      return $dados ?: [];
    } catch (Exception $e) {
      return [];
    }
  }
}
