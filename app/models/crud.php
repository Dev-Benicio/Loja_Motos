<?php

namespace App\Models;

use mysqli_result;

interface crud
{
  public static function create(array $dados): bool;
  public static function read(?int $id): mysqli_result;
  public static function update(int $id, array $dados): bool;
  public static function delete(int $id): bool;
}