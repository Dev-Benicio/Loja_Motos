<?php

namespace App\Routes;

interface rotas
{
  const ROTAS = [
    'GET' => [
      '/' => 'login@index',
      '/{query}' => 'login@index',
      '/logout' => 'login@logout',

      '/welcome' => 'welcome@index',
      '/dashboard' => 'dashboard@index',

      '/perfil' => 'funcionario@call_view_perfil',

      '/funcionarios' => 'funcionario@index',
      '/funcionarios/cadastro' => 'funcionario@call_view_cadastro',
      '/funcionarios/edicao/{id}' => 'funcionario@call_view_edicao',

      '/clientes' => 'cliente@index',
      '/clientes/cadastro' => 'cliente@call_view_cadastro',
      '/clientes/edicao/{id}' => 'cliente@call_view_edicao',

      '/vendas' => 'venda@index',
      '/vendas/cadastro' => 'venda@call_view_cadastro',

      '/motos' => 'moto@index',
      '/motos/cadastro' => 'moto@call_view_cadastro',
      '/motos/edicao/{id}' => 'moto@call_view_edicao',
    ],
    'POST' => [
      '/' => 'login@validar_login',
      '/perfil' => 'perfil@editar',

      '/funcionarios/cadastro' => 'funcionario@cadastrar',
      '/funcionarios/edicao/{id}' => 'funcionario@editar',

      '/clientes/cadastro' => 'clientes@cadastrar',
      '/clientes/edicao/{id}' => 'clientes@editar',

      '/vendas/cadastro' => 'venda@cadastrar',
      '/vendas/remocao/{id}' => 'venda@remover',

      '/motos/cadastro' => 'moto@cadastrar',
      '/motos/edicao/{id}' => 'moto@editar',
    ],
  ];
}