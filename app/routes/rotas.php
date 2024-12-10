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
      '/vendas/carrinho' => 'venda@call_carrinho_view',
      '/vendas/adicionar/{id}' => 'venda@adicionar_moto_ao_carrinho',
      '/vendas/remover/{id}' => 'venda@remover_moto_do_carrinho',

      '/motos' => 'moto@index',
      '/motos/cadastro' => 'moto@call_view_cadastro',
      '/motos/edicao/{id}' => 'moto@call_view_edicao',
    ],
    'POST' => [
      '/' => 'login@validar_login',
      '/{query}' => 'login@validar_login',
      '/perfil' => 'perfil@editar',

      '/funcionarios/cadastro' => 'funcionario@cadastrar',
      '/funcionarios/edicao/{id}' => 'funcionario@editar',

      '/clientes/cadastro' => 'cliente@cadastrar',
      '/clientes/edicao/{id}' => 'cliente@editar',

      '/vendas/cadastro' => 'venda@cadastrar',

      '/motos/cadastro' => 'moto@cadastrar',
      '/motos/edicao/{id}' => 'moto@editar',
    ],
  ];
}