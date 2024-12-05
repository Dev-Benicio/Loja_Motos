<?php

namespace App\Routes;

interface rotas
{
  const ROTAS = [
    'GET' => [
      /* Login */
      '/' => 'login@index',
      '/{query}' => 'login@index',
      '/logout' => 'login@logout',

      '/welcome' => 'welcome@index',
      '/dashboard' => 'dashboard@index',
      '/perfil' => 'perfil@index',

      /* Funcionários */
      '/funcionarios' => 'funcionario@index',
      '/funcionarios/cadastro' => 'funcionario@call_view_cadastro',
      '/funcionarios/edicao/{id}' => 'funcionario@call_view_edicao',

      /* Clientes */
      '/clientes' => 'cliente@index',
      '/clientes/cadastro' => 'cliente@call_view_cadastro',
      '/clientes/edicao/{id}' => 'cliente@call_view_edicao',

      /* Vendas */
      '/vendas' => 'vendas@index',
      '/vendas/cadastro' => 'vendas@call_view_cadastro',

      /* Motos */
      '/motos' => 'moto@index',
      '/motos/cadastro' => 'moto@call_view_cadastro',
      '/motos/edicao/{id}' => 'moto@call_view_edicao',
    ],
    'POST' => [
      '/' => 'login@validar_login',
      '/perfil' => 'perfil@editar',

      /* Funcionários */
      '/funcionarios/cadastro' => 'funcionario@cadastrar',
      '/funcionarios/edicao/{id}' => 'funcionario@editar',

      /* Clientes */
      '/clientes/cadastro' => 'clientes@cadastrar',
      '/clientes/edicao/{id}' => 'clientes@editar',

      /* Vendas */
      '/vendas/cadastro' => 'vendas@cadastrar',
      '/vendas/remocao/{id}' => 'vendas@remover',

      /* Motos */
      '/motos/cadastro' => 'moto@cadastrar',
      '/motos/edicao/{id}' => 'moto@editar',
    ],
  ];
}
