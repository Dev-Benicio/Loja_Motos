<?php

namespace App\Controllers;

use App\Models\login;

class login_controller extends controller {
    public function index() {
        $this->call_view("login");
    }

    public function valida_login() {
        $user = $_POST["user"];
        $password = $_POST["password"];
        
        $is_login_valido = login::autenticar($user, $password);
        $is_login_valido ? header("Location: /dashboard") : header("Location: /");
    }
    //  Hello Word
}
