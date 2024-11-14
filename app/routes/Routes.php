<?php

namespace App\Routes;

interface routes
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
