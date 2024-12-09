<?php

namespace App\Controllers;

use App\Controllers\controller;

class funcionario extends controller
{
   public function index()
   {
      $this->call_view("funcionario");
   }

   public function cadastro()
   {
      $this->call_view("funcionario_cadastro");
   }
  
   
}