<?php

namespace App\Routes;

interface rotas
{
  const ROTAS = [
    'GET' => [
      '/' => 'login@index',
    ],
    'POST' => [
      '/' => 'login@authenticate',
    ],
  ];
}
