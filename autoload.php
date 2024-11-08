<?php

/* 
* Autoload de classes
* Carrega automaticamente as classes do sistema. Quando quiser usar uma classe,
* basta chamar com o comando use 'App\Pasta\nome_da_classe';
*/

spl_autoload_register(
  function (string $classNamePath) {
    $fullPath = str_replace(
      search: "App\\",
      replace: "app\\",
      subject: $classNamePath
    );

    $pathFile = str_replace(
      search: "\\",
      replace: DIRECTORY_SEPARATOR,
      subject: $fullPath
    );

    $pathFile .= ".php";
    file_exists($pathFile) && require_once $pathFile;
  }
);
