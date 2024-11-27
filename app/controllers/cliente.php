<?php
namespace App\Controllers;   
use App\Controllers\controller;  
class cliente extends controller{
 public function index(){
    $this->call_view("cliente");
  
 }

 public function cadastro()
 {
  $this->call_view("cliente_cadastro");
 }
}