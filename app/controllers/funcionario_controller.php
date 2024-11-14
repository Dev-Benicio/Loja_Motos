<?php
  namespace App\Controllers;
  use App\Models\funcionario;

  class funcionario_controller extends controller {
      public function index(){
        $this->call_view("funcionarios");
      }

      public function cadastrar_funcionario(){
        funcionario::create($_POST);
      }
  }
