<?php

namespace App\Routes;

interface rotas
{
  const ROTAS = [
    'GET' => [
      '/' => 'login@index',
      '/dashboard' => 'dashboard@index',
      '/welcome' => 'welcome@index',

      /* Funcionários */
      '/funcionarios' => 'funcionario@index',
      '/funcionarios/cadastro' => 'funcionario@cadastro',
      '/funcionarios/lista' => 'funcionario@lista',
      '/funcionarios/edicao/{id}' => 'funcionario@edicao',

      /* Clientes */
      '/clientes' => 'cliente@index',
      '/clientes/cadastro' => 'cliente@cadastro',
      '/clientes/lista' => 'cliente@lista',
      '/clientes/edicao/{id}' => 'cliente@edicao',

      /* Vendas */
      '/vendas' => 'vendas@index',
      '/vendas/cadastro' => 'vendas@cadastro',
      '/vendas/lista' => 'vendas@lista',

      /* Motos */
      '/motos' => 'moto@index',
      '/motos/cadastro' => 'moto@cadastro',
      '/motos/lista' => 'moto@lista',
      '/motos/edicao/{id}' => 'moto@edicao',

      /* Relatórios */
      '/relatorios' => 'relatorios@index',
    ],

    'POST' => [
      '/' => 'login@authenticate',

      /* Funcionários */
      '/funcionarios/cadastro' => 'funcionario@cadastrar',
      '/funcionarios/edicao/{id}' => 'funcionario@editar',

      /* Clientes */
      '/clientes/cadastro' => 'clientes@cadastrar',
      '/clientes/edicao/{id}' => 'clientes@editar',

      /* Vendas */
      '/vendas/cadastro' => 'vendas@cadastrar',
      '/vendas/lista' => 'vendas@listar',

      /* Motos */
      '/motos/cadastro' => 'moto@cadastrar',
      '/motos/edicao/{id}' => 'moto@editar',
    ],
  ];
}
