<?php

namespace App\routes;

interface Routes
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
