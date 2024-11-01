# Classe para conexão e manipulação do banco de dados

# Conexão com o BD
<?php
        $host= "127.0.0.1";
        $user = "root";
        $pass = "";
        $db_name = "loja_moto";
        $link = mysqli_connect($host, $user, $pass, $db_name);
        
        if (!$link) {
            die("Error!! ". mysqli_error());
        }

# Manipulação de Dados
?>
