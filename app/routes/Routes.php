<?php

namespace App\Routes;

interface routes
{
  const ROTAS = [
    'GET' => [
      '/' => 'Login@index',
    ],
    'POST' => [
      '/' => 'Login@authenticate',
    ],
  ];
}
