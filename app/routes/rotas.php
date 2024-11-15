<?php

namespace App\Routes;

interface rotas
{
  const ROTAS = [
    'GET' => [
      '/' => 'login_controller@index',
      '/dashboard' => 'dashboard@index',
        
    ],
    'POST' => [
      '/' => 'login_controller@valida_login',
    ],
  ];
}
