<?php

# Interface com as rotas do projeto
interface Routes
{
  const ROUTES = [
    'GET' => [
      '/' => 'Login@index',
    ],
    'POST' => [ 
      '/' => 'Login@authenticate',
    ],
  ];
}
