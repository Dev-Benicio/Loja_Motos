<?php

namespace App\Helpers;

class higiene_dados
{
  /**
  * Verifica se os dados são nulos ou vazios
  * @param string ...$data Os dados a serem verificados
  * @return bool Retorna true se os dados são nulos ou vazios, caso contrário, false
  */
  public static function is_null(string ...$data): bool
  {
    foreach ($data as $dado) {
      if (is_null($dado) && empty($dado)) {
        return true;
      }
    }
    return false;
  }

  /**
   * Verifica se os dados são CEP válidos
   * @param string $cep O CEP a ser verificado
   * @return bool Retorna true se os dados são CEP válidos, caso contrário, false
   */
  public static function check_cep(string $cep): bool
  {
    return false;
  }

  /**
   * Formata o endereço para o padrão a ser exibido no site
   * @param array{
   *  cidade: string,
   *  unidade_federativa: string,
   *  rua: string,
   *  numero: int
   * } $endereco
   * @return string Retorna o endereço formatado em uma string
   */
  public static function formatar_endereco(array $endereco): string
  {
    return <<<Endereco
      {$endereco['cidade']} - {$endereco['unidade_federativa']}
      <br>
      <small class="text-secondary">
        {$endereco['rua']} N° {$endereco['numero']}
      </small>
    Endereco;
  }

  /**
   * Formata a data de YYYY-MM-DD para o padrão desejado
   * @param string $data A data a ser formatada
   * @return string Retorna a data formatada
   */
  public static function formatar_data(string $data): string
  {
    $data_formatada = date('d/m/Y', strtotime($data));
    return $data_formatada;
  }

  /**
   * Formata o telefone para o padrão (DD) X.XXXX-XXXX quando o telefone possuir 11 dígitos
   * ou para o padrão (DD) XXXX-XXXX quando o telefone possuir 10 dígitos
   * @param string $telefone O telefone a ser formatado
   * @return string Retorna o telefone formatado
   */
  public static function formatar_telefone(string $telefone): string
  {
    $tamanho_telefone = strlen($telefone);

    if ($tamanho_telefone === 11) {
      $regex_telefone = '/^(\d{2})(9)(\d{4})(\d{4})$/';
      $replacement = '($1) $2.$3-$4';
    } else if ($tamanho_telefone === 10) {
      $regex_telefone = '/^(\d{2})(\d{4})(\d{4})$/';
      $replacement = '($1) $2-$3';
    } else {
      return $telefone;
    }

    $telefone_formatado = preg_replace($regex_telefone, $replacement, $telefone);
    return $telefone_formatado;
  }

  /**
   * Formata o CPF para o padrão XXX.XXX.XXX-XX
   * @param string $cpf O CPF a ser formatado
   * @return string Retorna o CPF formatado
   */
  public static function formatar_cpf(string $cpf): string
  {
    $regex_cpf = '/(\d{3})(\d{3})(\d{3})(\d{2})/';
    $cpf_formatado = preg_replace($regex_cpf, '$1.$2.$3-$4', $cpf);
    return $cpf_formatado;
  }

}