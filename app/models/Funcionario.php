<?php

use App\helpers\higiene_de_dados;

// Model/Funcionario.php

class funcionario {
  private const campos = [
    "id",
    "nome",
    "cpf",
    "data_nascimento",
    "endereco",
    "telefone",
    "email",
    "cargo",
    "data_admissao",
    "data_demissao",
    "salario",
    "status_funcionario",
    "foto_perfil",
  ];


  public static function create(array $user) {
    banco_de_dados::conectar();

    unset(campos[9]);
    unset(campos[12]);

    $campos = implode(", ", array_map(fn($value) => "'$value'", campos));
    $valores = implode(", ", array_map(
      fn($value) => is_numeric($value) ? "{$value}" : "'{$value}'", $user)
    );

    $query = "INSERT INTO funcionario ({$campos}) VALUES ({$valores})";

    $conexao->query($query);
    banco_de_dados::fechar_conexao();
  }

}