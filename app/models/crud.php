<?php

namespace App\Models;

interface crud
{
  public static function create(array $dados): bool;
  public static function read(?int $id): array;
  public static function update(int $id, array $dados): bool;
  public static function delete(int $id): bool;
}