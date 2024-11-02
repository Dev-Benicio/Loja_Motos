<?PHP

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
